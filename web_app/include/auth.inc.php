<?php

function createKey($user)
{
	$db = new dbHelper;
	$db-> ud_connectToDB();
	if(strlen($user['authKey'])<32)
	{
		$authKey = md5($user['userID'].$user['email'].time());
		$db->ud_updateQuery('ud_user',array('authKey'=>$authKey,'auth_time'=>$db->ud_timestamp()),array('userID'=>$user['userID']));
		return $authKey;
	}
	else 
	{
		return $user['authKey'];
	}
}

?>