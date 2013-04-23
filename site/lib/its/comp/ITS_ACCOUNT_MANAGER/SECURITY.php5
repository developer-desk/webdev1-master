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
 
 
class SECURITY
{
    public static function forceSSL()
    {
        $SERVER_NAME = $_SERVER['SERVER_NAME'];
        $URL = isset($_SERVER['URL']) ? $_SERVER['URL'] : "";
        //if ($_SERVER[HTTPS]!="on") 
        if (!SECURITY::usingSSL()) 
        {
            header("Location: https://$SERVER_NAME$URL");//prod
            return true;
        }             
    }
	
    public static function usingSSL()
    {
        return true;
        //return ($_SERVER[HTTPS]=="on");
    }
    
    public static function getUserIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    public static function getUserBrowser()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
    public static function regActivity()
    {
        $_SESSION['EXPIRES'] = time()+600;
    }
    public static function setSessionSecurtiyVariables()
    {
        $_SESSION['EXPIRES'] = time()+600;
        $_SESSION['SECURE_USERIP'] = SECURITY::getUserIP();
        $_SESSION['SECURE_USERBRSWR'] = SECURITY::getUserBrowser();
    }
    public static function transactionAuthenticate(&$msg, &$tranErr)
    {
        if ($_SERVER['REMOTE_ADDR'] == $_SESSION['SECURE_USERIP'] && $_SERVER['HTTP_USER_AGENT'] == $_SESSION['SECURE_USERBRSWR'])
        {
            if ($_SESSION['EXPIRES'] < time())
            {
                ShopSession::tranResetPaymentFlags();
                $tranErr = TRAN_ERROR::$SECURITY_SESSION_EXPIRED;
                $msg = TEXT::get("TRAN_SESSION_EXPIRED_REENTER_INFO");
                ShopSession::redirect_ChkoutPaymentInfo("errMsg=$msg");
                return false;    
            }
            return true;
        }    
        else
        {
            if($_SERVER['REMOTE_ADDR'] != $_SESSION['SECURE_USERIP'])
                $tranErr = TRAN_ERROR::$SECURITY_SESSION_IP_MISMATCH;
            else
                $tranErr = TRAN_ERROR::$SECURITY_SESSION_BRWSR_MISMATCH;
            ShopSession::killSession();
            $msg = "sec check failed server_remote_addr:".$_SERVER['REMOTE_ADDR']." , session_secure_userip: ".$_SESSION['SECURE_USERIP']." server_http_user_agent:".$_SERVER['HTTP_USER_AGENT']." session_secure_userbrwsr:".$_SESSION['SECURE_USERBRSWR']." session_expires:".$_SESSION['EXPIRES']." time:".time();
            return false;
        }
    }

    public static function validatePasswordResetToken($token, &$emailAddress=null)
    {
        if (!isset($token) || $token =="" || strlen($token) != 32)
        {
            DBUG::OUT('Invalid token!');
            $msg = "errMsg=".TEXT::get("PWDASSIST_INVALID_TOKEN");
            ShopSession::redirect_PwdAssist($msg);
            return false;//should never hit this                
        }        
        else
        {
            $dbdal = new dbdalCLIENT(1);//lg
            $sql = "SELECT * FROM SHOP_SECURITY_PWD_RESET WHERE TOKEN='$token'";
            $rs = $dbdal->executeSelect($sql);
            if (!isset($rs) || count($rs) == 0)
            {
                DBUG::OUT("Token Mismatch");
                $msg = "errMsg=".TEXT::get("PWDASSIST_INVALID_TOKEN");
                ShopSession::redirect_PwdAssist($msg);
                return false;//should never hit this                
            }
            else
            {
                $tokenCreateDate = $rs[0]['DC'];
                $emailAddress = $rs[0]['EMAIL_ADDRESS']; 
                $todaysDate = date("Y/m/d H:i:s");
                $plusHour = strtotime("+1 hour",$todaysDate);
                $timeToken = strtotime($tokenCreateDate);
                $timeNow = strtotime($todaysDate);
                $timeDiff = ($timeNow-$timeToken)/60;
                DBUG::OUT("Time Diff: $timeDiff, now:$timeNow , token: $timeToken, plusHour:$plusHour");                                
                if ($timeDiff>30)
                {
                    DBUG::OUT("Token Expired");
                    $msg = "errMsg=".TEXT::get("PWDASSIST_EXPIRED_TOKEN");
                    ShopSession::redirect_PwdAssist($msg);                
                    return false;//should never hit this                
                }
                else
                    return true;
            }
            
        }
    }    

}


class PasswordValidator
{
    public static function validate($val)
    {
        if (trim($val)=="")
            return false;
        elseif (strlen($val)<6)
            return false;
        elseif (strlen($val)>16)
            return false;
        else
            return true;
    }
}


class TRAN_ERROR
{
    public static $nofundsCreditCard = 100;
    public static $nofundsGiftCard = 200;
    public static $PROMOCODE_NOTAPPLIED = 300;
    public static $GIFT_CARD_INSUFFICIENT_FUNDS = 201;
    public static $GIFT_CARD_UNABLE_TO_DEBIT = 220;

    public static $SECURITY_CHECK_FAILED = 8800;
    public static $SECURITY_SESSION_EXPIRED = 8801;
    public static $SECURITY_SESSION_IP_MISMATCH = 8802;
    public static $SECURITY_SESSION_BRWSR_MISMATCH = 8803;    

    public static $SYSERROR_UNABLE_TO_CREATE_INVOICE_NUMBER = 9900;
    public static $SYSERROR_MISSING_PAYMEMNT_INFO = 9910;
    
    public static $DECLINED = -500;
    public static $DECLINED_CVD = -501;
    public static $SYSERROR_API = -502;
      

}