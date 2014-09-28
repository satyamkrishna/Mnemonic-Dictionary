<?php

	if(!isset($_SESSION['userID']) && empty($_SESSION['userID']))
	{
        header('location:index.php?redirect_uri='.basename($_SERVER['PHP_SELF'],'.php').'.php');
	}

?>