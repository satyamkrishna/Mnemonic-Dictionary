<?php

require 'dbhelper.inc.php';

$db = new dbHelper();
$db->ud_connectToDB();

$db->ud_insertQuery('word_list',array('word'=>$_POST['word'],'definition_short'=>$_POST['definition_short']));

$result = $db->ud_whereQuery('word_list',NULL,array('word'=>$_POST['word']));
$data = $db->ud_mysql_fetch_assoc($result);

$id = $data['wordID'];

$mnemonics = explode('///',$_POST['mnemonics']);
for($i=0;$i<sizeof($mnemonics)-1;$i++) 
{
	$db->ud_insertQuery('mnemonics_word_list',array('wordID'=>$id,'mnemonic'=>$mnemonics[$i]));	
}

echo $id;
?>