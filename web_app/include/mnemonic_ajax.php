<?php

	require_once 'core.inc.php';
	require_once 'dbhelper.inc.php';
	require_once 'loggedin.php';	
	require_once 'user_clearance.inc.php';
    require_once 'error.inc.php';

    Clearance::badRequestIfNotEnoughClearance(Clearance::$USER);

	$db = new dbHelper;
	$db->ud_connectToDB();

    $error = new Error();

    if(isset($_POST['wordID'],$_POST['data'],$_POST['func']))
    {
        if(!empty($_POST['wordID']) &&!empty($_POST['data']) &&!empty($_POST['func']))
        {
            $wordID = htmlentities($_POST['wordID']);
            $data = htmlentities($_POST['data']);

            $result = $db->ud_whereQuery('word_list',NULL,array('wordID'=>$wordID));
            if($db->ud_getRowCountResult($result)==0)
            {
                $error->parameters_either_empty_or_not_provided();
            }
            else
            {
                switch($_POST['func'])
                {
                    case 'delete';
                        $result = $db->ud_whereQuery('mnemonics_word_list',NULL,array('mnemonicID'=>$data,'wordID'=>$wordID,'addedBy'=>$_SESSION['userID']));
                        if($db->ud_getRowCountResult($result)>0)
                        {
                            $db->ud_deleteQuery('mnemonics_word_list',array('mnemonicID'=>$data,'wordID'=>$wordID,'addedBy'=>$_SESSION['userID']));
                            echo 'Done';
                        }
                        else
                        {
                            echo 'Error';
                        }
                        break;
                    case 'add':
                        if(Clearance::checkClearance(Clearance::$SUPER_ADMIN))
                        {
                            add_mnemonic($wordID,$data);
                            echo 'Done';
                        }
                        else
                        {
                            $result = $db->ud_whereQuery('mnemonics_word_list',NULL,array('wordID'=>$wordID,'addedBy'=>$_SESSION['userID']));
                            if($db->ud_getRowCountResult($result)>=2)
                            {
                                echo 'Count Error';
                            }
                            else
                            {
                                add_mnemonic($wordID,$data);
                                echo 'Done';
                            }
                        }
                        break;
                }
            }
        }
    }

    function add_mnemonic($wordID,$mnemonic)
    {
        $db = new dbHelper;
        $db->ud_connectToDB();

        $db->ud_insertQuery('mnemonics_word_list',array('wordID'=>$wordID,'mnemonic'=>$mnemonic,'addedBy'=>$_SESSION['userID']));
    }
?>