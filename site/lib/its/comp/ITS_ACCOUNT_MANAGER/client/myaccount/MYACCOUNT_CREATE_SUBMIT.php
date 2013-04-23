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
 
 
    include("../../config.php");   
                                
    include_once(CONFIG_ADMINITS::$DIR_BL."_sec/SEC.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL."GBL.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL."UTIL.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL."VALIDATOR.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."DBDALObj.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."DBDAL.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_DBDAL."DBStmtMySQL.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_BL."FrmObj.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_BL."Frm_Validator.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_HTTP."REQUEST4.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_FILE."FileIO.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL."ERR.php5");
    include_once(CONFIG_ADMINITS::$DIR_CACHE."CACHE_ITS.php5");
    include_once(CONFIG_ADMINITS::$DIR_UTIL_GUI."TMPLT_ITS.php5");    
    include_once CONFIG_ADMINITS::$CODEGEN_DIR_BL_FRM."CLIENT_SubmitCreate.php5";
    include_once CONFIG_ADMINITS::$CODEGEN_DIR_BL_FRM."CLIENT_FrmParameters.php5";         
    include_once CONFIG_ADMINITS::$CODEGEN_DIR_BL_FRM."CLIENT_FrmValidatorCreate.php5";
    include_once CONFIG_ADMINITS::$DIR_DBDAL."dbdalCLIENT.php5";         
         
    class MYACCOUNT_CREATE_SUBMIT
    {      
        public static function process()
        {
            $arr=array();
            $arr[]='CLIENT_FULL_NAME';
            $arr[]='CLIENT_EMAIL_ADDRESS';
            $arr[]='CLIENT_EMAIL_ADDRESS_REENTRY';
            $arr[]='CLIENT_PASSWORD';
            $arr[]='CLIENT_PASSWORD_REENTRY';
            
            $rows = REQUEST::readIn($arr, 1);
            $name = $rows[1]['CLIENT_FULL_NAME'];
            $email = $rows[1]['CLIENT_EMAIL_ADDRESS'];
            $email_reentry = $rows[1]['CLIENT_EMAIL_ADDRESS_REENTRY'];
            $password = $rows[1]['CLIENT_PASSWORD'];
            $password_reentry = $rows[1]['CLIENT_PASSWORD_REENTRY'];
            
            DBUG::OUT("email:$email");                
            DBUG::OUT("email_reentry:$email_reentry");                
            DBUG::OUT("password:$password");                
            DBUG::OUT("password_reentry:$password_reentry");                
            DBUG::OUT("name:$name"); 
            
            $_SESSION['TMP_CLIENT_FULL_NAME'] = $name;
            $_SESSION['TMP_CLIENT_EMAIL_ADDRESS'] = $email;
            $_SESSION['TMP_CLIENT_EMAIL_ADDRESS_REENTRY'] = $email_reentry; 
            
            if (!Validate::clientAccountCreate_fullName($name, $msg))
            {
                $msg = "errMsg=$msg";
                ShopSession::redirect_ClientAccountCreate($msg);                
            }
            elseif(!Validate::clientAcccountCreate_emailAddress($email, $email_reentry, $msg))
            {
                $msg = "errMsg=$msg";
                ShopSession::redirect_ClientAccountCreate($msg);                
            }
            elseif(!Validate::clientAcccountCreate_password($password, $password_reentry, $msg))
            {
                $msg = "errMsg=$msg";
                ShopSession::redirect_ClientAccountCreate($msg);                
            }
            else
            {
                $submit = new CLIENT_FrmSubmitCreate();
                $client_id = $submit->process();
                if (isset($client_id))
                {
                    ShopSession::setClientId($client_id);
                    ShopSession::setClientEmail($email);
                    ShopSession::redirect_ClientAccountCreateSuccessful();
                }
                else
                {
                    ShopSession::redirect_ClientAccountCreate("err=1&errMsg=error%20creating%20client");
                }
            }                
        }      
          
        public static function submit()
        {
            return MYACCOUNT_CREATE_SUBMIT::process();
        }       
    }   
?>