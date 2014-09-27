<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'loggedin.php';	
	require_once 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

	$db = new dbHelper;
	$db->ud_connectToDB();	
	$select = $_POST['select'];
	$word_array = $_POST['word_array'];
	
	switch($select)
	{
		case 'his':
			break;
		case 'fav':
			foreach ($word_array as $wordID) 
			{
				$result = $db->ud_whereQuery('ud_user_fav',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$wordID));
				$db->ud_deleteQuery('ud_user_ignore',array('userID'=>$_SESSION['userID'],'wordID'=>$wordID));
				if($db->ud_getRowCountResult($result)==0)
				{
					$db->ud_insertQuery('ud_user_fav',array('userID'=>$_SESSION['userID'],'wordID'=>$wordID));
				}
			}
			echo 'Done';
			break;
		case 'ig':
			break; 
	}
	
?>