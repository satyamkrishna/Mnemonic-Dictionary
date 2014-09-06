<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'gcm.inc.php';
	require 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_ANDROID);
	
	$db = new dbHelper;
	$db->ud_connectToDB();	
	
	if(isset($_POST['var_array'],$_POST['data_array'],$_POST['userID']))
	{
		if(!empty($_POST['var_array']) &&!empty($_POST['data_array']) &&!empty($_POST['userID']))
		{
			$var_array = $_POST['var_array'];
			$data_array = $_POST['data_array'];
			$userID = htmlentities($_POST['userID']);
			
			$message = array();
			for($i=0;$i<sizeof($var_array);$i++)
			{
				$message[$var_array[$i]] = $data_array[$i];
			}
			$gcm_obj = new GCM();
			$gcm_obj->send_notification_by_user_id($userID,$message);
		}
	}

?>