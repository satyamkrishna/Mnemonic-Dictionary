<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'gplus.php';
    require_once 'user_reg.inc.php';

    $data = array();

    if(isset($_POST['access_token']))
    {
        if(!empty($_POST['access_token']) )
        {
            $db = new dbHelper;
            $db->ud_connectToDB();

            $gplus = new Gplus();
            $user = new User();

            $response = @file_get_contents('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$_POST['access_token']);
            if($response != false)
            {
                $data = json_decode($response,true);
                if(isset($data['email'],$data['audience']))
                {
                    $response = @file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$_POST['access_token']);
                    if($response != false)
                    {
                        $profile = json_decode($response,true);
                        if(isset($profile['name']))
                        {
                            if($data['audience']==$gplus->clientID)
                            {
                                $userID = $user->register_user($profile['name'],$data['email']);
                                $user->setGPlusSession($userID,$profile['picture']);
                            }
                        }
                    }
                }
            }
        }
    }
?>