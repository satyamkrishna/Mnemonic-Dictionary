<?php

$fbAPPID = '1452417911661818';
$fbAPPSecret = 'd197770d927754b84e0959374b03368f';
$fbURL = 'http://www.utopiadevelopers.com/gre/index.php';

if($_SERVER['SERVER_ADDR']=='127.0.0.1'||$_SERVER['SERVER_ADDR']=='::1')
{
    $fbAPPID = '1473893062847636';
    $fbAPPSecret = '5748ac5fe73873a50ca0cfb75288f923';
    $fbURL = 'http://localhost/utopia-gre/web_app/index.php';
}

?>