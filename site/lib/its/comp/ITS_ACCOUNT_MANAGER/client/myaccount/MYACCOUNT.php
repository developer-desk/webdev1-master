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
 
include_once(CONFIG_ADMINITS::$DIR_BL."MYACCOUNT_BL.php"); 
include_once(CONFIG_ADMINITS::$DIR_PL."MYACCOUNT_PL.php");
include_once(CONFIG_ADMINITS::$DIR_PL."MYACCOUNT_WDGT.php");
class MYACCOUNT
{
    private function __construct()
    {
    }   
     
    private static function process()
    {
        $client_full_name = ShopSession::getClientName();
       
        return MYACCOUNT_PL::getMyAccountPage($client_full_name);        
    }   
    
    public static function view()
    {
        if(!MYACCOUNT_BL::displaySignIn()){
            return MYACCOUNT_WDGT:: getSigninWdgt();
        }
        else
		{
		return MYACCOUNT_WDGT:: getLoggedInWdgt();
		}
    }
}
?>