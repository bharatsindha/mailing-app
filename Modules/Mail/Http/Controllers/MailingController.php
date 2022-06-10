<?php

namespace Modules\Mail\Http\Controllers;

use App\Facades\General;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Google_Service_Oauth2;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Domain\Entities\Domain;
use Modules\Mail\Entities\Compose;
use Modules\Mail\Entities\Session;
use Throwable;

class MailingController extends Controller
{

    /**
     * Start sending mail
     *
     * @param Session $session
     * @return Factory|View
     */
    public function startMailing(Session $session)
    {
        $session->is_completed = Session::IN_PROCESS;
        $session->save();

        return view('mail::send', compact('session'));
    }


    /**
     * Get pending email of the session
     *
     * @param $sessionId
     * @return mixed
     */
    public function getEmail($sessionId)
    {
        try {
            $session = Session::getPendingSessionData($sessionId);
            $status = is_null($session['composes_pending']) ? 'completed' : 'pending';
            if ($status == 'completed') {
                $sObj = Session::find($sessionId);
                $sObj->is_completed = Session::COMPLETED;
                $sObj->total_sent = $sObj->composesSent()->count();
                $sObj->save();
            }

            return response()->json(['status' => $status, 'session' => $session]);
        } catch (Throwable $e) {
            return response()->json('Failed to fetch session. Please try again.', 500);
        }

    }

    /**
     * Send email
     *
     * @param Session $session
     * @return JsonResponse
     */
    public function sendEmail(Session $session)
    {
        session_start();

        $sessionData = null;

        $clientId = $session->domain->client_id;
        $clientSecret = $session->domain->client_secret;
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

        $service = new Google_Service_Oauth2($client);
        $user = $service->userinfo->get();
        $senderEmail = $user->email;
        $senderName = $user->name;

        $sessionData = Session::getPendingSessionData($session->id);

        $status = is_null($sessionData['composes_pending']) ? 'completed' : 'pending';
        if ($status == 'completed') {
            $sObj = Session::find($session->id);
            $sObj->send_status = Session::SEND_COMPLETED;
            $sObj->total_sent = $sObj->composesSent()->count();
            $sObj->save();

            goto End;
        }

        $composeData = $sessionData['composes_pending'];
        $composeId = $composeData["id"];
        $receiverEmailId = trim($composeData["to"]);
        $receiverCc = trim($composeData["cc"]);
        $receiverBcc = trim($composeData["bcc"]);
        $receiverFirstName = trim($composeData["first_name"]);
        $receiverLastName = trim($composeData["last_name"]);
        $companyName = $composeData["company_name"];
        $designation = $composeData["designation"];
        $projectName = $composeData["project_name"];

        $subject = stripslashes(stripslashes(stripslashes($sessionData["subject"])));
        $mailContent = stripslashes($sessionData["mail_content"]);

        if (empty($receiverEmailId) || is_null($receiverEmailId)) {
            $status = 'receiverEmailNotFound';
            goto End;
        }

        $totalBlock = substr_count($mailContent, '<blockquote>');
        $gradient = array("Aqua", "Aquamarine", "Black", "Blue", "BlueViolet", "Brown", "CadetBlue", "DarkBlue", "DarkCyan", "DarkGreen", "DarkMagenta");

        for ($i = 0; $i < $totalBlock; $i++) {
            $randKeys = array_rand($gradient, 2);
            $blockData = '<blockquote style="margin:0 0 0 .8ex;border-left:1px ' . $gradient[$randKeys[0]] . ' solid;padding-left:1ex">';
            $from = '/' . preg_quote("<blockquote>", '/') . '/';
            $mailContent = preg_replace($from, $blockData, $mailContent, 1);
        }

        $strMailContent = "$mailContent";
        $strMailContent = str_replace("{{firstName}}", $receiverFirstName, $strMailContent);
        $strMailContent = str_replace("{{lastName}}", $receiverLastName, $strMailContent);
        $strMailContent = str_replace("{{company}}", $companyName, $strMailContent);
        $strMailContent = str_replace("{{designation}}", $designation, $strMailContent);
        $strMailContent = str_replace("{{project}}", $projectName, $strMailContent);

        // $emailIdEncrypt = General::encryptDecrypt('encrypt', $receiverEmailId);

        /*$strMailContent = str_replace("unsubscribe", '<a href="' .
            route('email.unsubscribe', $emailIdEncrypt) . '" style="text-decoration: none;">
            <img src="' . route('unsubscribe.img', ['person' => $personId, 'compose' => $composeId]) . '"
            alt="unsubscribe">', $strMailContent);*/

        $openTrackContent = '<img src="' . route('openTrack.img', $composeId) . '" alt="unsubscribe">';

        $strSubject = $subject;
        $strSubject = str_replace("{{firstName}}", $receiverFirstName, $strSubject);
        $strSubject = str_replace("{{lastName}}", $receiverLastName, $strSubject);
        $strSubject = str_replace("{{company}}", $companyName, $strSubject);
        $strSubject = str_replace("{{designation}}", $designation, $strSubject);
        $strSubject = str_replace("{{project}}", $projectName, $strSubject);

        $strRawMessage = "";
        $boundary = uniqid(rand(), true);
        $boundarySub = uniqid(rand(), true);
        $subjectCharset = $charset = 'utf-8';

        $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
        $strRawMessage .= 'To: ' . General::encodeRecipients($receiverFirstName . ' ' . $receiverLastName .
                " <" . $receiverEmailId . ">") . "\r\n";

        if (!is_null($receiverCc) && !empty($receiverCc)) {
            $strRawMessage .= 'Cc: ' . General::encodeRecipients($receiverCc) . "\r\n";
        }
        if (!is_null($receiverBcc) && !empty($receiverBcc)) {
            $strRawMessage .= 'Bcc: ' . General::encodeRecipients($receiverBcc) . "\r\n";
        }
        $strRawMessage .= 'From: ' . General::encodeRecipients($senderName . " <" . $senderEmail . ">") . "\r\n";

        $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
        $strRawMessage .= 'Content-type: Multipart/mixed; boundary=' . $boundary . "\r\n";
        $strRawMessage .= "\r\n--{$boundary}\r\n";
        $strRawMessage .= 'Content-type: Multipart/alternative; boundary=' . $boundarySub . "\r\n";
        $strRawMessage .= "\r\n--{$boundarySub}\r\n";
        $strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n";
        $strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
        $strRawMessage .= strip_tags($strMailContent) . $openTrackContent . "\r\n";
        $strRawMessage .= "\r\n--{$boundarySub}\r\n";
        $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
        $strRawMessage .= "\n\n" . $strMailContent . "\r\n";
        $strRawMessage .= "\r\n--{$boundarySub}--\r\n";
        $strRawMessage .= "\r\n--{$boundary}\r\n";
        $strRawMessage .= '--' . $boundary . "--\r\n";

        try {
            $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
            $msg = new Google_Service_Gmail_Message();
            $msg->setRaw($mime);
            $message = $gmail->users_messages->send('me', $msg);

            if ($message->getId()) {
                $compose = Compose::find($composeId);
                $compose->status = Compose::SENT;
                $compose->send_date = date('Y-m-d H:i:s');
                $compose->save();
            }

            $status = 'sent';
            goto End;
        } catch (Throwable $e) {
            $status = 'error';
            goto End;
        }

        End:{
        return response()->json(['status' => $status, 'session' => $sessionData]);
    }
    }

