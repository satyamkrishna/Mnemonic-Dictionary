<?php

require_once 'core.inc.php';
require_once 'dbhelper.inc.php';
require_once 'loggedin.php';
require_once 'user_clearance.inc.php';

Clearance::badRequestIfNotEnoughClearance(Clearance::$USER);

$db = new dbHelper;
$db -> ud_connectToDB();

if(isset($_POST['search']) && !empty($_POST['search']))
{
	switch($_POST['filename'])
	{
		case 'word.php':
		case 'dashboard.php':
			$result  = $db->ud_getQuery('SELECT word FROM `word_list` w WHERE w.word like \''.$_POST['search'].'%\' ORDER BY w.word ASC');
			break;
		case 'fav.php':
			$result  = $db->ud_getQuery('SELECT word FROM `word_list` w WHERE w.wordID IN (SELECT wordID FROM `ud_user_fav` WHERE userID = '.$_SESSION['userID'].') AND w.word like \''.$_POST['search'].'%\' ORDER BY w.word ASC');
			break;
		case 'ignore.php':
			$result  = $db->ud_getQuery('SELECT word FROM `word_list` w WHERE w.wordID IN (SELECT wordID FROM `ud_user_ignore` WHERE userID = '.$_SESSION['userID'].') AND w.word like \''.$_POST['search'].'%\' ORDER BY w.word ASC');
			break;
		case 'recent.php':
			$result  = $db->ud_getQuery('SELECT word FROM `word_list` w WHERE w.wordID IN (SELECT wordID FROM `ud_user_history` WHERE userID = '.$_SESSION['userID'].') AND w.word like \''.$_POST['search'].'%\' ORDER BY w.word ASC');
			break;
	}
	$word_arr= $db->ud_mysql_fetch_assoc_all($result);
	$max = 4;
	if(sizeof($word_arr)<$max)
	{
		$max = sizeof($word_arr);
	}
	for($i=0;$i<$max;$i++)
	{
		$word = $word_arr[$i]['word'];
		$search_l = strlen($_POST['search']);
		$search = substr($word,0,$search_l).'<b>'.substr($word,$search_l,strlen($word)).'</b>';
		echo '<p class="search-val">'.$search.'</p>';
	}
}
?>