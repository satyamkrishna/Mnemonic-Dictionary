<?php

require_once 'dbhelper.inc.php';

class User
{
    public function __construct()
    {

    }

    public static function getUserProfile($userID)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        $result=$db->ud_whereQuery('ud_user',NULL,array('userID' => $userID));
        $data = $db->ud_mysql_fetch_assoc($result);
        return 'resources/img/profile/'.$data['profile'];
    }

    public function getAuthKey($userID)
    {
        $db = new dbHelper;
        $db-> ud_connectToDB();
        $result=$db->ud_whereQuery('ud_user',NULL,array('userID' => $userID));
        $user = $db->ud_mysql_fetch_assoc($result);

        if(strlen($user['authKey'])<32)
        {
            $authKey = md5($user['userID'].$user['email'].time());
            $db->ud_updateQuery('ud_user',array('authKey'=>$authKey,'auth_time'=>$db->ud_timestamp()),array('userID'=>$user['userID']));
            return $authKey;
        }
        else
        {
            return $user['authKey'];
        }
    }
    
    public function setGPlus($userID)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        
        $db->ud_updateQuery('ud_user',array('isG+'=>1),array('userID' => $userID));
    }

    public function setFB($userID)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        
        $db->ud_updateQuery('ud_user',array('isFB'=>1),array('userID' => $userID));
    }

    public function setGPlusSession($userID,$profile)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        echo $userID.'->'.$profile;
        $this->setSession($userID);
        $db->ud_updateQuery('ud_user',array('isG+'=>1),array('userID' => $userID));
        $_SESSION['profile'] = $profile;
    }

    public function setFBSession($userID,$id)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();

        $this->setSession($userID);
        $db->ud_updateQuery('ud_user',array('isFB'=>1),array('userID' => $userID));
        $_SESSION['profile'] = 'https://graph.facebook.com/'.$id.'/picture?width=160&height=160';
    }

    public function setSession($userID)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();

        $result=$db->ud_whereQuery('ud_user',NULL,array('userID' => $userID));
        $data = $db->ud_mysql_fetch_assoc($result);

        $_SESSION['name']  = $data['name'];
        $_SESSION['userID']= $data['userID'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['clearance'] = $data['clearance'];
        $_SESSION['profile']='resources/img/profile/'.$data['profile'];
        $db->ud_insertQuery('ud_users_login',array('userID'=>$_SESSION['userID'] , 'loginIP' => $_SERVER['REMOTE_ADDR'] ,'loginTimeStamp'=>date('Y-m-d H:i:s',time())));

    }

    public function getUserID($email,$password)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        $result = $db->ud_whereQuery('ud_user',NULL,array('email'=>$email,'password'=>$password));
        if($db->ud_getRowCountResult($result)==0)
        {
            return null;
        }
        else
        {
            $user = $db->ud_mysql_fetch_assoc($result);
            return $user['userID'];
        }
    }

    public function register_user($name,$email,$password=NULL,$createdBy=NULL,$clearance = 1)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        $pass = 'NULL';
        $create = 'NULL';
        if($createdBy!=NULL)
        {
            $create = '\''.$createdBy.'\'';
        }
        if($password!=NULL)
        {
            $pass = '\''.md5($password).'\'';
        }

        $result = $db->ud_whereQuery('ud_user',NULL,array('email'=>$email));
        if($db->ud_getRowCountResult($result)==0)
        {
            $sql = "INSERT INTO ud_user ( `name` ,`email` ,`password` ,`createdBy`,`clearance`) VALUES ('$name','$email',$pass,$create,$clearance);";
            $db->ud_getQuery($sql);
        }
        return $this->get_user_id_by_email($email);
    }

    public function setUserClearance($userID,$clearance=1)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        if($clearance>0 && $clearance<=$_SESSION['clearance'])
        {
            $db->ud_updateQuery('ud_user',array('clearance'=>$clearance),array('userID'=>$userID));
        }
    }

    private function get_user_id_by_email($email)
    {
        $db = new dbHelper;
        $db -> ud_connectToDB();
        $result = $db->ud_whereQuery('ud_user',NULL,array('email'=>$email));
        if($db->ud_getRowCountResult($result)==0)
        {
            return null;
        }
        else
        {
            $user = $db->ud_mysql_fetch_assoc($result);
            return $user['userID'];
        }
    }
}


?>