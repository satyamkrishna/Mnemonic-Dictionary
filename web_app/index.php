<?php

	require 'include/core.inc.php';
	require 'include/dbhelper.inc.php';
    require 'include/fblogin.php';
    require 'include/gplus.php';

	$db = new dbHelper;
	$db->ud_connectToDB();	

    $gplus = new Gplus();

	if(isset($_POST['email'],$_POST['password']))
	{
		if(!empty($_POST['email']) &&!empty($_POST['password']))
		{

            $user = new User();
			$email= htmlentities($_POST['email']);
			$password = md5(htmlentities($_POST['password']));
			
			$userID = $user->getUserID($email,$password);
            if(empty($userID))
            {
                $login = false;
            }
            else
            {
                $user->setSession($userID);
            }
		}
	}
	
	if(isset($_SESSION['userID']) && !empty($_SESSION['userID']))
	{
		header('location:dashboard.php');
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
<title>Login - GRE</title>
<!-- Metadata -->
<meta content="" name="description" />
<meta content="" name="keywords" />
<meta content="" name="author" />
<?php require 'include/foundation.php'; ?>
<!-- CSS Styles -->
<link rel="stylesheet" href="resources/css/frontend/homepage/login.css"/> 
</head>

<body>
<?php require 'include/header.php'; ?>
<form action="index.php" method="post" style="margin-top: 100px; margin-bottom: 110px;">
	<div class="row">
		<div class="large-7 small-11 columns login-box large-centered small-centered">
			<h3 id="title-login">Log In</h3>
			<hr />
            <div class="row" id="loading-div" style="display:none;min-height:200px;padding-top:50px;">
                <div class="large-3 columns large-centered small-4 small-centered">
                    <img src="resources/img/common/ajax-loader.gif"/>
                </div>
            </div>
            <div class="row" id="login-div">
				<div class="large-2 hide-for-small columns">
					<label class="right inline">Email</label>
					<label class="right inline">Password</label> </div>
				<div class="large-8 columns">
					<input name="email" placeholder="utopiadevelopers@gmail.com" type="text" />
					<input name="password" placeholder="password" type="password" />
				</div>
				<div class="large-2 columns">
				</div>
			</div>
			<div class="row" id="sign-button-div">
				<div class="large-offset-2 large-2 columns">
					<button class="button secondary tiny login-button">Sign In</button>
                </div>
				<div class="large-8 columns" style="margin-top: 10px;">
					<a class="left inline" href="#"><!-- Forget Your Password? --></a>
				</div>
			</div>
            <hr>
            <div class="row" id="social-div">
                <div class="large-4 large-offset-2 small-6 columns">
                    <?php echo $fbLoginButton; ?>
                </div>
                <div class="large-4 small-6 columns">
                    <?php $gplus->getButton(); ?>
                </div>
                <div class="large-2 columns">

                </div>
            </div>
        </div>
	</div>
</form>
<?php require 'include/footer.php'; ?>
<?php $gplus->getScript(); ?>
</body>
</html>
<![endif]-->