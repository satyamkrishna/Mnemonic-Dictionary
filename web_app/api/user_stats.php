<?php

require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$error = new Error();

$data = array();

if (isset($_GET['access_token']))
{
    if (!empty($_GET['access_token']))
    {
        $access_token = htmlentities($_GET['access_token']);
        $result = $db->ud_whereQuery('ud_user', NULL, array('authkey' => $access_token));
        if ($db->ud_getRowCountResult($result) == 0)
        {
            $data['message'] = 'Access Token Not Associated with any user';
        }
        else
        {
            $user = $db->ud_mysql_fetch_assoc($result);
            if($user['clearance']>=Clearance::$MODULE_ADMIN_PANEL)
            {
                $data['message'] = 'Success';

                $result = $db -> ud_getQuery('SELECT * FROM `ud_user` u LEFT JOIN (SELECT count(userID) as history,userID from `ud_user_history` GROUP BY userID ) h ON u.userID = h.userID LEFT JOIN (SELECT count(userID) as ig,userID from `ud_user_ignore` GROUP BY userID ) i ON u.userID = i.userID LEFT JOIN (SELECT count(userID) as fav ,userID from `ud_user_fav` GROUP BY userID ) f ON u.userID = f.userID LEFT JOIN (SELECT count(userID) as log,userID from `ud_users_login` GROUP BY userID ) l ON u.userID = l.userID LEFT JOIN (SELECT count(userID) as new_word,userID from `ud_user_word_not_present` GROUP BY userID ) w ON u.userID = w.userID LEFT JOIN (SELECT userID FROM `ud_user`) o ON u.userID = o.userID');
                $user_stats = $db -> ud_mysql_fetch_assoc_all($result);
                $users = array();
                foreach($user_stats as $user)
                {
                    $data_obj = array();
                    $data_obj['userID'] = $user['userID'];
                    array_push($users,$data_obj);
                }

                $data['user_stats']= $users;
            }
            else
            {
                $data['message'] = 'Not Enough Clearance';
            }
        }
        echo json_encode($data);
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