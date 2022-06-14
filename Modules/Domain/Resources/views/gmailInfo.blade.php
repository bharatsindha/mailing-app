<div class="gmail-config">
    <h2 class="h5 mb-2 mt-4 fw-bold text-secondary">Enable GMail API for the domain:</h2>
    <p class="text-dark">Any application that calls GMail APIs needs to be enabled in the API Console.</p>
    <p>To enable an API for the domain:</p>
    <ul>
        <li>
            <a href="https://console.developers.google.com/apis/library" target="_blank"><b>Open the API Library</b></a>
            in the Google API Console.
        </li>
        <li>If prompted, select a project, or create a new one.</li>
        <li>The API Library lists all available APIs. Search the GMail API to find it.</li>
        <li>Select the GMail API, then click the Enable button.</li>
        <li>If prompted, read and accept the API's Terms of Service.</li>
    </ul>

    <h5 class="mt-4 text-secondary">Create authorization credentials:</h5>
    <p>Any application that uses OAuth 2.0 to access GMail API must have authorization credentials that identify the
        application to Google's OAuth 2.0 server. The following steps explain how to create credentials for the domain.
        Then add the credentials(Client ID & Client Secret) below to access API for sending email, bounce tracking for
        the domain.</p>
    <ul>
        <li>
            To create an OAuth client ID, you must first configure your <b>consent screen</b>. Please follow below steps
            to configure it:
            <ul>
                <li>Go to the
                    <a href="https://console.cloud.google.com/apis/credentials/consent" target="_blank">
                        <b> OAuth consent screen.</b></a>
                </li>
                <li><b>Internal</b> User Type.</li>
                <li>Click <b>Create.</b></li>
                <li>Fill in the form and click <b>Save and continue.</b></li>
                <li>Click to <b>Add or remove scopes</b> button.</li>
                <li>Select this scope: <code>https://mail.google.com/</code> then click <b>Save and continue.</b></li>
            </ul>
        </li>
        <li>Then go to the
            <a href="https://console.developers.google.com/apis/credentials" target="_blank">
                <b>Credentials page.</b></a>
        </li>
        <li>Click <b>Create credentials > OAuth client ID.</b></li>

        <li>Select the <b>Web application</b> application type.</li>
        <li>Fill in the form and click Create. Specify the below authorized redirect URIs. The redirect URIs are the
            endpoints to which the OAuth 2.0 server can send responses. <br>
            <code>http://127.0.0.1:8000/mail/connection</code><br>
            <code>http://127.0.0.1:8000/mail/reConnect</code>
        </li>
        <li>After creating your credentials, copy <b>Client ID</b> & <b>Client secret</b> below in the form.</li>
    </ul>

</div>
