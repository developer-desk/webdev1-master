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
 
 
class ITS_ACCOUNT_MANAGER_INCLUDES
{
    public static $MYACCOUNT  = "/client/myaccount/myaccount.php";      
    public static $MYACCOUNT_SIGNIN  = "/client/myaccount/MYACCOUNT_SIGNIN.php";
    public static $MYACCOUNT_SIGNOUT  = "/client/myaccount/MYACCOUNT_SIGNIN.php";
    public static $MYACCOUNT_SIGNIN_SUBMIT  = "/client/myaccount/MYACCOUNT_SIGNIN_SUBMIT.php";      
    public static $MYACCOUNT_CREATE  = "/client/myaccount/MYACCOUNT_CREATE.php";      
    public static $MYACCOUNT_CREATE_SUBMIT  = "/client/myaccount/MYACCOUNT_CREATE_SUBMIT.php";      
    public static $MYACCOUNT_CREATE_SUCCESSFUL  = "/client/myaccount/MYACCOUNT_CREATE_SUCCESSFUL.php";      
    public static $MYACCOUNT_PWDASSIST  = "/client/myaccount/MYACCOUNT_PWDASSIST.php";      
    
    public function __construct()
    {
      foreach (get_class_vars(get_class($this)) as $name => $value) { if ($name != "ROOT") self::$$name =  CONFIG::$ROOT.self::$$name;}          
    }
}
new ITS_ACCOUNT_MANAGER_INCLUDES();
?>