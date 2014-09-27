<?php

require_once 'dbhelper.inc.php'; 
require_once 'sync.inc.php';

class GCM 
{
    private $API = 'AIzaSyDSDSHpw4XAsd7bjJtWATasGQeOiAS21o4';
 	
    public function __construct()
    {
    	
    }
 		
	public function gcm($registatoin_ids, $field,$is_print=true,$dry = false) 
    {
    	if(sizeof($registatoin_ids)==0)
    	{
    		echo '"registration_ids" field cannot be empty';
    		return;
    	}	
    	$db = new dbHelper;
		$db->ud_connectToDB();	
		
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
        	'dry_run'=>$dry,
            'registration_ids' =>$registatoin_ids,
        );
		
		foreach ($field as $key => $value) 
		{
			$fields[$key] = $value;	
		}
		 
        $headers = array(
            'Authorization: key=' .$this->API,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) 
        {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        if($is_print)
        {
        	echo $result;
		}
		
        $result = $db->ud_whereQuery('ud_user_gcm',NULL,array('gcmID'=>$registatoin_ids[0]));
    	$data = $db->ud_mysql_fetch_assoc($result);
        $db->ud_insertQuery('ud_user_gcm_log',array('userID'=>$data['userID'],'message'=>json_encode($fields['data']),'timestamp'=>$db->ud_timestamp()));
    }
	
    public function send_notification($registatoin_ids, $message,$is_print=true,$dry = false) 
    {
    	$this->gcm($registatoin_ids,array('data'=>$message),$is_print);
    } 
 	
 	public function send_notification_by_user_id($userID, $message,$is_print=true) 
    {
    	$db = new dbHelper;
		$db->ud_connectToDB();	
		
		$result = $db->ud_whereQuery('ud_user',NULL,array('userID'=>$userID,'isGCM'=>1));
		if($db->ud_getRowCountResult($result)>0)
    	{
    		$this->send_notification($this->getGCMID($userID), $message,$is_print);    
		}
	}
	
	public function send_sync_message($type,$wordID)
 	{
 		$db = new dbHelper;
		$db->ud_connectToDB();	
		
		$result = $db->ud_whereQuery('ud_user',NULL,array('userID'=>$_SESSION['userID'],'isGCM'=>1));
		if($db->ud_getRowCountResult($result)>0)
    	{
    		$data = $db->ud_mysql_fetch_assoc($result);
    		$this->gcm($this->getGCMID($data['userID']),array('data'=>array('type'=>'sync'),'collapse_key'=>'sync'),false);
			create_json_for_sync($type,$wordID);
		}
 	}
 	
 	public function getGCMID($userID)
 	{
 		$db = new dbHelper;
		$db->ud_connectToDB();	
		
		$result = $db->ud_whereQuery('ud_user_gcm',NULL,array('userID'=>$userID));	
		$gcm    = $db->ud_mysql_fetch_assoc_all($result);
		$gcm_array = array();
		foreach ($gcm as $value) 
		{
			array_push($gcm_array,$value['gcmID']);
		}
		return $gcm_array;
 	}
}
?>