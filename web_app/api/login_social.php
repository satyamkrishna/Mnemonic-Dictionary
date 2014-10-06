<?php
require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$user = new User();

$data = array();
$data['login'] = "fail";
$data['auth']  = "";
$data['email'] = "";
$error = new Error();

if(isset($_GET['access_token'],$_GET['social_type']))
{
    if(!empty($_GET['access_token']) &&!empty($_GET['social_type']))
    {
        switch($_GET['social_type'])
        {
            case 'FB':
                $response = @file_get_contents('https://graph.facebook.com/me?fields=id,name,email&access_token='.$_GET['access_token']);
                if($response != false)
                {
                    $fb_data       = json_decode($response,true);
                    $userID        = $user->register_user($fb_data['name'],$fb_data['email']);
                                     $user->setFB($userID);
                    $data['auth']  = $user->getAuthKey($userID);
                    $data['login'] = "success";
                    $data['email'] = $fb_data['email'];
                }
                echo json_encode($data);
                break;
            case 'GPlus':
                $response = @file_get_contents('https://www.googleapis.com/plus/v1/people/me?access_token='.$_GET['auth']);
                if($response != false)
                {
                    $gp_data       = json_decode($response,true);
                    $emails        = $gp_data['emails'];
                    $user_email    = $emails[0]['value']; 
                    $user_name     = $gp_data['displayName'];
                    $userID        = $user->register_user($user_name,$user_email);
                    $data['auth']  = $user->getAuthKey($userID);
                                     $user->setGPlus($userID);
                    $data['login'] = "success";
                    $data['email'] = $user_email;
                }
                echo json_encode($data);
                break;
        }
    }
    else
    {
        $error->parameters_either_empty_or_not_provided();
    }
}
else
{
    $error->parameters_either_empty_or_not_provided();
}
?>