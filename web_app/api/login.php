<?php
require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$data = array();
$data['login'] = "fail";
$data['auth']  = "";

$error = new Error();

if(isset($_GET['email'],$_GET['password']))
{
	if(!empty($_GET['email']) &&!empty($_GET['password']))
	{
	
		$username = htmlentities($_GET['email']);
		$password = htmlentities($_GET['password']);
		
		$query=$db->ud_whereQuery('ud_user',NULL,array('email' => $username,'password' =>$password));
		if( $db->ud_getRowCountResult($query)>0)
		{
			$user=$db->ud_mysql_fetch_assoc($query);
			$data['login'] = "success";
			$data['auth']  = createKey($user);
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