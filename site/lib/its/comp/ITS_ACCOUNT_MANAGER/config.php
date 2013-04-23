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
 
 
include_once("_config/CONFIG_ADMINITS_PROD.php5");//production

class ITS_ACCOUNT_MANAGER_CONFIG
{
    public static $DIR_TMPLT = "/_tmplt/myaccount/"; //This will initially default within component dir
    public static $FILENAME_WEBPG_TMPLT = "tmplt_webpg_myaccount.html";
    public static $FILENAME_WDGT_TMPLT_MYACCOUNT = "tmplt_wdgt_myaccount.html";
    public static $FILENAME_WDGT_TMPLT_SIGNIN = "tmplt_wdgt_myaccount_signin.html";
    public static $FILENAME_WDGT_TMPLT_CREATE = "tmplt_wdgt_myaccount_create.html";
    public static $FILENAME_WDGT_TMPLT_CREATE_ACCNT_SUCCESSFUL = "tmplt_wdgt_myaccount_create_successful.html";
    public static $FILENAME_WDGT_TMPLT_PWDASSIST = "tmplt_wdgt_myaccount_pwdassist.html";

    /*THESE ARE NOT IMPLEMENTED YET*/
    public static $HREF_MYACCOUNT_SIGNIN = "/myaccount/signin/";
    public static $HREF_MYACCOUNT_SIGNIN_SUBMIT = "/myaccount/signin/submit.php";
    public static $HREF_MYACCOUNT_CREATE = "/myaccount/create/";
    public static $HREF_MYACCOUNT_CREATE_ACCNT_CREATED = "/myaccount/createAccntSuccessful.php";

    public static $HREF_MYACCOUNT_CREATE_SUBMIT = "/myaccount/create/submit.php";
    public static $HREF_MYACCOUNT_PWDASSIST = "/myaccount/pwdassist/";
    /*END THESE ARE NOT IMPLEMENTED YET*/
    
    private function __construct()
    {
        foreach (get_class_vars(get_class($this)) as $name => $value) { if (substr( $name, 0, 4 ) === "DIR_") self::$$name =  CONFIG::$ROOT.self::$$name;}
        /**
        * CAN SET LINKS HERE BASED ON THE WEBSITE'S CENTRAL LINK REPOSITORY SO THAT  ALL LINKS ARE CONTROLLED THERE
        * Example
        *   $HREF_MYACCOUNT_SIGNIN = LNK::get("MYACCOUNT_SIGNIN");                                                                                                         
        *   $HREF_MYACCOUNT_SIGNIN_SUBMIT = LNK::get("MYACCOUNT_SIGNIN"); 
        */        
    }
    public static function init()
    {
        new ITS_ACCOUNT_MANAGER_CONFIG();
    }
}
ITS_ACCOUNT_MANAGER_CONFIG::init();
include_once (CONFIG_ADMINITS::$DIR_UTIL."DBUG.php5");
include_once("SECURITY.php5");
include_once(CONFIG_ADMINITS::$DIR_BL."_sec/SEC.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL."GBL.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL."UTIL.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL."VALIDATOR.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."dbdalObj.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."dbdal.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."DBStmtMySQL.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_BL."FrmObj.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_BL."Frm_Validator.php5");
include_once(CONFIG_ADMINITS::$DIR_UTIL_HTTP."REQUEST4.php5");

include_once CONFIG_ADMINITS::$DIR_DBDAL."dbdalCLIENT.php5";        
include_once CONFIG_ADMINITS::$DIR_DBDAL."dbdalCLIENT_ADDRESS.php5";

//include_once (CONFIG_ADMINITS::$DIR_UTIL."DBUG.php5");        

//include_once("SECURITY.php5");
include_once("CONSTANTS.php5");
include_once("TEXT.php5");
include_once("_lib/EmailAddressValidator.php5");
//include_once("_html/HTML_STORE.php5");
include_once("Google.php5");//should only load when needed
//include("ShopSession.php5"); //itsComments: when was this disabled?? 
include("ITS_ACCOUNT_MANAGER_INCLUDES.php"); 
 
?>