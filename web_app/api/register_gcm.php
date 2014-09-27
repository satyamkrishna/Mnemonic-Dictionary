<?php

require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$data = array();
$data['register'] = 'fail';
$data['message'] = 'Not Enough Parameters';

$error = new Error();

if(isset($_GET['auth'],$_GET['gcm'],$_GET['deviceID']))
{
	if(!empty($_GET['auth']) &&!empty($_GET['gcm']) &&!empty($_GET['deviceID']))
	{
		$auth = htmlentities($_GET['auth']);
		$gcm_id = htmlentities($_GET['gcm']);
        $deviceID = htmlentities($_GET['deviceID']);
		
		$query=$db->ud_whereQuery('ud_user',NULL,array('authkey' => $auth));
		$user = $db->ud_mysql_fetch_assoc($query);
		
		if( $db->ud_getRowCountResult($query)==0)
		{
			$data['message'] = 'Auth Key Not Associated with any user';
		}
		else 
		{
			$result=$db->ud_whereQuery('ud_user_gcm',NULL,array('gcmID'=>$_GET['gcm']));
			$gcm = $db->ud_mysql_fetch_assoc($result); 
			
			if( $db->ud_getRowCountResult($result)==0)
			{
				$db->ud_updateQuery('ud_user',array('isGCM'=>1),array('authKey'=>$auth));
				$db->ud_insertQuery('ud_user_gcm',array('userID'=>$user['userID'],'gcmID'=>$_GET['gcm'],'deviceID'=>$deviceID));
			}
			else 
			{
				if($gcm['userID'] != $user['userID'])
				{
					$db->ud_updateQuery('ud_user',array('isGCM'=>1),array('authKey'=>$auth));
					$db->ud_deleteQuery('ud_user_gcm',array('gcmID'=>$_GET['gcm']));
					$db->ud_insertQuery('ud_user_gcm',array('userID'=>$user['userID'],'gcmID'=>$_GET['gcm'],'deviceID'=>$deviceID));
				}
			}
			$data['register'] = 'success';
			$data['message'] = 'User Registered';
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