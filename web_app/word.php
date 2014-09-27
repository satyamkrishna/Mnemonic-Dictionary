<?php

	require 'include/core.inc.php';
	require 'include/dbhelper.inc.php';
	require 'include/loggedin.php';
    require 'include/user_clearance.inc.php';
	
	$db = new dbHelper;
	$db->ud_connectToDB();	
	
	$search = $_GET['word'];
	$result = $db -> ud_getQuery('SELECT * FROM word_list w WHERE w.word = \'' . $_GET['word'] . '\'');
	if ($db -> ud_getRowCountResult($result) > 0) 
	{
		$word = $db -> ud_mysql_fetch_assoc($result);
		$wordID = $word['wordID'];
	
		$result = $db->ud_whereQuery('ud_user_history',NULL,array('userID'=>$_SESSION['userID'],'wordID'=>$wordID));
		if($db->ud_getRowCountResult($result)==0)
		{
			$db->ud_insertQuery('ud_user_history',array('userID'=>$_SESSION['userID'],'wordID'=>$wordID));
		}
	}
	else 
	{
		$result = $db->ud_whereQuery('ud_user_word_not_present',NULL,array('userID'=>$_SESSION['userID'],'word'=>$_GET['word']));
		if($db->ud_getRowCountResult($result)==0)
		{
			$db->ud_insertQuery('ud_user_word_not_present',array('userID'=>$_SESSION['userID'],'word'=>$_GET['word']));
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
<title>Word - GRE</title>
<!-- Metadata -->
<meta content="" name="description" />
<meta content="" name="keywords" />
<meta content="" name="author" />
<?php require 'include/foundation.php'; ?>
<!-- CSS Styles -->

</head>

<body>
<?php require 'include/header.php'; ?>
<?php require 'include/card.inc.php';?>
<?php require 'include/search.php';?>
<style>
.search_div
{
	margin-top:40px;
	margin-bottom:0px!important;
}
</style>
<div class="row content">
	<div class="large-7 small-11 small-centered large-centered columns">
		<?php get_word($_GET['word']); ?>
	</div>	
</div>
<?php require 'include/footer.php'; ?>
</body>
</html>
<![endif]-->