<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'loggedin.php';	
	require_once 'auth.inc.php';	
	require_once 'gcm.inc.php';
	require_once 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$USER);

	$db = new dbHelper;
	$db->ud_connectToDB();	
	
	$result = $db->ud_whereQuery('ud_user',null,array('userID'=>$_SESSION['userID'],'password'=>md5($_POST['oldp'])));
	if($db->ud_getRowCountResult($result)==0)
	{
		echo 'Incorrect Old Password';
	}	
	else	
	{
		$data = $db->ud_mysql_fetch_assoc($result);
		$oldAuth = $data['authKey'];
		$db->ud_updateQuery('ud_user',array('password'=>md5($_POST['newp'])),array('userID'=>$_SESSION['userID']));
		createKey(array('authKey'=>'','userID'=>$_SESSION['userID'],'email'=>$_SESSION['email']));
		$gcm = new GCM();
		$gcm->send_notification_by_user_id($_SESSION['userID'],array('type'=>'invalidate','oldAuth'=>$oldAuth),false);
		echo 'true';
	}
?>