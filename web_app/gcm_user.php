<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ANDROID);

$db = new dbHelper;
$db -> ud_connectToDB();

$result = $db -> ud_whereQuery('ud_user',NULL,array('isGCM'=>1));
$user = $db -> ud_mysql_fetch_assoc_all($result);

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
					<th style="text-align:center;width:25px;">#</th>
					<th>Name</th>
					<th class="table-center">#Request</th>
					<th class="table-center">Send</th>
				</tr>
			</thead>
			<tbody>
			<?php
			for($i=0;$i<sizeof($user);$i++)
			{
			?>
			<tr>
				<td style="text-align:center;"><?php echo ($i+1); ?></td>
				<td><?php echo $user[$i]['name'];?></td>
				<td style="text-align:center;">0</td>
				<td><a href="#" data-reveal-id="myModal" class="send button tiny secondary" id="<?php echo $user[$i]['userID']; ?>">Send Message</a>
			</tr>
			<?php
			}
			?>
			</tbody>
		</table>	
	</div>
</div>
<div id="myModal" class="reveal-modal medium">
	<div class="row">
		<div class="large-6 columns">
			<h4>GCM Params<a class="button secondary tiny" id="add">+</a></h4>
			<div class="params-list">	
				<div class="row params">
					<div class="large-6 columns">
						<input type="text" class="var"/>
					</div>
					<div class="large-6 columns">
						<input type="text" class="data"/>
					</div>
				</div>
			</div>
		</div>
		<div class="large-6 columns">
			<h4>Message</h4>
			<div id="gcm_id" style="display:none;"></div>
			<textarea readonly name="response" style="resize:none;height:50px;" id="response"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<input type="button" class="button tiny secondary" value="Send Notification" id="notify"/>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
	
	$('#notify').on("click",function()
	{
		createMessage();	
	});
	
	$('.send').click(function()
	{
		var gcm = $(this).attr('id');
		$('#gcm_id').html(gcm);
		$('#response').html("");
		$('.params-list').html('<div class="row params"> <div class="large-6 columns"> <input type="text" class="var"/> </div> <div class="large-6 columns"> <input type="text" class="data"/> </div> </div>');
	});
	
	$('#add').click(function()
	{
		$('.params-list').append('<div class="row params"> <div class="large-6 columns"> <input type="text" class="var"/> </div> <div class="large-6 columns"> <input type="text" class="data"/> </div> </div>');
	});
	
	$('.dashboard').dataTable(
	{
		"sPaginationType" : "full_numbers"
	});
	
	function createMessage()
	{
		var var_obj_array = {};
		var data_array = [];
		var var_array = [];
		var userID = $('#gcm_id').html();
		$('.params').each(function()
		{
			var var_1 = $(this).find('.var').val();
			var var_2 = $(this).find('.data').val();
			var_obj_array[var_1] = var_2;
			var_array.push(var_1);
			data_array.push(var_2);	
		});
		var json = JSON.stringify(var_obj_array);
		//var_array = JSON.stringify(var_array);
		//data_array = JSON.stringify(data_array);
		$('#response').html(json);
		$.post('include/gcm_ajax.php',{var_array:var_array,data_array:data_array,userID:userID},function(data)
		{
			$('#myModal').delay(2000).foundation('reveal', 'close');
		}).fail( function(xhr, textStatus, errorThrown)
        {
            alert(errorThrown);
        });
	}
});
</script>

<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->