<?php
if (function_exists('date_default_timezone_set'))
{
    date_default_timezone_set('Asia/Calcutta');
}
session_start();
ob_start();
$currentfile=$_SERVER['SCRIPT_NAME'];

function ud_user_loggedin()
{
    if(isset($_SESSION['userID']) && !empty($_SESSION['userID']))
    {
        return true;
    }
    else return false;
}
?>