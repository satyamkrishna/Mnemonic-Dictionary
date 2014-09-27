<?php
ini_set('max_execution_time', 300);
require 'include/core.inc.php';
require 'include/dbhelper.inc.php';
require 'include/loggedin.php';
require 'include/user_clearance.inc.php';
require 'include/pronunciation.inc.php';

Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_WORD_P);

$db = new dbHelper;
$db -> ud_connectToDB();

$Word_P = new Pronunciation();

$data = $db->ud_whereQuery('word_list');
$words = $db->ud_mysql_fetch_assoc_all($data);

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
<title>Pronunciation - GRE</title>
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
				<table class="dashboard">
					<thead>
						<tr>
							<th style="text-align:center;width:25px;">#</th>
							<th>Word</th>
							<th>Pronunciation</th>
						</tr>
					</thead>
                    <tbody>
                    <?php
                    for($i=0;$i<sizeof($words);$i++)
                    {
                    ?>
                        <tr>
                            <td><?php echo ($i+1); ?></td>
                            <td><?php echo $words[$i]['word'];?></td>
                            <td>
                                <?php
                                if(Pronunciation::check_word_file_is_present($words[$i]['word']))
                                {
                                    ?>
                                    <img src="resources/img/common/speaker.png" class="speaker" id="<?php echo Pronunciation::getFileName($words[$i]['word']); ?>"/>
                                    <?php
                                }
                                ?>
                            </td>
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
<span id="dummy"></span>
<script type="text/javascript" charset="utf-8">
$(document).ready(function()
{
	$('.dashboard').dataTable(
	{
		"sPaginationType" : "full_numbers"
	});

    $(document.body).on('click', ".speaker", function(e)
    {
        file_path = $(this).attr('id');
        playSound(file_path);
    });

    function playSound(soundfile)
    {
        var obj = document.createElement("audio");
        obj.setAttribute("src", soundfile);
        $.get();
        obj.play();
    }
});
</script>
<?php require 'include/footer.php';?>
</body>
</html>
<![endif]-->