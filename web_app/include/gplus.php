<?php

require_once 'dbhelper.inc.php';

class Gplus
{
    public $clientID = '724273083219-jmbi4q81d33hhkfr0bni224c1uvgglc2.apps.googleusercontent.com';
    private $clientSecret = 'V0PjhRoh1-qr-vrCtWVgJWN5';

    public function __construct()
    {

    }

    public function getScript()
    {
        ?>
        <script type="text/javascript">
            (function()
            {
                var po = document.createElement('script');
                po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();

            $('#gplus-button').click(function()
            {
                var additionalParams = {
                    'callback': signinCallback,
                    'approvalprompt' : 'auto',
                    'clientid' : '<?php echo $this->clientID; ?>',
                    'requestvisibleactions' : 'http://schemas.google.com/CommentActivity http://schemas.google.com/ReviewActivity',
                    'cookiepolicy' : 'single_host_origin',
                    'scope':'https://www.googleapis.com/auth/plus.profile.emails.read'
                };
                gapi.auth.signIn(additionalParams);
            });

            function signinCallback(authResult)
            {
                if (authResult['status']['signed_in'])
                {
                    var access_token = authResult.access_token;
                    hideLogin();

                    $.post('include/login_ajax.php',{access_token:access_token},function(data)
                    {
                        location.href = 'dashboard.php';
                    });
                }
                else
                {
                    console.log('Sign-in state: ' + authResult['error']);
                }
            }

            function hideLogin()
            {
                $('#title-login').html('Signing In With Google +');
                $('#social-div').hide();
                $('#sign-button-div').hide();
                $('#login-div').hide();
                $('#loading-div').show();
            }
        </script>
        <?php
    }

    public function getButton()
    {
        ?>
        <div id="signinButton">
        <div
          class="g-signin"
          data-callback="signinCallback"
          data-clientid="724273083219-jmbi4q81d33hhkfr0bni224c1uvgglc2.apps.googleusercontent.com"
          data-cookiepolicy="single_host_origin"
          data-requestvisibleactions="http://schemas.google.com/AddActivity"
          data-scope="https://www.googleapis.com/auth/plus.profile.emails.read">
        </div>
        </div>
        <?php
    }
}