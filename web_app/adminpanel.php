<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_reg.inc.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

$db = new dbHelper;
$db -> ud_connectToDB();

$result = $db -> ud_getQuery('SELECT * FROM `ud_user` u LEFT JOIN
			 (SELECT count(userID) as history,userID from `ud_user_history`
			  GROUP BY userID ) h ON u.userID = h.userID LEFT JOIN (SELECT 
			  count(userID) as ig,userID from `ud_user_ignore` GROUP BY userID ) 
			  i ON u.userID = i.userID LEFT JOIN (SELECT count(userID) as fav
			  ,userID from `ud_user_fav` GROUP BY userID ) f ON u.userID = 
			  f.userID LEFT JOIN (SELECT count(userID) as log,userID from 
			  `ud_users_login` GROUP BY userID ) l ON u.userID = l.userID 
			  LEFT JOIN (SELECT count(userID) as new_word,userID from 
			  `ud_user_word_not_present` GROUP BY userID ) w ON u.userID = w.userID 
			  LEFT JOIN (SELECT userID FROM `ud_user`) o ON u.userID = o.userID');
$user = $db -> ud_mysql_fetch_assoc_all($result);

function getName($user)
{
    $data = $user['name'];



    if($user['isFB']==1)
    {
        $data .= ' <img style="float:right;margin-right:10px;" src="resources/img/common/fb_logo.png"/>';
    }
    if($user['isG+']==1)
    {
        $data .= ' <img style="float:right;margin-right:10px;" src="resources/img/common/gplus_logo.png"/>';
    }
    if($user['createdBy']!=null)
    {
        $data .= ' <img style="float:right;margin-right:10px;width:16px;height:16px;" src="'.User::getUserProfile($user['createdBy']).'"/>';
    }
    return $data;
}

function name($val,$userID,$select)
{
    if($val==NULL)
    {
        echo '-';
    }
    else
    {
        switch($select)
        {
            case 'log':
                echo $val;
                break;
            case 'his':
                echo '<a class="button secondary tiny no-margin view-data" copy="false" select="'.$select.'" id="'.$userID.'">View ('.$val.')</a>';
                break;
            case 'fav':
                echo '<a class="button secondary tiny no-margin view-data" copy="true" select="'.$select.'" id="'.$userID.'">View ('.$val.')</a>';
                break;
            case 'ig':
                echo '<a class="button secondary tiny no-margin view-data" copy="false" select="'.$select.'" id="'.$userID.'">View ('.$val.')</a>';
                break;
            case 'new-word':
                echo '<a class="button secondary tiny no-margin view-data" copy="false" select="'.$select.'" id="'.$userID.'">View ('.$val.')</a>';
                break;

        }
    }
}

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
        <table class="dashboard">
            <thead>
            <tr>
                <th style="text-align:center;">#</th>
                <th>Name</th>
                <th class="table-center">#Login</th>
                <th class="table-center">#Favourites</th>
                <th class="table-center">#Ignores</th>
                <th class="table-center">#Recent</th>
                <th class="table-center">#New Words</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0;$i<sizeof($user);$i++)
            {
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo ($i+1); ?></td>
                    <td><?php echo getName($user[$i]);?></td>
                    <td class="table-center"><?php name($user[$i]['log'],$user[$i]['userID'],'log'); ?></td>
                    <td class="table-center"><?php name($user[$i]['fav'],$user[$i]['userID'],'fav'); ?></td>
                    <td class="table-center"><?php name($user[$i]['ig'],$user[$i]['userID'],'ig'); ?></td>
                    <td class="table-center"><?php name($user[$i]['history'],$user[$i]['userID'],'his'); ?></td>
                    <td class="table-center"><?php name($user[$i]['new_word'],$user[$i]['userID'],'new-word'); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="reveal-modal medium">
</div>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        $('.view-data').click(function()
        {
            userID= $(this).attr('id');
            select = $(this).attr('select');
            copy = $(this).attr('copy');
            $('#myModal').foundation('reveal', 'open',
                {
                    url: 'include/get_data_ajax.php?userID='+userID+'&select='+select+'&copy='+copy,
                    success: function(data) {

                    },
                    error: function() {

                    }
                });
        });

        $(document).on('click','.copy-all',function()
        {
            select = $(this).attr('select');
            word_array = new Array();
            $('.data-container li').each(function()
            {
                obj = $(this);
                word_array.push(obj.attr('id'));
            })
            $.post('include/add_data_ajax.php',{select:select,word_array:word_array},function()
            {

            });
        });

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