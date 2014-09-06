<?php

    require 'include/core.inc.php';
    require 'include/variable.inc.php';
    require 'include/dbhelper.inc.php';
    require 'include/loggedin.php';
    require 'include/user_clearance.inc.php';
    require 'include/high_frequency_check.php';

    $db = new dbHelper;
	$db->ud_connectToDB();	
	
	require 'include/gcm.inc.php';
	require 'include/ignore.inc.php';	
	
	$NO_OF_CARD = 6;
	
	$start = 'a';
	if(isset($_GET['start']) && !empty($_GET['start']))
	{
		$start = strtolower($_GET['start']);
	}
	
	$page = 1;
	if(isset($_GET['page']) && !empty($_GET['page']))
	{
		$page = $_GET['page'] +1 -1;
	}
	
	$page_start = ($page-1) *$NO_OF_CARD;
	$page_end = $page_start + $NO_OF_CARD;

    $word_like = ' AND w.word like \''.$start.'%\'';
    if($start == 'all_word')
    {
        $word_like = '';
    }

    $sql = 'SELECT * FROM `word_list` w WHERE w.wordID NOT IN (SELECT wordID FROM `ud_user_ignore` WHERE userID = '.$_SESSION['userID'].')'.$high_sql_query_and_part.$word_like.' ORDER BY w.word ASC';
    $result  = $db->ud_getQuery($sql);
	$word_arr= $db->ud_mysql_fetch_assoc_all($result);
	$word_arr_select = array();
	$index = 0;
	for($i=$page_start;$i<$page_end;$i++)
	{
		if($i<sizeof($word_arr))
		{
			$word_arr_select[$index++] = $word_arr[$i]; 
		}
	}
	
	$tot_words = sizeof($word_arr);
	$no_of_pages = ceil($tot_words/$NO_OF_CARD);					
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
<title>Dashboard - GRE</title>
<!-- Metadata -->
<meta content="" name="description" />
<meta content="" name="keywords" />
<meta content="" name="author" />
<?php require 'include/foundation.php'; ?>
<!-- CSS Styles -->
<link rel="stylesheet" href="resources/css/common-backend/card.css" />
<style>
.large-5-half .card
{
	margin-bottom: 45px!important;
}

.large-5-half:last-child
{
	margin-bottom: 0px!important;
}
@media only screen and (min-width: 768px)
{
	.columns.large-uncentered:last-child
	{
		float: right !important;
	}
}
</style>
</head>

<body>
<?php require 'include/header.php'; ?>
<?php require 'include/card.inc.php';?>
<?php require 'include/pagination.php';?>
<?php require 'include/search.php';?>
<?php require 'include/no_word_added.php';?>
<div class="row">
	<div class="small-11 small-centered large-uncentered large-5-half columns">
	<?php
		for($i=0;$i<sizeof($word_arr_select)/2;$i++)
		{
			get_word($word_arr_select[$i*2]['word']);
		}
	?>
	</div>	
	<div class="small-11 small-centered large-uncentered large-5-half columns">
	<?php
		for($i=1;$i<=sizeof($word_arr_select)/2;$i++)
		{
			get_word($word_arr_select[$i*2-1]['word']);
		}
	?>
	</div>		
</div>
<?php require 'include/pagination.php';?>
<?php require 'include/footer.php'; ?>
</body>
</html>
<![endif]-->