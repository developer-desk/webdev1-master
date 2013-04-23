<?php
/* Copyright (C) 2009 - 2013 Infinite Tech Solutions Inc - All Rights Reserved
*
* NOTICE: All information contained herein is, and remains
* the PROPERTY OF INFINITE TECH SOLUTIONS INCORPORATED. 
* The intellectual and technical concepts contained
* herein are proprietary to Infinite Tech Solutions Incorporated
* and may be covered by U.S., Canadian, and Foreign Patents,
* patents in process, and are protected by trade secret or copyright law.
* DISSEMINATION OF THIS INFORMATION OR REPRODUCTION OF THIS MATERIAL
* IS STRICTLY FORBIDDEN UNLESS PRIOR WRITTEN PERMISSION IS OBTAINED
* FROM INFINITE TECH SOLUTIONS INCORPORATED.
*/ 
include_once('ITS_User.php5');
include_once(ITS_ROOT_DIR.'lib/its/comp/ITS_ACCOUNT_MANAGER/ShopSession.php5');
class SEC
{
    
    private static $instance = null;
    private $user_id = null;

    
    private function __construct()
    {
        //this should read the uid from the Seesion
        $this->user_id = REQUEST::readIn("uid");
        $this->user_id = 199; //tmp override
    }
    
    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new SEC();   
        }
        return self::$instance;
    }
      
    public static function USER_ID()
    {
        $self = self::getInstance();
        return $self->user_id;
        
    }
	
	
	// function getCurrentUser() in class 
	
	public static function getCurrentUser()
	{
	$User=SEC::getCurrentUser();
	first_name=first_name::getClientName();
	ShopSession::setClientId($clientid);
	user_id = ShopSession::client_getClientId();
	return User;
	}
	
		
 }

class SecPermitFct
{
    public static function getObj($id, $op)
    {
        return new SecPermit($id, $op); //for now return the same generic one no matter what 
    }
}

abstract class SecPermitObj
{
    protected $id;
    protected $op;
    protected $errMsgArr = null;
    
    public function __construct($id, $op)
    {
        $this->id = $id;
        $this->op = $op;
    }
     
    public function getErrs()
    {
        return $this->errMsgArr;
    }    

    public abstract function validate();   
}


class SecPermit extends SecPermitObj
{
    public function __construct($id, $op)
    {
        parent::__construct($id, $op);
    }                                 
    
    public function validate()
    {
        $uid = SEC::USER_ID();
        //$this->errMsgsArr[$fieldName] = new ERR(100, "unauthorized user", 1,  "uid");
        return true;
    }
}

?>