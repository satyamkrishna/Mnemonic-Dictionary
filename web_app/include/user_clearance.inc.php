<?php

require_once 'error.inc.php';
require_once 'dbhelper.inc.php';

class Clearance
{
    public static $ONE = 1;
    public static $TWO = 2;
    public static $FOUR = 4;
    public static $SIX = 6;

    public static $MODULE_MNEMONIC_ADD = 2;
    public static $MODULE_HIGH_FREQUENCY_HEADER = 4;
    public static $MODULE_HIGH_FREQUENCY_ADD = 6;
    public static $MODULE_ADMIN_PANEL = 7;
    public static $MODULE_WORD_P = 8;
    public static $MODULE_ANDROID = 8;

    public static $USER = 1;
    public static $ADMIN = 7;
    public static $SUPER_ADMIN = 8;

    public function __construct()
    {

    }

    public static function updateUserClearance()
    {
        $db = new dbHelper();
        $db->ud_connectToDB();

        $result = $db->ud_whereQuery('ud_user',NULL,array('userID'=>$_SESSION['userID']));
        $user = $db->ud_mysql_fetch_assoc($result);
        $_SESSION['clearance'] = $user['clearance'];
    }

    public static function checkClearance($clearance)
    {
        if($clearance > $_SESSION['clearance'])
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public static function redirectIfNotEnoughClearance($clearance,$redirectURI='dashboard.php')
    {
        if($clearance > $_SESSION['clearance'])
        {
            header('location:'.$redirectURI);
        }
    }

    public static function dieIfNotEnoughClearance($clearance)
    {
        if($clearance > $_SESSION['clearance'])
        {
            die('Not Enough Clearance for the User');
        }
    }

    public static function badRequestIfNotEnoughClearance($clearance)
    {
        if($clearance > $_SESSION['clearance'])
        {
            $error = new Error();
            $error->parameters_either_empty_or_not_provided();
        }
    }
}


?>