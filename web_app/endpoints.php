<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ANDROID);

$db = new dbHelper;
$db -> ud_connectToDB();

$result = $db -> ud_whereQuery('ud_endpoints');
$end = $db -> ud_mysql_fetch_assoc_all($result);
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
<title>Endpoints - GRE</title>
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
			<div class="large-12 columns">
				<a href="#" data-reveal-id="myModal" class="button secondary">+ Add Api</a>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<table class="dashboard">
					<thead>
						<tr>
							<th style="text-align:center;width:25px;">#</th>
							<th>Name</th>
							<th>Method</th>
							<th>URL</th>
							<th>Params</th>
							<th class="table-center">Test</th>
						</tr>
					</thead>
					<tbody>
					<?php
					for($i=0;$i<sizeof($end);$i++)
					{
					?>
					<tr>
						<td style="text-align:center;"><?php echo ($i+1); ?></td>
						<td><?php echo $end[$i]['name'];?></td>
						<td><?php echo $end[$i]['method'];?></td>
						<td><?php echo $end[$i]['url'];?></td>
						<td><?php echo $end[$i]['params'];?></td>
						<td><a href="endpoint_test.php?id=<?php echo $end[$i]['id'];?>" class="button secondary">Test</a></td>
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
<div id="myModal" class="reveal-modal small">
	<div class="row">
		<div class="large-5 hide-for-small columns">
			<label for="name" class="right inline">API Name (any)</label>
			<label for="url" class="right inline">API Url(just the php)</label>
			<label for="type" class="right inline">API Method Type</label>
			<label for="param" class="right inline">API Parameters</label>
			<label for="sample" class="right inline">API Sample</label>
		</div>
		<div class="large-7 columns">
			<input type="text" placeholder="Name" id="name"/>
			<input type="text" placeholder="API" id="url"/>
			<input type="text" placeholder="POST OR GET" id="type"/>
			<input type="text" placeholder="Comma Sep" id="param"/>
			<input type="text" placeholder="// Sep" id="sample"/>
			<input type="button" class="secondary tiny" value="Add" id="submit"/>
			<p id="message" style="margin-top:20px"></p>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
	$('#submit').click(function()
	{
		var name = $('#name').val();
		var url = $('#url').val();
		var type = $('#type').val();
		var param = $('#param').val();
		var sample = $('#sample').val();
		
		$.post('include/endpoint_ajax.php',{name:name,url:url,type:type,param:param,sample:sample},function(data)
		{
			$('#myModal').foundation('reveal', 'close');
			location.reload();
		}).fail( function(xhr, textStatus, errorThrown)
        {
            alert(errorThrown);
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