<?php

require 'include.php';

$db = new dbHelper;
$db->ud_connectToDB();

$error = new Error();

$data = array();

if (isset($_GET['access_token'],$_GET['wordID']))
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
            if(empty($_GET['wordID']))
            {
                $data['message'] = 'No Word Present';
            }
            else
            {
                $result = $db -> ud_getQuery('SELECT * FROM `word_list` WHERE wordID = '.$_GET['wordID']);
                $word_list = $db -> ud_mysql_fetch_assoc_all($result);    
            
                if(sizeof($word_list)==0)
                {
                    $data['message'] = 'No Word Present';
                }
                else
                {
                    $data['message'] = 'success';
                    $json_array = array();
                    for($ind=0;$ind<sizeof($word_list);$ind++)  
                    {
                        $wordID = $word_list[$ind]['wordID'];
                        $wordObj = array();
                        $result = $db -> ud_whereQuery('mnemonics_word_list', NULL, array('wordID' => $wordID));
                        $mnemonics = $db -> ud_mysql_fetch_assoc_all($result);
                        $mnemonics_arr = array();
                        for ($i = 0; $i < sizeof($mnemonics); $i++) 
                        {
                            $mnemonics_arr[$i] = $mnemonics[$i]['mnemonic'];
                        }
                        
                        $result = $db -> ud_whereQuery('definition_word_list', NULL, array('wordID' => $wordID));
                        $defintion = $db -> ud_mysql_fetch_assoc_all($result);
                        $defintion_arr = array();
                    
                        for ($i = 0; $i < sizeof($defintion); $i++) 
                        {
                            $result = $db -> ud_whereQuery('synonym_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
                            $synonym = $db -> ud_mysql_fetch_assoc_all($result);
                            $synonym_arr = array();
                    
                            for ($j = 0; $j < sizeof($synonym); $j++) 
                            {
                                $synonym_arr[$j] = $synonym[$j]['synonym'];
                            }
                    
                            $result = $db -> ud_whereQuery('sentence_word_list', NULL, array('definitionID' => $defintion[$i]['definitionID']));
                            $sent = $db -> ud_mysql_fetch_assoc_all($result);
                            $sent_arr = array();
                    
                            for ($j = 0; $j < sizeof($sent); $j++) 
                            {
                                $sent_arr[$j] = $sent[$j]['sentence'];
                            }
                    
                            $defintion_arr[$i] = array('def' => $defintion[$i]['definition'], 'syn' => $synonym_arr, 'sent' => $sent_arr);
                        }
                        
                        $wordObj['word'] = $word_list[$ind]['word'];
                        $wordObj['wordID'] = $wordID;
                        $wordObj['definition_short'] = $word_list[$ind]['definition_short'];
                        $wordObj['mnemonics_arr'] = $mnemonics_arr;
                        $wordObj['defintion_arr'] = $defintion_arr;
                        $json_array[$ind] = $wordObj;   
                    }
                    $data['word'] = $json_array[0];
                }
            }
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

function check_null($data)
{
    if($data==null)
        return 0;
    else
        return $data+1-1;
}
?>