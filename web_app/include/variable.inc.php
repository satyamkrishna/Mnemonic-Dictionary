<?php

$high_for_pagination = '';
$high_sql_query_and_part = '';
$high_check_bool = false;

if($_SERVER['SERVER_ADDR']=='127.0.0.1'||$_SERVER['SERVER_ADDR']=='::1')
{
    $high_for_pagination = '';
    $high_sql_query_and_part = '';
    $high_check_bool = false;
}

?>