    public function emailOpenTrack(Compose $compose)
    {
        $compose->status = Compose::OPENED;
        $compose->save();

        //ToDo: add logic to redirect to image
    }

    /**
     * Redirect to GMail login and update the login session
     *
     * @return RedirectResponse
     */
    public function reConnectGMail()
    {
        session_start(); //session start

        $domainId = 0;
        if (isset($_COOKIE['tempDomainId'])) $domainId = $_COOKIE['tempDomainId'];

        $credential = Domain::getDomainCredential($domainId);

        $clientId = $credential['client_id'];
        $clientSecret = $credential['client_secret'];
        $redirectUri = route('admin.mail.reConnect');

        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->setScopes(array('https://mail.google.com/', 'email'));
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $client->fetchAccessTokenWithAuthCode($_GET['code']);
            \Illuminate\Support\Facades\Session::put('access_token', $client->getAccessToken());
        }
        if (\Illuminate\Support\Facades\Session::has('access_token'))
            $client->setAccessToken(\Illuminate\Support\Facades\Session::get('access_token'));
        else
            $authUrl = $client->createAuthUrl();

        if ($client->isAccessTokenExpired())
            $authUrl = $client->createAuthUrl();

        if (isset($authUrl)) {
            return Redirect::to($authUrl);
        } else {

            echo "connected";
            echo "<script>
                    if (window.opener != null && !window.opener.closed) {
                        window.close();
                    }
            </script>";
        }
    }

    /**
     * Redirect to GMail login and update the login session
     *
     * @param Domain $domain
     * @return RedirectResponse
     */
    public function connection(Domain $domain)
    {
        try {
            session_start();

            $domainId = 0;
            if (isset($_COOKIE['tempDomainId'])) $domainId = $_COOKIE['tempDomainId'];

            $credential = Domain::getDomainCredential($domainId);

            $clientId = $credential['client_id'];
            $clientSecret = $credential['client_secret'];
            $redirectUri = route('admin.mail.connection');

            $client = new Google_Client();
            $client->setClientId($clientId);
            $client->setClientSecret($clientSecret);
            $client->setRedirectUri($redirectUri);

            $client->setScopes(array('https://mail.google.com/', 'email'));
            $client->addScope("profile");

            if (isset($_GET['code'])) {
                $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
                exit;
            }

            if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
                $client->setAccessToken($_SESSION['access_token']);
            else $authUrl = $client->createAuthUrl();

            if ($client->isAccessTokenExpired()) $authUrl = $client->createAuthUrl();

            if (isset($authUrl)) {
                return Redirect::to($authUrl);
            } else {
                $service = new Google_Service_Oauth2($client);
                $user = $service->userinfo->get();
                $senderEmail = $user->email;

                echo "<input type='hidden' id='connectedSenderEmail' value='" . $senderEmail . "'>";
                echo "connected";
                echo "<script>
                  if (window.opener != null && !window.opener.closed) {
                    let currentSessionIdOpener = window.opener.document.getElementById('currentSessionId').value;
                    let currentSenderEmailOpener = window.opener.document.getElementById('currentSenderEmail').value;
                    let connectedSenderEmail = document.getElementById('connectedSenderEmail').value;

                    if(currentSenderEmailOpener === connectedSenderEmail){
                      let redirectLink = '" . route('admin.mail.startMailing', 'SESSION_ID') . "';
                      redirectLink = redirectLink.replace('SESSION_ID', currentSessionIdOpener);
                      window.opener.open(redirectLink,'_blank');
                    }else{
                      alert('Logged In Email ID is different than Sender Email ID.Please login with '+
                      currentSenderEmailOpener+' Email ID.');
                      window.opener.location.href = '" . route('admin.drafts.index') . "?logout=1';
                    }

                    window.close();
                  }
                </script>";

            }

        } catch (Throwable $e) {
            dd($e->getMessage());
        }
    }

}
