<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_HIGH_FREQUENCY_ADD);

$db = new dbHelper;
$db -> ud_connectToDB();

if(!isset($_GET['id']) || empty($_GET['id']))
{
    header('location:high_frequency.php');
}

$result = $db->ud_whereQuery('ud_high_frequency',NULL,array('id'=>$_GET['id']));
$list   = $db->ud_mysql_fetch_assoc($result);

if( $db->ud_getRowCountResult($result)==0)
{
    header('location:high_frequency.php');
}

$result = $db->ud_getQuery('SELECT * FROM `ud_high_frequency_words` w JOIN `word_list` l ON w.wordID = l.wordID WHERE `ud_high_frequency_id` = '.$_GET['id']);
$data = $db->ud_mysql_fetch_assoc_all($result);

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
    <title>Add High Frequency Words - GRE</title>
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
<div class="row content card" style="margin-top:25px;margin-bottom:25px;">
    <div class="large-12 columns">
        <h3><?php echo $list['name'] ?></h3>
        <table class="dashboard">
            <thead>
            <tr>
                <th>#</th>
                <th style="text-align: center;">Word</th>
                <th>Short Def</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0;$i<sizeof($data);$i++)
            {
                ?>
                <tr>
                    <td><?php echo ($i+1); ?></td>
                    <td style="text-align: center;"><?php echo $data[$i]['word'];?></td>
                    <td><?php echo $data[$i]['definition_short']; ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function()
{
    $('.dashboard').dataTable(
    {
        "sPaginationType" : "full_numbers",
        'iDisplayLength': 25
    });
});
</script>
<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->