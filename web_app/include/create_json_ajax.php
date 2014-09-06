<?php

require_once 'core.inc.php';
require_once 'dbhelper.inc.php';
require_once 'loggedin.php';
require 'user_clearance.inc.php';

Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

$db = new dbHelper;
$db -> ud_connectToDB();

if(isset($_POST['char']) && !empty($_POST['char']))
{
	$length = 10;
	$char = $_POST['char'];
	$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	$randomString = $char;	
	
	$myFile = '../upload/'.$randomString.'.txt';
	$fh = fopen($myFile, 'w');	
	
	$result = $db -> ud_getQuery("SELECT * FROM `word_list` WHERE word LIKE '$char%' ORDER BY `word_list`.`word` ASC");
	$word_list = $db -> ud_mysql_fetch_assoc_all($result);
	$json_array = array();
	for($ind=0;$ind<sizeof($word_list);$ind++)	
	{
		$wordID = $word_list[$ind]['wordID'];
		echo $word_list[$ind]['word'].',';
		$wordObj = array();
		$result = $db -> ud_whereQuery('mnemonics_word_list', NULL, array('wordID' => $wordID));
		$mnemonics = $db -> ud_mysql_fetch_assoc_all($result);
		$mnemonics_arr = array();
		for ($i = 0; $i < sizeof($mnemonics); $i++) 
		{
			$mnemonics_arr[$i] = $mnemonics[$i]['mnemonic'];
		}
		
		$result = $db -> ud_whereQuery('definition_word_list', NULL, array('wordID' => $wordID));
		$defintion = $db -> ud_mysql_fetch_assoc_all($result);
		$defintion_arr = array();
	
		for ($i = 0; $i < sizeof($defintion); $i++) 
		{
			$result = $db -> ud_whereQuery('synonym_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
			$synonym = $db -> ud_mysql_fetch_assoc_all($result);
			$synonym_arr = array();
	
			for ($j = 0; $j < sizeof($synonym); $j++) 
			{
				$synonym_arr[$j] = $synonym[$j]['synonym'];
			}
	
			$result = $db -> ud_whereQuery('sentence_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
			$sent = $db -> ud_mysql_fetch_assoc_all($result);
			$sent_arr = array();
	
			for ($j = 0; $j < sizeof($sent); $j++) 
			{
				$sent_arr[$j] = $sent[$j]['sentence'];
			}
	
			$defintion_arr[$i] = array('def' => $defintion[$i]['definition'], 'syn' => $synonym_arr, 'sent' => $sent_arr);
		}
		
		$wordObj['word'] = $word_list[$ind]['word'];
		$wordObj['wordID'] = $wordID;
		$wordObj['definition_short'] = $word_list[$ind]['definition_short'];
		$wordObj['mnemonics_arr'] = $mnemonics_arr;
		$wordObj['defintion_arr'] = $defintion_arr;
		$json_array[$ind] = $wordObj;
		
		
	}
	$json_data = json_encode($json_array);
	fwrite($fh,$json_data);
	fclose($fh);
}
?>