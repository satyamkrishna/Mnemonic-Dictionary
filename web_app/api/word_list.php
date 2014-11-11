<?php

require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$error = new Error();

$data = array();

if (isset($_GET['access_token']))
{
    if (!empty($_GET['access_token']))
    {
        $access_token = htmlentities($_GET['access_token']);
        $result = $db->ud_whereQuery('ud_user', NULL, array('authkey' => $access_token));
        if ($db->ud_getRowCountResult($result) == 0)
        {
            $data['message'] = 'Access Token Not Associated with any user';
        }
        else
        {
            $result = $db -> ud_getQuery("SELECT * FROM `word_list`");
            $word_list = $db -> ud_mysql_fetch_assoc_all($result);
            $json_array = array();
            for($ind=0;$ind<sizeof($word_list);$ind++)  
            {
                $wordID = $word_list[$ind]['wordID'];
                $wordObj = array();
                $wordObj['word'] = $word_list[$ind]['word'];
                $wordObj['wordID'] = $wordID;
                $wordObj['definition_short'] = $word_list[$ind]['definition_short'];
                $json_array[$ind] = $wordObj;
            }
        }
        $data['data'] = $json_array;
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

function check_null($data)
{
    if($data==null)
        return 0;
    else
        return $data+1-1;
}
?>