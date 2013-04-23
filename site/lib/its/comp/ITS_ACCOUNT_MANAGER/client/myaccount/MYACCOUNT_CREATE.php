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
 
 
include_once(CONFIG_ADMINITS::$DIR_PL."MYACCOUNT_CREATE_PL.php");

class MYACCOUNT_CREATE
{
    private $webpg_tmplt_id;//later can allow this to be changed through a function
    private $wdgt_tmplt_id;//later can allow this to be changed through a function
    
    private function __construct()
    {
        if (!isset($webpg_tmplt_id)) $this->webpg_tmplt_id = GMOP_TMPLT_CONFIG::$WBPG_TMPLT_ID_GMOP;
        if (!isset($wdgt_tmplt_id)) $this->wdgt_tmplt_id = GMOP_TMPLT_CONFIG::$WDGT_TMPLT_ID_GMOP_SIGNIN;
    }   
     
    private static function process()
    {
        $CLIENT_EMAIL_ADDRESS = isset($_GET['CLIENT_EMAIL_ADDRESS'])?$_GET['CLIENT_EMAIL_ADDRESS']:null;
        $CLIENT_EMAIL_ADDRESS_REENTRY ="";
        if ($CLIENT_EMAIL_ADDRESS=="")
        {
            $CLIENT_EMAIL_ADDRESS = isset($_SESSION['TMP_CLIENT_EMAIL_ADDRESS'])?$_SESSION['TMP_CLIENT_EMAIL_ADDRESS']:null;
            $CLIENT_EMAIL_ADDRESS_REENTRY = isset($_SESSION['TMP_CLIENT_EMAIL_ADDRESS_REENTRY'])?$_SESSION['TMP_CLIENT_EMAIL_ADDRESS_REENTRY']:null;    
        }

        $CLIENT_FULL_NAME = isset($_SESSION['TMP_CLIENT_FULL_NAME'])?$_SESSION['TMP_CLIENT_FULL_NAME']:null;
        $errMsg = ShopSession::errMsg();       
        
        return MYACCOUNT_CREATE_PL::getCreateAccountPage($CLIENT_EMAIL_ADDRESS, $CLIENT_EMAIL_ADDRESS_REENTRY, $CLIENT_FULL_NAME, $errMsg);        
    }   
    
    public static function view()
    {
        return MYACCOUNT_CREATE::process();
    }        
}

////$frm = ClientCreateAccount::display();
////echo HTML_STORE::createWebPgSrchResults($frm, null, TEXT::get("MYACCNT_CREATE_ACCNT"), null, TEXT::get("MYACCNT_CREATE_ACCNT"));

  
?>