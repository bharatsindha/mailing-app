<?php

namespace Modules\Mail\Http\Controllers;

use Illuminate\Routing\Controller;

class MailingController extends Controller
{


    public function connection()
    {
        try {

            session_start();
            $clientId = env("GMAIL_CLIENT_ID", "");
            $clientSecret = env("GMAIL_CLIENT_SECRET", "");
            $redirectUri = route('gmail.connection');

            $client = new Google_Client();
            $client->setClientId($clientId);
            $client->setClientSecret($clientSecret);
            $client->setRedirectUri($redirectUri);

            $client->setScopes(array('https://mail.google.com/', 'email'));
            $client->addScope("profile");

            if (isset($_GET['code'])) {
                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
                exit;
            }

            if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                $client->setAccessToken($_SESSION['access_token']);
            } else {
                $authUrl = $client->createAuthUrl();
            }
            if ($client->isAccessTokenExpired()) {

                $authUrl = $client->createAuthUrl();
            }

            if (isset($authUrl)) {
                return Redirect::to($authUrl);
            } else {
                $service = new Google_Service_Oauth2($client);
                $user = $service->userinfo->get();
                $senderEmail = $user->email;

                echo "<input type='hidden' id='sender_email_temp' value='" . $senderEmail . "'>";
                echo "connected";
                echo "<script>
                  if (window.opener != null && !window.opener.closed) {
                    let currentSessionId2 = window.opener.document.getElementById('current_session_id').value;
                    let currentSenderEmail2 = window.opener.document.getElementById('current_sender_email').value;
                    let email2 = document.getElementById('sender_email_temp').value;

                    if(currentSenderEmail2 === email2){
                      let red_link = '" . route('admin.mail.send-email') . "?session_id='+currentSessionId2;
                      window.opener.open(red_link,'_blank');
                    }else{
                      alert('Logged In Email ID is different than Sender Email ID.PLease login with '+currentSenderEmail2+' Email ID.');
                      window.opener.location.href = '" . route('admin.mail.draft-list') . "?logout=1';
                    }

                    window.close();
                  }
                </script>";

            }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
