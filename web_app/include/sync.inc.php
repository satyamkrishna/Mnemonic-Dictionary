<?php

require_once 'dbhelper.inc.php';

function create_json_for_sync($type,$wordID)
{
	switch($type)
	{
		case 'fav':
            insert_into_table('queue_fav',$wordID);
            remove_from_table('queue_unfav',$wordID);
            remove_from_table('queue_ignore',$wordID);
			break;
		case 'unfav':
            insert_into_table('queue_unfav',$wordID);
            remove_from_table('queue_fav',$wordID);
			break;
		case 'history':
            insert_into_table('queue_history',$wordID);
			break;
		case 'ignore';
            remove_from_table('queue_fav',$wordID);
            insert_into_table('queue_ignore',$wordID);
            break;
	}
}

function insert_into_table($table,$wordID)
{
    $db = new dbHelper;
    $db->ud_connectToDB();

    $result = $db->ud_whereQuery('ud_user_gcm',NULL,array('userID'=>$_SESSION['userID']));
    if($db->ud_getRowCountResult($result)!=0)
    {
        $gcm_reg = $db->ud_mysql_fetch_assoc_all($result);
        foreach($gcm_reg as $user)
        {
            $user_gcm_id = $user['id'];
            $result = $db->ud_whereQuery($table,NULL,array('user_gcm_ID'=>$user_gcm_id));
            if($db->ud_getRowCountResult($result)!=0)
            {
                $json = $db->ud_mysql_fetch_assoc($result);
                $result = $db->ud_getQuery('SELECT * FROM '.$table.' WHERE user_gcm_ID = '.$user_gcm_id.' AND json LIKE \'%'.$wordID.'%\'');
                if($db->ud_getRowCountResult($result)==0)
                {
                    $data = json_decode($json['json'],true);
                    array_push($data,array('wordID'=>$wordID,'time'=>$db->ud_timestamp()));
                    $db->ud_updateQuery($table,array('json'=>json_encode($data)),array('user_gcm_ID'=>$user_gcm_id));
                }
            }
            else
            {
                $db->ud_insertQuery($table,array('user_gcm_ID'=>$user_gcm_id,'json'=>json_encode(array(array('wordID'=>$wordID,'time'=>$db->ud_timestamp())))));
            }
        }
    }
}


function remove_from_table($table,$wordID)
{
    $db = new dbHelper;
    $db->ud_connectToDB();

    $result = $db->ud_whereQuery('ud_user_gcm',NULL,array('userID'=>$_SESSION['userID']));
    if($db->ud_getRowCountResult($result)!=0)
    {
        $gcm_reg = $db->ud_mysql_fetch_assoc_all($result);
        foreach($gcm_reg as $user)
        {
            $user_gcm_id = $user['id'];
            $result = $db->ud_getQuery('SELECT * FROM '.$table.' WHERE user_gcm_ID = '.$user_gcm_id.' AND json LIKE \'%'.$wordID.'%\'');
            if($db->ud_getRowCountResult($result)!=0)
            {
                $json = $db->ud_mysql_fetch_assoc($result);
                $data = json_decode($json['json'],true);
                $data_new = array();
                foreach($data as $wordObj)
                {
                    if($wordObj['wordID']!=$wordID)
                    {
                        array_push($data_new,$wordObj);
                    }
                }
                $db->ud_updateQuery($table,array('json'=>json_encode($data_new)),array('user_gcm_ID'=>$user_gcm_id));
            }
        }
    }
}

?>