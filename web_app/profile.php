<?php

	require 'include/core.inc.php';
	require 'include/dbhelper.inc.php';
	require 'include/loggedin.php';
    require 'include/user_clearance.inc.php';

    $db = new dbHelper;
	$db->ud_connectToDB();	
	
	$result = $db->ud_whereQuery('ud_user_fav',array('count(userID)'),array('userID'=>$_SESSION['userID']));
	$fav = $db->ud_mysql_fetch_assoc($result);
	$result = $db->ud_whereQuery('ud_user_ignore',array('count(userID)'),array('userID'=>$_SESSION['userID']));
	$ignore = $db->ud_mysql_fetch_assoc($result);
	$result = $db->ud_whereQuery('ud_user_history',array('count(userID)'),array('userID'=>$_SESSION['userID']));
	$history = $db->ud_mysql_fetch_assoc($result);
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
<title>Profile - GRE</title>
<!-- Metadata -->
<meta content="" name="description" />
<meta content="" name="keywords" />
<meta content="" name="author" />
<?php require 'include/foundation.php'; ?>
<script src="resources/js/foundation/foundation.reveal.js"></script>
<!-- CSS Styles -->
<link rel="stylesheet" href="resources/css/common-backend/card.css" />
</head>
<body>
<?php require 'include/header.php'; ?>
<div class="row content">
	<div class="large-9 small-11 small-centered large-centered columns card">
		<div class="row" style="min-height:350px;padding-top:30px;">
			<div class="large-2 small-5 columns">
				<img src="<?php echo $_SESSION['profile']; ?>" alt="profile-pic" style="height:96px;width:96px;"/>
			</div>
			<div class="large-10 small-7 columns">
				<h5><?php echo $_SESSION['name']; ?></h5>
				<h6>No of Favourites - <?php echo $fav['count(userID)'] ?></h6>
				<h6>No of Ignores - <?php echo $ignore['count(userID)'] ?></h6>
				<h6>No of Recent - <?php echo $history['count(userID)'] ?></h6>
				<a href="#" data-reveal-id="myModal">Update Password</a>
			</div>
		</div>	
	</div>
</div>
<div id="myModal" class="reveal-modal small">
	<div class="row">
		<div class="large-4 hide-for-small columns">
			<label for="oldp" class="right inline">Old Password</label>
			<label for="newp" class="right inline">New Password</label>
			<label for="newp_u" class="right inline">Repeat Password</label>
		</div>
		<div class="large-8 columns">
			<input type="password" placeholder="old password" id="oldp"/>
			<input type="password" placeholder="new password" id="newp"/>
			<input type="password" placeholder="repeat password" id="newp_u"/>
			<input type="button" class="secondary tiny" value="Update" id="submit"/>
			<p id="message" style="margin-top:20px"></p>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$('#submit').click(function()
	{
		var oldp = $('#oldp').val();
		var newp = $('#newp').val();
		var newp_u = $('#newp_u').val();
		
		if(oldp !='' && newp!= '' && newp_u!='')
		{
			if(newp != newp_u )
			{
				setMessage('New Password And Repeat Password not Same');
			}
			else
			{
				$.post('include/profile_ajax.php',{oldp:oldp,newp:newp,newp_u:newp_u},function(data)
				{
					if(data=='true')
					{
						setMessage('Password Updated');
						$('#myModal').delay(2000).foundation('reveal', 'close');
						oldp = $('#oldp').val('');	
						newp = $('#newp').val('');
						newp_u = $('#newp_u').val('');
					}
					else
					{
						setMessage(data);
					}
				});
			}
		}
		else
		{
			setMessage('Fill in All the Details');
		}
	});
	
	function setMessage(message)
	{
		$('#message').html(message);
		$('#message').show({duration: 0, queue: true}).delay(2000).fadeOut('slow');
	}
});
</script>
<?php require 'include/footer.php'; ?>
</body>
</html>
<![endif]-->