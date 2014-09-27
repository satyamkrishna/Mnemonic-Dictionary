<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_HIGH_FREQUENCY_ADD);
$db = new dbHelper;
$db -> ud_connectToDB();

if(isset($_POST['name']))
{
    if(!empty($_POST['name']))
    {
        $name = htmlentities($_POST['name']);
        $list = $db->ud_whereQuery('ud_high_frequency',NULL,array('name'=>$name));
        if($db->ud_getRowCountResult($list)==0)
        {
            $db->ud_insertQuery('ud_high_frequency',array('name'=>$name));
        }
    }
}

$result = $db->ud_whereQuery('ud_high_frequency');
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
    <title>High Frquency Words - GRE</title>
    <!-- Metadata -->
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <meta content="" name="author" />
    <?php require 'include/foundation.php'; ?>
    <?php require 'include/datatable.php';?>
    <!-- CSS Styles -->
    <link rel="stylesheet" href="resources/css/common-backend/card.css" />
</head>
<style>
    .table-center
    {
        width: 120px;
        text-align:center !important;
    }
    .no-margin
    {
        margin-bottom:0px;
    }
    .data-container
    {
        height: 200px;
        overflow-y: scroll;
    }
</style>
<?php require 'include/header.php';?>
<div class="row content">
    <div class="large-12 columns card" style="padding:25px;">
        <div class="row">
            <form action="high_frequency.php" method="post">
                <div class="large-10 small-8 columns">
                    <input type="text" id="word" name="name" style="height:43px;"/>
                </div>
                <div class="large-2 small-4 columns">
                    <input type="submit" class="button secondary" value="+ Add List"/>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <table class="dashboard">
                    <thead>
                    <tr>
                        <th style="text-align:center;width:25px;">#</th>
                        <th>Name</th>
                        <th class="table-center" style="width:40px">Count</th>
                        <th class="table-center">Add</th>
                        <th class="table-center">List</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i=0;$i<sizeof($data);$i++)
                    {
                        $words = $db->ud_whereQuery('ud_high_frequency_words',null,array('ud_high_frequency_id'=>$data[$i]['id']));
                        ?>
                        <tr>
                            <td style="text-align:center;"><?php echo ($i+1); ?></td>
                            <td><?php echo $data[$i]['name'];?></td>
                            <td class="table-center"><?php echo $db->ud_getRowCountResult($words)?></td>
                            <td><a href="high_frequency_add.php?id=<?php echo $data[$i]['id'];?>" class="button secondary">Add</a></td>
                            <td><a href="high_frequency_list.php?id=<?php echo $data[$i]['id'];?>" class="button secondary">List</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        $('.dashboard').dataTable(
            {
                "sPaginationType" : "full_numbers"
            });
    });
</script>

<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->