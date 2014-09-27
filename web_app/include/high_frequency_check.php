<?php
require_once 'user_clearance.inc.php';

if(isset($_GET['high']))
{
    if(!empty($_GET['high']))
    {
        Clearance::redirectIfNotEnoughClearance(Clearance::$MODULE_HIGH_FREQUENCY_HEADER);

        $db = new dbHelper;
        $db->ud_connectToDB();

        $data = $db->ud_whereQuery('ud_high_frequency',NULL,array('id'=>$_GET['high']));
        if($db->ud_getRowCountResult($data)!=0)
        {
            $high_check_bool = true;
            $high_for_pagination = '&high='.$_GET['high'];
            $high_sql_query_and_part = ' AND w.wordID IN (SELECT wordID FROM `ud_high_frequency_words` WHERE ud_high_frequency_id = '.$_GET['high'].') ';
        }
        else
        {
            unset($_GET['high']);
            $url = 'location:'.basename($_SERVER['PHP_SELF']).'?';
            foreach ($_GET as $key=>$val)
            {
                $url = $url.$key.'='.$val.'&';
            }

            header($url);
        }
    }
}

?>