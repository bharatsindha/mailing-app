<?php

namespace Modules\Mail\Http\Controllers;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Oauth2;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Email\Entities\Email;
use Modules\Mail\Entities\Compose;
use Modules\Mail\Entities\Session;
use Throwable;

class BounceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if (isset($request->logout)) {
            \Illuminate\Support\Facades\Session::forget('access_token');
        }

        if (!(request()->ajax())) {
            return view('mail::bounceTrack');
        }

        $results = Email::getAllEmails()->paginate(15);

        return view('mail::bounceTrackAjax', compact('results'));
    }

    public function bounceTracking(Email $email)
    {

        $clientId = $email->domain->client_id;
        $clientSecret = $email->domain->client_secret;
        $redirectUri = route('admin.mail.reConnect');

        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);

        $client->setScopes(array('https://mail.google.com/', 'email'));
        $client->addScope("profile");

        $gmail = new Google_Service_Gmail($client);

        if (\Illuminate\Support\Facades\Session::has('access_token'))
            $client->setAccessToken(\Illuminate\Support\Facades\Session::get('access_token'));
        else
            $authUrl = $client->createAuthUrl();

        if ($client->isAccessTokenExpired()) $authUrl = $client->createAuthUrl();

        if (isset($authUrl)) {
            $status = "notConnected";
            goto End;
        }

        /*$service = new Google_Service_Oauth2($client);
        $user = $service->userinfo->get();
        $senderEmail = $user->email;
        $senderName = $user->name;*/

        try {
            $searchFilter = '';
            $lastTrackDate = $email->bounce_track_date;
            $before = Carbon::today()->addDays(2)->timestamp;
            $updatedTrackDate = Carbon::today()->toDateTimeString();

            if ($lastTrackDate != '' && $lastTrackDate != '0000-00-00 00:00:00' && $lastTrackDate != null) {
                if (Carbon::parse($lastTrackDate)->toDateString() != '1970-01-01') {
                    $after = Carbon::parse($lastTrackDate)->timestamp;
                    $searchFilter = "after:$after before:$before";
                }
            }

            if (empty($searchFilter) && !is_null($email->firstSession)) {
                $after = Carbon::parse($email->firstSession->created_at)->timestamp;
                $searchFilter = "after:$after before:$before";
            }

            if (empty($searchFilter)) {
                $after = Carbon::today()->timestamp;
                $searchFilter = "after:$after before:$before";
            }

            $threads = $this->listThreads($gmail, 'me', $searchFilter);

//            dd($threads);

            if (count($threads) > 0) {
                foreach ($threads as $vThread) {
                    try {
                        $thread = $this->getThread($gmail, 'me', $vThread->id);

                        if (count($thread) == 0) {
                            sleep(5);
                            continue;
                        }

                        $messages = $thread->getMessages();
                    } catch (Throwable $e) {
                        sleep(5);
                        continue;
                    }

                    if (count($messages) > 1) {
                        try {

                            $primaryReceiverEmail = '';
                            $primarySenderEmail = '';
                            $initial = 0;

                            foreach ($messages as $message) {
                                try {
                                    $sentLabelStatus = 0;
                                    $decodedMessage = '';

                                    $headers = $message->getPayload()->getHeaders();
                                    $parts = $message->getPayload()->getParts();
                                    $headerArray = $this->getHeaderArray($headers);
                                    $getLabelIds = $message->getLabelIds();

                                    $from = addslashes((empty($headerArray['From']) ? '' : $headerArray['From']));
                                    $to = addslashes((empty($headerArray['To']) ? '' : $headerArray['To']));

                                    if ($initial == 0) {
                                        foreach ($getLabelIds as $labelName) {
                                            if (strpos($labelName, "SENT") !== false) {
                                                $initial++;
                                                $sentLabelStatus = 1;
                                                break;
                                            }
                                        }
                                    }

                                    if ($sentLabelStatus == 1) {
                                        $primaryReceiverEmail = $this->filterEmailAddress($to)[1];
                                        $primarySenderEmail = $this->filterEmailAddress($from)[1];
                                    }

                                    $receiverEmailId = $this->filterEmailAddress($to)[1];
                                    $senderEmailId = $this->filterEmailAddress($from)[1];

                                    $body = $parts[0]['body'];
                                    $rawData2 = $body->data;
                                    if ($rawData2 == '') $body = $parts[0]['parts'][1]['body'];

                                    if (empty($parts)) $body = $message->getPayload()->getBody();

                                    if (!$decodedMessage) {
                                        $bodyArr = $this->getBody($parts);
                                        $decodedMessage = $bodyArr[0];
                                    }

                                    $foundBody = FALSE;
                                    if (!$decodedMessage) {
                                        foreach ($parts as $part) {
                                            if ($part['parts'] && !$foundBody) {
                                                foreach ($part['parts'] as $p) {
                                                    if ($p['parts'] && count($p['parts']) > 0) {
                                                        foreach ($p['parts'] as $y) {
                                                            if (($y['mimeType'] === 'text/html') && $y['body']) {
                                                                $foundBody = $this->decodeBody($y['body']->data);
                                                                break;
                                                            }
                                                        }
                                                    } else if (($p['mimeType'] === 'text/html') && $p['body']) {
                                                        $foundBody = $this->decodeBody($p['body']->data);
                                                        break;
                                                    }
                                                }
                                            }
                                            if ($foundBody) {
                                                break;
                                            }
                                        }
                                        $decodedMessage = $foundBody;
                                    }

                                    if (!$decodedMessage && $body->data != '') $decodedMessage = $this->decodeBody($body->data);

                                    $primaryReceiverDomain = explode("@", $primaryReceiverEmail)[1];
                                    $bounceUpdateStatus = 0;

                                    if (trim($primarySenderEmail) == trim($receiverEmailId)) {

                                        $senderDomain = explode("@", $senderEmailId)[1];
                                        $senderName = trim(strtolower(explode("@", $senderEmailId)[0]));

                                        if ((trim($primaryReceiverDomain) != trim($senderDomain)) || $senderName == 'postmaster') {
                                            //$bounceSubjectLineArr = array('550-5.1.1','550 5.1.1','550 5.4.1','503 5.5.2','550 5.1.0','550','553','500','510','511','512','513','514','515','516','517','518','523','524','530','532','533','534','540','541','542','543','544','546','547','550','551','552','554','555','560','561','562','563','564','565','570','571','572','573','574','575','576','577');
                                            //'Message blocked','Message not delivered'
                                            //doubt response code 451
                                            //553-Message not delivered ,,,Message Rejected with SMTP Code 554
                                            $bounceSubjectLineArr = array('550-5.1.1', '550 5.1.1', '550 5.4.1', '503 5.5.2', '550 5.1.0', '550',
                                                '553 ', 'Address not found', 'Delivery incomplete', '554 ', '454 4.7.1',
                                                'The recipient server did not accept our requests to connect', '542 ', '500 5.0.0', '503 ',
                                                '551 ', '557 ', '552 ', '521 ', '530 5.7.1', '530 ', '501 5.7.1', '555 5.5.2',
                                                'Internal parse error: Illegal envelope To: address');
                                            //$bounceSubjectLineArr = array('550-5.1.1','550 5.1.1','550 5.4.1','503 5.5.2','550 5.1.0','550','553');
                                            foreach ($bounceSubjectLineArr as $bounceSubjectLine) {
                                                if (strpos($decodedMessage, $bounceSubjectLine) !== FALSE) {
                                                    $bounceUpdateStatus = 1;
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    if ($bounceUpdateStatus == 1) {
                                        Compose::where('email_id', $email->id)
                                            ->where('to', $primaryReceiverEmail)
                                            ->where('status', '>', 0)
                                            ->update(['status' => Compose::BOUNCED]);
                                    }

                                } catch (Throwable $e) {
                                    continue;
                                }
                            }
                        } catch (Throwable $e) {
                            continue;
                        }
                    }
                }
            }

            $email->bounce_track_date = $updatedTrackDate;
            $email->save();

            $status = 'success';
            goto End;
        } catch (Throwable $e) {
            dd($e->getMessage());
            $status = 'error';
            goto End;
        }

        End:{
        return response()->json(['status' => $status, 'session' => '']);
    }
    }

    /**
     * Get the list of threads
     *
     * @param $service
     * @param $userId
     * @param $searchFilter
     * @return array
     */
    public function listThreads($service, $userId, $searchFilter)
    {
        $threads = array();
        $pageToken = NULL;

        do {
            try {
                $optParam = array();

                if ($pageToken) {
                    $optParam['pageToken'] = $pageToken;
                }

                $optParam['maxResults'] = 500;
                $optParam['q'] = $searchFilter;
                $threadsResponse = $service->users_threads->listUsersThreads($userId, $optParam);

                if ($threadsResponse->getThreads()) {
                    $threads = array_merge($threads, $threadsResponse->getThreads());
                    $pageToken = $threadsResponse->getNextPageToken();
                }

            } catch (Throwable $e) {
                $pageToken = NULL;
            }
        } while ($pageToken);

        return $threads;
    }

    /**
     * Get the thread
     *
     * @param $service
     * @param $userId
     * @param $threadId
     * @return mixed
     */
    public function getThread($service, $userId, $threadId)
    {
        try {
            return $service->users_threads->get($userId, $threadId);
        } catch (Throwable $e) {

        }
    }

    /**
     * @param $header
     * @return array
     */
    public function getHeaderArray($header)
    {
        $outArr = array();

        foreach ($header as $key => $val) {
            $outArr[$val->name] = $val->value;
        }

        return $outArr;
    }

    /**
     * Filter email address
     *
     * @param $string
     * @return array
     */
    public function filterEmailAddress($string)
    {
        $personArray = [];

        $name = 'No name';
        $email = $string;

        $emailArray = explode("<", $string);
        if (count($emailArray) > 1) {
            $name = $emailArray[0];
            $emailAddressArray = explode(">", $emailArray[1]);
            $email = $emailAddressArray[0];
        }

        $personArray[] = $name;
        $personArray[] = $email;

        return $personArray;
    }

    /**
     * Get body
     *
     * @param $parts
     * @return array
     */
    function getBody($parts)
    {
        $outArr = array();
        $i = 0;

        foreach ($parts as $key => $val) {
            if ($i == 0) {
                $i++;
                continue;
            }

            $outArr[] = $this->base64UrlDecode($val->getBody()->getData());
            break;
        }

        return $outArr;
    }

    /**
     * @param $data
     * @return false|string
     */
    public function base64UrlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    /**
     * Decode body
     *
     * @param $body
     * @return bool|false|string
     */
    public function decodeBody($body)
    {
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }
}
