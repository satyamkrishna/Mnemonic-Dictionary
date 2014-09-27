<?php

require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$error = new Error();

$data = array();

if (isset($_GET['authKey']))
{
    if (!empty($_GET['authKey']))
    {
        $auth = htmlentities($_GET['authKey']);

        $query = $db->ud_whereQuery('ud_user', NULL, array('authkey' => $auth));
        if ($db->ud_getRowCountResult($query) == 0)
        {
            $data['message'] = 'Auth Key Not Associated with any user';
        }
        else
        {
            $data['message'] = 'Auth Key Match';
            $user = $db->ud_mysql_fetch_assoc($query);
            $result = $db->ud_whereQuery('ud_user_fav', array('wordID'), array('userID' => $user['userID']));
            $fav = $db->ud_mysql_fetch_assoc_all($result);
            $fav_array = array();
            foreach ($fav as $value)
            {
                array_push($fav_array, $value['wordID']);
            }
            $data['fav'] = $fav_array;

            $result = $db->ud_whereQuery('ud_user_history', array('wordID'), array('userID' => $user['userID']));
            $history = $db->ud_mysql_fetch_assoc_all($result);
            $history_array = array();
            foreach ($history as $value)
            {
                array_push($history_array, $value['wordID']);
            }
            $data['history'] = $history_array;

            $result = $db->ud_whereQuery('ud_user_ignore', array('wordID'), array('userID' => $user['userID']));
            $ignore = $db->ud_mysql_fetch_assoc_all($result);
            $ignore_array = array();
            foreach ($ignore as $value)
            {
                array_push($ignore_array, $value['wordID']);
            }
            $data['ignore'] = $ignore_array;
        }
        echo json_encode($data);
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