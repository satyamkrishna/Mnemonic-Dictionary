<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'loggedin.php';	
	require_once 'user_clearance.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

	$db = new dbHelper;
	$db->ud_connectToDB();	
	$select = $_GET['select'];
	switch($select)
	{
		case 'his':
			$title = 'History';
			$result = $db->ud_getQuery('SELECT * FROM `ud_user_history` w JOIN `word_list` l ON w.wordID = l.wordID  WHERE w.userID ='.$_GET['userID']);
			break;
		case 'fav':
			$title = 'Fav Words';
			$result = $db->ud_getQuery('SELECT * FROM `ud_user_fav` w JOIN `word_list` l ON w.wordID = l.wordID WHERE w.userID ='.$_GET['userID']);
			break;
		case 'ig':
			$title = 'Ignore List';
			$result = $db->ud_getQuery('SELECT * FROM `ud_user_ignore` w JOIN `word_list` l ON w.wordID = l.wordID WHERE w.userID ='.$_GET['userID']);
			break;
		case 'new-word':
			$title = 'New Words';
			$result = $db->ud_getQuery('SELECT * FROM `ud_user_word_not_present` w WHERE w.userID ='.$_GET['userID']);
			break;	
		 
	}
	
	$word = $db -> ud_mysql_fetch_assoc_all($result);
	
?>
<?php 
	echo '<h2 style="display:inline;">'.$title.'</h2> '; 
	if($_GET['copy'] == 'true')
	{
		echo '<a style="margin-left:15px;" class="copy-all" select="'.$select.'">Copy All</a>';
	}
?>
<ul style="margin-left:40px;" class="data-container">
<?php
for($i=0;$i<sizeof($word);$i++)
{
	$wordID = '';
	if(isset($word[$i]['wordID']))
	{
		$wordID = $word[$i]['wordID'];
	}
	echo '<li id="'.$wordID.'">'.$word[$i]['word'].'</li>';
}
?>
</ul>
<a class="close-reveal-modal">&#215;</a>