<?php
	require 'include/core.inc.php';
	session_destroy();
	
	header('Location:index.php');
	ob_get_clean();
?>