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
 
 
class LNK
{
    public static function get($id)
    {
        return "";
    }
}
/*************************************************************************************************/
class MYACCOUNT_SIGNIN
{
    public static function page()
    {
    }

    public static function process()
    {
    }
}
/*************************************************************************************************/
class ITS_ACCOUNT_MANAGER_CONFIG
{
    public static $DIR_TMPLT = "_tmplt/myaccount/"; //This will initially default within component dir
    public static $FILENAME_WEBPG_TMPLT = "tmplt_webpg_myaccount.html";
    public static $FILENAME_WDGT_TMPLT_SIGNIN = "tmplt_wdgt_myaccount_signin.html";
    public static $FILENAME_WDGT_TMPLT_CREATE = "tmplt_wdgt_myaccount_create.html";
    public static $FILENAME_WDGT_TMPLT_PWDASSIST = "tmplt_wdgt_myaccount_pwdassist.html";
    
    public static $HREF_MYACCOUNT_SIGNIN = "/myaccount/signin/";
    public static $HREF_MYACCOUNT_SIGNIN_SUBMIT = "/myaccount/signin/submit.php";
    public static $HREF_MYACCOUNT_CREATE = "/myaccount/create/";
    public static $HREF_MYACCOUNT_CREATE_SUBMIT = "/myaccount/create/submit.php";
    public static $HREF_MYACCOUNT_PWDASSIST = "/myaccount/pwdassist/";
    
    public function __construct()
    {
        /**
        * CAN SET LINKS HERE BASED ON THE WEBSITE'S CENTRAL LINK REPOSITORY SO THAT  ALL LINKS ARE CONTROLLED THERE
        * Example
        *   $HREF_MYACCOUNT_SIGNIN = LNK::get("MYACCOUNT_SIGNIN");                                                                                                         
        *   $HREF_MYACCOUNT_SIGNIN_SUBMIT = LNK::get("MYACCOUNT_SIGNIN"); 
        */        
    }
}
new ITS_ACCOUNT_MANAGER_CONFIG();

class ITS_ACCOUNT_MANAGER
{
    public static $INC_MYACCOUNT_SIGNIN  = "/client/myaccount/MYACCOUNT_SIGNIN.php";      
    public static $INC_MYACCOUNT_SIGNIN_SUBMIT  = "/client/myaccount/MYACCOUNT_SIGNIN_SUBMIT.php";      
    public static $INC_MYACCOUNT_CREATE  = "/client/myaccount/MYACCOUNT_CREATE.php";      
    public static $INC_MYACCOUNT_PWDASSIST  = "/client/myaccount/MYACCOUNT_PWDASSIST.php";      
}

//Displaying Signin Page
//www.mysite/MYACCOUNT/signin/index.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER::$INC_MYACCOUNT_SIGNIN;
MYACCOUNT_SIGNIN::view();  
                         
//Processing Submittal of Signin
//www.mysite/MYACCOUNT/signin/submit.php    
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER::$INC_MYACCOUNT_SIGNIN_SUBMIT;
MYACCOUNT_SIGNIN_SUBMIT::process();       

//Displaying Create Accnt Page
//www.mysite/MYACCOUNT/creeate/index.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER::$INC_MYACCOUNT_CREATE;
MYACCOUNT_CREATE::view();  

//Processing Submittal of Create Accnt
//www.mysite/MYACCOUNT/creeate/submit.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER::$INC_MYACCOUNT_CREATE_SUBMIT;
MYACCOUNT_CREATE::process();  


/****************************************************************************************************************/

class ITS_ACCOUNT_MANAGER_INCLUDES
{
    public static $MYACCOUNT_SIGNIN  = "/client/myaccount/MYACCOUNT_SIGNIN.php";      
    public static $MYACCOUNT_SIGNIN_SUBMIT  = "/client/myaccount/MYACCOUNT_SIGNIN_SUBMIT.php";      
    public static $MYACCOUNT_CREATE  = "/client/myaccount/MYACCOUNT_CREATE.php";      
    public static $MYACCOUNT_PWDASSIST  = "/client/myaccount/MYACCOUNT_PWDASSIST.php";      
}

//Displaying Signin Page
//www.mysite/MYACCOUNT/signin/index.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER_INCLUDES::$MYACCOUNT_SIGNIN;
MYACCOUNT_SIGNIN::view();  
                         
//Processing Submittal of Signin
//www.mysite/MYACCOUNT/signin/submit.php    
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER_INCLUDES::$MYACCOUNT_SIGNIN_SUBMIT;
MYACCOUNT_SIGNIN_SUBMIT::process();       

//Displaying Create Accnt Page
//www.mysite/MYACCOUNT/creeate/index.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER_INCLUDES::$MYACCOUNT_CREATE;
MYACCOUNT_CREATE::view();  

//Processing Submittal of Create Accnt
//www.mysite/MYACCOUNT/creeate/submit.php      
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER_INCLUDES::$MYACCOUNT_CREATE;
MYACCOUNT_CREATE::process();  

/**** Directory structure
lib/its/comp/
lib/its/util/
****/

ITS_SITE::getPageTmplt(PG_TMPLT::$MYACCOUNT);

$dataValues = ITS_SITE::getStandardPageParameters();
$tmpltId = "myaccount/signin";
$targetHTML = ITS_TMPLT::getPage($tmpltId, $dataValues);
$wdgt_MYACCOUNT_signin = MYACCOUNT_SIGNIN::viewWdgt($default_email);   
$page = ITS_TMPLT::page($targetHTML, $wdgt_myaccount_signin, $wdgtPlcHldr);
echo $page;

/****************************************************************************************************************/ 
$wdgtPlcHldr = "MAIN";
echo MYACCOUNT_SIGNIN::view($targetHTML, $wdgtPlcHldr, $default_email);

/***************************************************************************************************************/
$tmplt = ITS_TMPLT::setTmplt("myaccount/signin", ITS_SITE::getStandardPageParameters());
echo MYACCOUNT_SIGNIN::view($tmplt, "MAIN", $default_email);

ITS_TMPLT::getTmplt("myaccount/signin/myaccount_signin");

/************************** SIMPLE VERSION **********************************************************************/
include "../_config/config.php";
include ITS_ACCOUNT_MANAGER_INCLUDES::$MYACCOUNT_SIGNIN;
echo MYACCOUNT_SIGNIN::view($default_email);
/*
*  Component knows the following:
*   - Template directory
*   - Filename of the webpg template
*   - Filename of the wdgt template
*  
*  Therefore the component can do the following:
*   1) Readin the page template for the ITS_ACCOUNT
*   2) Readin the wdgt template for the ITS_ACCOUNT functionality
*   3) Set the wdgt placeholders
*   4) Merge the wdgt with page tmplt
*   5) return webpage
* 
* 
*/


?>