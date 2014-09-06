<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
    require 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_ANDROID);
	
	$db = new dbHelper;
	$db->ud_connectToDB();	
	
	if(isset($_POST['name'],$_POST['url'],$_POST['type'],$_POST['param'],$_POST['sample']))
	{
		if(!empty($_POST['name']) &&!empty($_POST['url']) &&!empty($_POST['type']) &&!empty($_POST['param']) &&!empty($_POST['sample']))
		{
			$name = htmlentities($_POST['name']);
			$url = htmlentities($_POST['url']);
			$type = htmlentities($_POST['type']);
			$param = htmlentities($_POST['param']);
			$sample = htmlentities($_POST['sample']);
			
			$db->ud_insertQuery('ud_endpoints',array('name'=>$name,'url'=>$url,'method'=>$type,'params'=>$param,'sample'=>$sample));
		}
	}
	
	
?>