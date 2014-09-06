<?php

	$file_name = explode("?", basename($_SERVER['REQUEST_URI']));
	$file_name = $file_name[0];
	if(isset($_POST['ignore']) && !empty($_POST['ignore']))
	{
		$gcm_obj = new GCM();	
		$ignore = htmlentities($_POST['ignore']);	
		$db->ud_deleteQuery('ud_user_fav',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['ignore']));
		$result = $db->ud_whereQuery('ud_user_ignore',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['ignore']));
		if($db->ud_getRowCountResult($result)==0)
		{
			$db->ud_insertQuery('ud_user_ignore',array('userID'=>$_SESSION['userID'],'wordID'=>$_POST['ignore']));
			$gcm_obj->send_sync_message('ignore',$_POST['ignore']);
		}
	}

?>