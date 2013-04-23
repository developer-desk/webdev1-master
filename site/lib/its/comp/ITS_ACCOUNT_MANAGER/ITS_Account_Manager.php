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
include_once(ITS_ROOT_DIR.'lib\its\comp\ITS_ACCOUNT_MANAGER\bl\_sec\SEC.php5');

class ITS_Account_Manager
{
    private $User;
    
	public static function getCurrentUser()
	{
	$User=SEC::getCurrentUser();
	return User;
	}
	
	
	public static function signOut()
	{
	ShopSession::killSession();
	$user = null;
	ShopSession::redirect(ROOT_WEB.”index.php”);
	}
	
	private static $instance = null;
	
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
      
	
		
 }


?>