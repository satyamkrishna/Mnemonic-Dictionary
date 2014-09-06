<?php

require_once 'core.inc.php';
require_once 'dbhelper.inc.php';
require_once 'error.inc.php';
require 'user_clearance.inc.php';

Clearance::badRequestIfNotEnoughClearance(Clearance::$MODULE_HIGH_FREQUENCY_ADD);

$db = new dbHelper;
$db -> ud_connectToDB();
$error = new Error();

if(isset($_POST['id'],$_POST['data']))
{
    if(!empty($_POST['id']) &&!empty($_POST['data']))
    {

        $id = htmlentities($_POST['id']);
        $data = htmlentities($_POST['data']);

        $result = $db->ud_whereQuery('ud_high_frequency',NULL,array('id'=>$id));
        $list   = $db->ud_mysql_fetch_assoc($result);

        if( $db->ud_getRowCountResult($result)!=0)
        {
            $data = explode(',',$data);
            $added = array();
            $not_found = array();
            $already = array();

            foreach($data as $word)
            {
                $result = $db->ud_whereQuery('word_list',NULL,array('word'=>$word));
                if( $db->ud_getRowCountResult($result)!=0)
                {
                    $word_list_item = $db->ud_mysql_fetch_assoc($result);
                    $result = $db->ud_whereQuery('ud_high_frequency_words',NULL,array('wordID'=>$word_list_item['wordID']));
                    if( $db->ud_getRowCountResult($result)!=0)
                    {
                        array_push($already,$word);
                    }
                    else
                    {
                        $db->ud_insertQuery('ud_high_frequency_words',array('wordID'=>$word_list_item['wordID'],'ud_high_frequency_id'=>$_POST['id']));
                        array_push($added,$word);
                    }
                }
                else
                {
                    array_push($not_found,$word);
                }
            }

            echo json_encode(array('added'=>$added,'not'=>$not_found,'already'=>$already));
        }
        else
        {
            $error->parameters_either_empty_or_not_provided();
        }
    }
    else
    {
        $error->parameters_either_empty_or_not_provided();
    }
}
else
{
    $error->parameters_either_empty_or_not_provided();
}

?>