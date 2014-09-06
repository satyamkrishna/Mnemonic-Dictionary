<?php

require 'user_reg.inc.php';
require 'config.php';

// Facebook Includes
$FACEBOOK_SDK = 'facebook-php-sdk-v4-master/src/Facebook/';
require_once $FACEBOOK_SDK . 'FacebookSession.php';
require_once $FACEBOOK_SDK . 'FacebookRedirectLoginHelper.php';
require_once $FACEBOOK_SDK . 'FacebookRequest.php';
require_once $FACEBOOK_SDK . 'FacebookResponse.php';
require_once $FACEBOOK_SDK . 'FacebookSDKException.php';
require_once $FACEBOOK_SDK . 'FacebookRequestException.php';
require_once $FACEBOOK_SDK . 'FacebookAuthorizationException.php';
require_once $FACEBOOK_SDK . 'GraphObject.php';
require_once $FACEBOOK_SDK . 'GraphUser.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;



FacebookSession::setDefaultApplication($fbAPPID,$fbAPPSecret);

$helper = new FacebookRedirectLoginHelper($fbURL);

try
{
    $session = $helper->getSessionFromRedirect();
}
catch (FacebookRequestException $ex)
{
    // When Facebook returns an error
}
catch (Exception $ex)
{
    // When validation fails or other local issues
}

if (isset($session))
{
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $graphObject = $response->getGraphObject();

    $user = new User();
    if(sizeof($graphObject->getProperty('email'))>0)
    {
        $userID = $user->register_user($graphObject->getProperty('name'),$graphObject->getProperty('email'));
        $user->setFBSession($userID,$graphObject->getProperty('id'));
    }
}
else
{
    $fbLoginButton = '<a href="' . $helper->getLoginUrl(array('email')) . '"><img src="resources/img/common/fb.png"/></a>';
}
?>