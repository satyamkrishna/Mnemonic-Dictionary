<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$SIX);

$db = new dbHelper;
$db -> ud_connectToDB();

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
        <button id="addRow">Add new row</button>
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Column 3</th>
                <th>Column 4</th>
                <th>Column 5</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Column 3</th>
                <th>Column 4</th>
                <th>Column 5</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        var t = $('#example').DataTable();
        var counter = 1;

        $('#addRow').on( 'click', function () {
            t.row.add( [
                counter +'.1',
                counter +'.2',
                counter +'.3',
                counter +'.4',
                counter +'.5'
            ] ).draw();

            counter++;
        } );

        // Automatically add a first row of data
        $('#addRow').click();
    });
</script>
<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->