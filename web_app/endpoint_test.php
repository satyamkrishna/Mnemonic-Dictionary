<?php
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_ANDROID);

$db = new dbHelper;
$db -> ud_connectToDB();

if(!isset($_GET['id']) || empty($_GET['id']))
{
	header('location:endpoints.php');
}

$result = $db->ud_whereQuery('ud_endpoints',NULL,array('id'=>$_GET['id']));
$end    = $db->ud_mysql_fetch_assoc($result);

if( $db->ud_getRowCountResult($result)==0)
{
	header('location:endpoints.php');
}

$params = explode(',',$end['params']);
$sample = explode('//',$end['sample']);

$check = false;

if(sizeof($params) == sizeof($sample))
{
	$check = true;
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
		<h4>API - <?php  echo $end['name']; ?></h4></br>
		<div class="row">
			<div class="large-5 small-12 columns">
				<h5>Parameters <?php if($check){ ?>(<input type="checkbox" id="sample"/> Use Sample Parameter)<?php }?></h5></br>
				<?php
				for($i=0;$i<sizeof($params);$i++)
				{
				?>
				<div class="row">
					<div class="large-4 columns">
						<?php echo $params[$i]; ?>
					</div>
					<div class="large-8 columns">
						<input type="text" id="<?php echo $params[$i]; ?>"/>
					</div>
				</div>
				<?php
				}
				?>
				<input type="button" id="submit" class="button secondary" value="Test API"/>
			</div>
			<div class="large-5 large-2-offset small-12 columns">
				<h5>Response</h5></br>
				<textarea readonly name="response" style="resize:none;height:120px;" id="response"></textarea>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() 
{
<?php 
if($check)
{
?>
	$('#sample').change(function()
	{
		if($("#sample").is(':checked'))
		{
<?php 
for($i=0;$i<sizeof($params);$i++)
{
	$par = $params[$i];
	$sam = $sample[$i];
	echo "\t\t\t$('#$par').val('$sam');\n";
}
?>			
		}
		else
		{
<?php 
for($i=0;$i<sizeof($params);$i++)
{
	$par = $params[$i];
	echo "\t\t\t$('#$par').val('');\n";
}
?>		
		} 
	});
<?php
}
?>
	$('#submit').click(function()
	{
		$('#response').text("");
<?php 
$post = '';
for($i=0;$i<sizeof($params);$i++)
{
	$par = $params[$i];
	$post = $post.$par.':'.$par.',';
	echo "\t\tvar $par= $('#$par').val();\n";
}
?>
		$.<?php echo strtolower($end['method']); ?>('api/<?php echo $end['url']; ?>',{<?php echo $post; ?>}).done( function(data)
        {
            $('#response').text(JSON.stringify(data));
        }).fail( function(xhr, textStatus, errorThrown)
        {
            alert(errorThrown);
        });
	});
});
</script>

<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->