<?php

require 'dbhelper.inc.php';

$db = new dbHelper();
$db->ud_connectToDB();

$db->ud_insertQuery('definition_word_list',array('wordID'=>$_POST['id'],'definition'=>$_POST['def']));	

$result = $db->ud_whereQuery('definition_word_list',NULL,array('wordID'=>$_POST['id'],'definition'=>$_POST['def']));
$data = $db->ud_mysql_fetch_assoc($result);
$id = $data['definitionID'];

$synonyms = explode('//',$_POST['syn']);
for($i=0;$i<sizeof($synonyms);$i++) 
{
	if(strlen($synonyms[$i])>0)
	{
		$db->ud_insertQuery('synonym_word_list',array('definitionID'=>$id,'synonym'=>$synonyms[$i]));	
	}
}

$sentence = explode('//',$_POST['sent']);
for($i=0;$i<sizeof($sentence);$i++) 
{
	if(strlen($sentence[$i])>0)
	{
		$db->ud_insertQuery('sentence_word_list',array('definitionID'=>$id,'sentence'=>$sentence[$i]));	
	}
}
?>