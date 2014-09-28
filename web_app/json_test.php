<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$SUPER_ADMIN);

$db = new dbHelper;
$db -> ud_connectToDB();

$myFile = 'upload/test.json';
$fh = fopen($myFile, 'w');	

$result = $db -> ud_getQuery("SELECT * FROM `word_list` ORDER BY word");
$word_list = $db -> ud_mysql_fetch_assoc_all($result);
$json_array = array();
$message = '';
$prev_alphabet = '';
$next_alphabet = '';

for($ind=0;$ind<sizeof($word_list);$ind++)
{
	$wordID = $word_list[$ind]['wordID'];

    $next_alphabet = strtolower(substr($word_list[$ind]['word'],0,1));
    if($next_alphabet == $prev_alphabet)
        continue;
    else
        $prev_alphabet = $next_alphabet;

    $message = $message.$word_list[$ind]['word'].',';
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
    array_push($json_array,$wordObj);
}
$json_data = json_encode($json_array);
fwrite($fh,$json_data);
fclose($fh);
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
<?php require 'include/header.php';?>
<div class="row content">
    <div class="large-12 columns card">
        <h4>Test JSON</h4>
        <p><?php echo $json_data; ?></p>
    </div>
</div>
<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->