<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ADMIN_PANEL);

$db = new dbHelper;
$db -> ud_connectToDB();

$result = $db -> ud_getQuery('SELECT * FROM `ud_users_login` l LEFT JOIN `ud_user` u ON l.userID = u.userID ORDER BY `l`.`loginTimeStamp` DESC');
$history = $db -> ud_mysql_fetch_assoc_all($result);

function name($val)
{
	if($val==NULL)
	{
		echo '-';
	}
	else
	{
		echo $val;	
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
<title>Login History - GRE</title>
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
</style>
<?php require 'include/header.php';?>
<div class="row content">
	<div class="large-12 columns card" style="padding:25px;">
		<table class="history">
			<thead>
				<tr>
					<th style="width:50px;">#</th>
					<th>Date</th>
                    <th>IP Address</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$index = 1;
			for($i=0;$i<sizeof($history);$i++)
			{
				if($history[$i]['userID']==$_SESSION['userID'])
				{
			?>
				<tr>
					<td><?php echo $index++; ?></td> 
					<td><?php echo $history[$i]['loginTimeStamp']; ?></td>
                    <td><?php echo $history[$i]['loginIP']; ?></td>
				</tr>											
			<?php 
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{	
	$('.history').dataTable(
	{
		"sPaginationType" : "full_numbers"
	});
});
</script>
<?php
require 'include/footer.php';
?>
</body>
</html>
<![endif]-->