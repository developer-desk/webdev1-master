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
 
 
include_once(CONFIG_ADMINITS::$DIR_PL."MYACCOUNT_SIGNIN_PL.php");

class MYACCOUNT_SIGNIN
{
    
    private function __construct()
    {
    }   
     
    private static function process()
    {
        $errMsg = ShopSession::errMsg();       
        $email_address = ShopSession::getClientEmail();
        $checked1=$checked2 = "";
        $checked1="checked";
        
        return MYACCOUNT_SIGNIN_PL::getSignInPage($email_address, $checked1, $checked2, $errMsg);        
    }   
    
    public static function view()
    {
        return MYACCOUNT_SIGNIN::process();
    }        
}

  
?>