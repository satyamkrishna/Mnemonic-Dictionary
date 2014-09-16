<?php

require 'include.php';
require_once '../include/sync.inc.php';

$db = new dbHelper;
$db->ud_connectToDB();

$error = new Error();

$data = array();


if(isset($_POST['authKey'],$_POST['deviceID'],$_POST['fav'],$_POST['history'],$_POST['ignore']))
{
    if(!empty($_POST['authKey']) &&!empty($_POST['fav']) &&!empty($_POST['history']) &&!empty($_POST['ignore'])&&!empty($_POST['deviceID']))
    {

        $fav = $_POST['fav'];
        $history = $_POST['history'];
        $ignore = $_POST['ignore'];
        $auth = htmlentities($_POST['authKey']);
        $deviceID = htmlentities($_POST['deviceID']);

        $query=$db->ud_whereQuery('ud_user',NULL,array('authkey' => $auth));
        if( $db->ud_getRowCountResult($query)==0)
        {
            $data['message'] = 'Auth Key Not Associated with any user';
        }
        else
        {
            $user= $db->ud_mysql_fetch_assoc($query);

            $result = $db->ud_whereQuery('ud_user_gcm',null,array('userID'=>$user['userID'],'deviceID'=>$deviceID));
            if($db->ud_getRowCountResult($result)==0)
            {
                $data['message'] = 'Auth Key Match,No Device Registered with this ID';
            }
            else
            {
                $data['message'] = 'Auth Key Match';
                $gcm = $db->ud_mysql_fetch_assoc($result);
                $deviceID = $gcm['id'];

                // Ignore
                $result = $db->ud_whereQuery('queue_ignore',NULL,array('user_gcm_ID'=>$deviceID));
                $json   = $db->ud_mysql_fetch_assoc($result);
                $ignoreDB = json_decode($json['json'],true);


                // History
                $result = $db->ud_whereQuery('queue_history',NULL,array('user_gcm_ID'=>$deviceID));
                $json   = $db->ud_mysql_fetch_assoc($result);
                $historyDB = json_decode($json['json'],true);
                $historyAPI = $history;




                $data['fav'] = array();
                $data['ignore'] = array();
                $data['history'] = array();
                
                $result = $db->ud_whereQuery('ud_user_fav',array('wordID'),array('userID'=>$user['userID']));
                $fav= $db->ud_mysql_fetch_assoc_all($result);
                $fav_array = array();
                foreach ($fav as $value) {
                    array_push($fav_array,$value['wordID']);
                }
                $data['fav'] = $fav_array;

                $result=$db->ud_whereQuery('ud_user_history',array('wordID'),array('userID'=>$user['userID']));
                $history= $db->ud_mysql_fetch_assoc_all($result);
                $history_array = array();
                foreach ($history as $value) {
                    array_push($history_array,$value['wordID']);
                }
                $data['history'] = $history_array;

                $result=$db->ud_whereQuery('ud_user_ignore',array('wordID'),array('userID'=>$user['userID']));
                $ignore= $db->ud_mysql_fetch_assoc_all($result);
                $ignore_array = array();
                foreach ($ignore as $value) {
                    array_push($ignore_array,$value['wordID']);
                }
                $data['ignore'] = $ignore_array;
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
