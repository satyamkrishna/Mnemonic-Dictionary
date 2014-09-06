<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'loggedin.php';	
	require_once 'gcm.inc.php';	
	require_once 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$USER);

	$db = new dbHelper;
	$db->ud_connectToDB();	
		
	$gcm_obj = new GCM();
	
	switch($_POST['func'])
	{
		case 'select':
			$result = $db->ud_whereQuery('ud_user_fav',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
			$db->ud_deleteQuery('ud_user_ignore',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
			if($db->ud_getRowCountResult($result)==0)
			{
				$db->ud_insertQuery('ud_user_fav',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
				$gcm_obj->send_sync_message('fav',$_POST['wordID']);
			}
			break;
		case 'unselect':
			$result = $db->ud_whereQuery('ud_user_fav',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
			if($db->ud_getRowCountResult($result)>0)
			{
				$db->ud_deleteQuery('ud_user_fav',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
				$gcm_obj->send_sync_message('unfav',$_POST['wordID']);
			}
			break;
		case 'history':
			$result = $db->ud_whereQuery('ud_user_history',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
			if($db->ud_getRowCountResult($result)==0)
			{
				$db->ud_insertQuery('ud_user_history',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['wordID']));
				$gcm_obj->send_sync_message('history',$_POST['wordID']);
			}
			break;
		
	}
?>