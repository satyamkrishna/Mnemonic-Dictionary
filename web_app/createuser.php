<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_reg.inc.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

$db = new dbHelper;
$db -> ud_connectToDB();

$user = new User();

if(isset($_POST['name'],$_POST['email'],$_POST['password'],$_POST['clearance']))
{
	if(!empty($_POST['name']) &&!empty($_POST['email']) &&!empty($_POST['password']) &&!empty($_POST['clearance']))
	{
		$name = htmlentities($_POST['name']);
		$email = htmlentities($_POST['email']);
		$password = $_POST['password'];
		$userID = $user->register_user($name,$email,$password,$_SESSION['userID'],$_POST['clearance']);
	}
}

?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en">

<![endif]--><!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en">

<![endif]--><!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">

<![endif]--><!--[if gt IE 8]>
<!-->
<html class="no-js" lang="en">

	<!--<![endif]-->
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Adminpanel - GRE</title>
<!-- Metadata -->
<meta content="" name="description" />
<meta content="" name="keywords" />
<meta content="" name="author" />
<?php require 'include/foundation.php'; ?>
<?php require 'include/datatable.php';?>
<!-- CSS Styles -->
<link rel="stylesheet" href="resources/css/common-backend/card.css" />
</head>
<style>
.table-center
{
	width: 120px;
	text-align:center !important;
}
.no-margin
{
	margin-bottom:0px;
}
.data-container
{
	height: 200px;
	overflow-y: scroll;
}
</style>
<?php require 'include/header.php';?>
<div class="row content">
	<form action="createuser.php" method="POST">	
		<div class="large-6 small-8 columns large-centered small-centered card">
			<h5>Create New User</h5><br><br>
			<label for="name">Name</label><br>
			<input type="text" name="name" value="" id="name" placeholder="Name"/><br>
			<label for="email">Email</label><br>
			<input type="text" name="email" value="" id="email" placeholder="Email"/><br>
            <label for="password">Password</label><br>
            <input type="text" name="password" value="gre@123" id="password" placeholder="Password"/><br>
            <label for="clearance">Clearance</label><br>
            <select name="clearance" id="clearance">
                <?php for($i=1;$i<=$_SESSION['clearance'];$i++)
                {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
                ?>
            </select>
            <input type="submit" value="Add User" class="button secondary tiny"/>

		</div>
	</form>
</div>
<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->