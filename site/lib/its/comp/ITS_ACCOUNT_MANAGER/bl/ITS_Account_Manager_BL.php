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

class ITS_Account_Manager_BL
{
    private $User;
    
	public static function setRedirectTo()
	{
	
	$instance=ITS_REDIRECT_TO;
	if $_SERVER[HTTP_REFERRER!=Null]
      {	
         $_SERVER[‘HTTP_REFERRER’]
      }
   else 
       {
         $_SERVER['SERVER_NAME']
	    }
	
	
	public static function initSignIn()
	{
	 $instance = ITS_FLG_PROCESS_SIGNIN;
	 $instance=true;
	 ITS_Account_Manager_BL::setRedirectTo();
	 
	}
	
	public static function initCreateAccnt()
	{
	 $instance =ITS_FLG_PROCESS_CREATE_ACCNT;
	 $instance=true;
	}
	
	public static function isRedirectRequiredAfterSignin()
	{
	if($ITS_REDIRECT_TO !=null || $ITS_FLG_PROCESS_SIGNIN=true)
	 $instance=true;
	}
	
	
	public static function isRedirectRequiredAfterCreateAccount()
	{
	if($ITS_REDIRECT_TO !=null || $ITS_FLG_PROCESS_CREATE_ACCNT=true)
	 $instance=true;
	}
	
	public static function redirect()
	{
	private static $instance = null;
	$instance=ITS_REDIRECT_TO;
	
	if($ITS_REDIRECT_TO !=null)
	   {
	     ShopSession::redirect(ITS_REDIRECT_TO);
	    }
	}
	}
	}

?>