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
 
 
//include_once("ShopSession.php5");//contains link to config
include_once(CONFIG_ADMINITS::$DIR_SMTP."smtp_client.php5");

class EMAIL_TYPE
{
    public static $ORDER_CONFIRMATION = "ORDER_CONFIRMATION";
    public static $ACCOUNT_CREATED = "ACCOUNT_CREATED";
    public static $PASSWORD_ASSISTANCE = "PASSWORD_ASSISTANCE";
    public static $PASSWORD_RESET_REQUESTED = "PASSWORD_RESET_REQUESTED";
    public static $PASSWORD_RESET_COMPLETE = "PASSWORD_RESET_COMPLETE";
}

class EMAILER
{
    public static function hasEmailBeenSent($clientId, $emailType, $ordernumber=null)
    {
        $dbdal = new dbdalSHOP_CART(1);//lg
        if ($emailType==EMAIL_TYPE::$ORDER_CONFIRMATION)
        {
            $sql = "SELECT ORDER_NUMBER FROM SHOP_EMAIL_SENT WHERE CLIENT_ID = $clientId AND EMAIL_TYPE_UID = '$emailType'' and ORDER_NUMBER = '$ordernumber'";
            //echo($sql);
            $rs = $dbdal->executeSelect($sql);
            if (isset($rs) && count($rs)>0)
                return true;
        }
        return false;
    }
    
    private static function _utilLogEmailSent($clientId, $emailAddress, $emailType, $ordernumber=null)
    {
        $dbdal = new dbdalCLIENT(1);//lg
        $date = date("Y/m/d H:i:s");
        $emailAddress = mysql_real_escape_string($emailAddress);
        $sql = "INSERT SHOP_EMAIL_SENT (CLIENT_ID, EMAIL_ADDRESS, EMAIL_TYPE_UID, ORDER_NUMBER, SHOP_EMAL_SENT_STATUS_ID, CB, DC) VALUES ($clientId, '$emailAddress', '$emailType', '$ordernumber', 1, 1, '$date')";
        ////echo($sql);
        $dbdal->executeSqlStmt($sql);
        ////exit();               
    }

    public static function sendPwdResetComplete($emailAddress)  //errTrap - null values
    {        
        $emailTo = $emailAddress;
        $nameTo = $recipientName;
        $emailFrom = CONFIG::$EMAIL_PWDASSIST_FROM_ADDRESS;
        $nameFrom = CONFIG::$EMAIL_PWDASSIST_FROM_NAME;
        $emailReplyTo = CONFIG::$EMAIL_PWDASSIST_REPLYTO_ADDRESS;
        $nameReplyTo = CONFIG::$EMAIL_PWDASSIST_REPLYTO_NAME;
        $emailSubject = CONFIG::$EMAIL_PWDRESET_COMPLETE_SUBJECTLINE;
        $emailContent = HTML_EMAIL::getPwdResetComplete();
        $SysMsg = "";
        $isHtmlContent=true;
        EMAILER::_utilLogEmailSent($clientId, $emailAddress, EMAIL_TYPE::$PASSWORD_RESET_COMPLETE);
        //DBUG::OUT($emailContent);
        $success = SMTP_CLIENT::sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $SysMsg, $isHtmlContent);//errTrap
        return $success;
    }     
    
    public static function sendPwdResetRequested($clientId, $emailAddress, $recipientName, $lnkHref)  //errTrap - null values
    {        
        $emailTo = $emailAddress;
        $nameTo = $recipientName;
        $emailFrom = CONFIG::$EMAIL_PWDASSIST_FROM_ADDRESS;
        $nameFrom = CONFIG::$EMAIL_PWDASSIST_FROM_NAME;
        $emailReplyTo = CONFIG::$EMAIL_PWDASSIST_REPLYTO_ADDRESS;
        $nameReplyTo = CONFIG::$EMAIL_PWDASSIST_REPLYTO_NAME;
        $emailSubject = CONFIG::$EMAIL_PWDASSIST_SUBJECTLINE;
        $emailContent = HTML_EMAIL::getPwdResetRequested($lnkHref);
        $SysMsg = "";
        $isHtmlContent=true;
        EMAILER::_utilLogEmailSent($clientId, $emailAddress, EMAIL_TYPE::$PASSWORD_RESET_REQUESTED);
        //DBUG::OUT($emailContent);
        $success = SMTP_CLIENT::sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $SysMsg, $isHtmlContent);//errTrap
        return $success;
    }    
    
    public static function sendOrderConfirmation($clientId=null, $emailAddress, $recipientName, $orderNumber, $orderHtml)  //errTrap - null values
    {
        $emailTo = $emailAddress;
        $nameTo = $recipientName;
        $emailFrom = CONFIG::$EMAIL_ORDERCONF_FROM_ADDRESS;// "order-confirmation@infinite-ts.com"; //lg
        $nameFrom = CONFIG::$EMAIL_ORDERCONF_FROM_NAME;// "Infinite-ts.com Team";//lg  
        $emailReplyTo = CONFIG::$EMAIL_ORDERCONF_REPLYTO_ADDRESS;//"customerservice@infinite-ts.com";//lg  
        $nameReplyTo = CONFIG::$EMAIL_ORDERCONF_REPLYTO_NAME;//"Infinite-ts.com Customer Service";//lg 
        $emailSubject = CONFIG::$EMAIL_ORDERCONF_SUBJECTLINE;//"Your Order Confirmation from Infinite-ts.com order#:$orderNumber"; //lg
        $emailSubject = str_ireplace("%ORDERNUMBER%", $orderNumber, $emailSubject);
        $emailContent = HTML_EMAIL::getOrderConfirmation($orderHtml);
        $SysMsg = "";
        $isHtmlContent=true;
        EMAILER::_utilLogEmailSent($clientId, $emailAddress, EMAIL_TYPE::$ORDER_CONFIRMATION, $orderNumber);
        //test env: return true;
        $success = SMTP_CLIENT::sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $SysMsg, $isHtmlContent);//errTrap
                        
        $emailTo = CONFIG::$EMAIL_ADMIN_TO_ADDRESS;
        $nameTo = CONFIG::$EMAIL_ADMIN_TO_NAME;
        $emailFrom = CONFIG::$EMAIL_ADMIN_FROM_ADDRESS;// CONFIG::$EMAIL_ORDERCONF_FROM_ADDRESS;// "customerservice@infinite-ts.com"; //lg
        $nameFrom = CONFIG::$EMAIL_ADMIN_FROM_NAME;// CONFIG::$EMAIL_ORDERCONF_FROM_NAME;// "Infinite-ts.com Team";//lg  
        $emailReplyTo = CONFIG::$EMAIL_ADMIN_REPLYTO_ADDRESS;// CONFIG::$EMAIL_ORDERCONF_REPLYTO_ADDRESS;//"customerservice@infinite-ts.com";//lg  
        $nameReplyTo = CONFIG::$EMAIL_ADMIN_REPLYTO_NAME;// CONFIG::$EMAIL_ORDERCONF_REPLYTO_NAME;//"Infinite-ts.com Customer Service";//lg 
        $emailSubject = CONFIG::$EMAIL_ADMIN_ORDERCONF_SUBJECTLINE;// CONFIG::$EMAIL_ORDERCONF_SUBJECTLINE;//"Your Order Confirmation from Infinite-ts.com order#:$orderNumber"; //lg
        $emailSubject = str_ireplace("%ORDERNUMBER%", $orderNumber, $emailSubject);
        $emailContent = HTML_EMAIL_ADMIN::getOrderConfirmation($orderHtml);
        //DBUG::SET_DBUG_ON();
        //DBUG::OUT("Here!!!");
        $success = SMTP_CLIENT::sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $SysMsg, $isHtmlContent);//errTrap
        return $success;
    }                         
    
    public static function sysAdminOrderSubmittalError($emailAddress="", $recipientName="", $orderNumber="", $orderHtml="", $msg="")
    {   
        $emailAddress = isset($emailAddress) ? $emailAddress : "";
        $recipientName = isset($recipientName) ? $recipientName : "";
        $orderNumber = isset($orderNumber) ? $orderNumber : "";
        $orderHtml = isset($orderHtml) ? $orderHtml : "";
        $msg = isset($msg) ? $msg : "";
         
        $emailTo = CONFIG::$EMAIL_SYSADMIN_TO_ADDRESS;
        $nameTo = CONFIG::$EMAIL_SYSADMIN_TO_NAME;
        $emailFrom = CONFIG::$EMAIL_ADMIN_FROM_ADDRESS;// CONFIG::$EMAIL_ORDERCONF_FROM_ADDRESS;// "customerservice@infinite-ts.com"; //lg
        $nameFrom = CONFIG::$EMAIL_ADMIN_FROM_NAME;// CONFIG::$EMAIL_ORDERCONF_FROM_NAME;// "Infinite-ts.com Team";//lg  
        $emailReplyTo = CONFIG::$EMAIL_ADMIN_REPLYTO_ADDRESS;// CONFIG::$EMAIL_ORDERCONF_REPLYTO_ADDRESS;//"customerservice@infinite-ts.com";//lg  
        $nameReplyTo = CONFIG::$EMAIL_ADMIN_REPLYTO_NAME;// CONFIG::$EMAIL_ORDERCONF_REPLYTO_NAME;//"Infinite-ts.com Customer Service";//lg 
        $emailSubject = CONFIG::$EMAIL_SYSADMIN_ORDER_ERR_SUBJECTLINE;// CONFIG::$EMAIL_ORDERCONF_SUBJECTLINE;//"Your Order Confirmation from Infinite-ts.com order#:$orderNumber"; //lg
        $emailSubject = str_ireplace("%ORDERNUMBER%", $orderNumber, $emailSubject);
        $SysMsg = "";
        $isHtmlContent=true;

        $emailContent = HTML_EMAIL_ADMIN::getOrderConfirmation($orderHtml);
        //DBUG::SET_DBUG_ON();
        //DBUG::OUT("Here!!!");
        $success = SMTP_CLIENT::sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $SysMsg, $isHtmlContent);//errTrap
        
    }    
    
    private static function createOrderConfirmation($htmOrder)
    {
        return HTML_EMAIL::getOrderConfirmation($htmOrder);   
    }

/** CONFIG TO SETUP WHEN FRENCH IS IMPLEMENTED
$this->txt['@EMAIL_ORDERCONF_ADDRESS_FROM'] = "customerservice@infinite-ts.com";
$this->txt['@EMAIL_ORDERCONF_NAME_FROM'] = "Infinite-ts.com Team";
$this->txt['@EMAIL_ORDERCONF_ADDRESS_REPLYTO'] = "customerservice@infinite-ts.com";
$this->txt['@EMAIL_ORDERCONF_NAME_REPLYTO'] = "Infinite-ts.com Customer Service";
$this->txt['@EMAIL_ORDERCONF_SUBJECT'] = "Your Order Confirmation from Infinite-ts.com order#:%ORDERNUMBER%";
**/               
  
    
}

class HTML_EMAIL
{

    public static function getOrderConfirmation($htmOrder)
    {
        return HTML_EMAIL::createHtml(stripcslashes($htmOrder));   
    }

    public static function getPwdResetComplete($hrefLnk)
    {
        $txt = TEXT_EMAIL::get('PWDASSIST_RESET_COMPLETE');
        $intro = HTML_EMAIL::createHTML_intro($txt);
        $email = HTML_EMAIL::createHTML2($intro,"");//no main body needed
        return $email;   
    }    

    public static function getPwdResetRequested($hrefLnk)
    {
        $txt = TEXT_EMAIL::get('PWDASSIST_RESET_REQUESTED');
        $txt = str_ireplace("%LNK_HREF%", $hrefLnk, $txt);
        $intro = HTML_EMAIL::createHTML_intro($txt);
        $email = HTML_EMAIL::createHTML2($intro,"");//no main body needed
        return $email;   
    }    
    
    private static function createHtml2($intro, $mainBody)
    {
        $html = 
"
<html>
<head>
<style>
body
{
    font-family:arial;
    color:black;
}

.boxContainer{ 
    display:block;
    float:left;
    clear:both;
    margin-bottom:10px;        
    color:black;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) top right no-repeat;     
}
.boxDesc
{
    margin:0;
    padding:9px 9px 0 9px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) top left no-repeat;    
}

div.boxContainer #boxFix
{
    display:inline;
    height:1px;
}

.boxLink
{
    margin:0;
    padding:0 0 0 19px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) bottom left no-repeat;    
}

.boxLink div
{
    display:block;
    padding:0 9px 9px 0;
    margin:0 0 2px 0;
    font-style: normal;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) bottom right no-repeat;    
} 
.boxContainer a
{
    font-size:100%;
    color:blue;
}

p
{
    width:800px;
}
</style>

</head>
<body>
%INTRO%
%MAINBODY%
</body>
</html>
";    
        $html =  str_ireplace("%INTRO%", $intro, $html);    
        return str_ireplace("%MAINBODY%", $mainBody, $html);    
    }    
    
    private static function createHtml($content)
    {
        //new
        //$content = str_ireplace('&#92;r&#92;n', "", $content);
        $html = 
"
<html>
<head>
<style>
.boxContainer{ 
    display:block;
    float:left;
    clear:both;
    margin-bottom:10px;        
    color:black;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) top right no-repeat;     
}
.boxDesc
{
    margin:0;
    padding:9px 9px 0 9px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) top left no-repeat;    
}
.boxLink
{
    margin:0;
    padding:0 0 0 19px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) bottom left no-repeat;    
}

.boxLink div
{
    display:block;
    padding:0 9px 9px 0;
    margin:0 0 2px 0;
    font-style: normal;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) bottom right no-repeat;    
} 
.boxContainer a
{
    font-size:230%;
    color:#e70;
}

p
{
    width:800px;
}
</style>

</head>
<body>
<img src=\"http://www.takethetime.ca/images/skn1/logoTakeTheTime.gif\">
<div class=\"boxContainer\">
<div class=\"boxDesc\">
 ".TEXT_EMAIL::get("INTRO_ORDERCONF")."
</div>
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>  

<div class=\"boxContainer\">
<div class=\"boxDesc\">

<div style=\"width:800px;\"  id=\"orderSummary\">

%CONTENT%
</div>


</div>
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>



</body>
</html>
";    
        return str_ireplace("%CONTENT%", $content, $html);    
    }    


    public static function createHTML_intro($text)
    {
        $html = 
"
<img src=\"http://www.takethetime.ca/images/skn1/logoTakeTheTime.gif\">
<div class=\"boxContainer\">
<div class=\"boxDesc\">
%TEXT%
</div>
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>  
";
        return str_ireplace("%TEXT%", $text, $html);    
    }

    public static function createHTML_mainBody($content)
    {

        $html = 
"
<div class=\"boxContainer\">
<div class=\"boxDesc\">

<div>
%CONTENT%
</div>


</div>
<b id=\"boxFix\">
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>    
";    
        return str_ireplace("%CONTENT%", $content, $html);    
    }

}


class HTML_EMAIL_ADMIN
{

    public static function getOrderConfirmation($htmOrder)
    {
        return HTML_EMAIL_ADMIN::createHtml(stripcslashes($htmOrder));   
    }
    
    private static function createHtml($content)
    {
        $html = 
"
<html>
<head>
<style>
.boxContainer{ 
    display:block;
    float:left;     
    clear:both;
    margin-bottom:10px;    
    color:black;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) top right no-repeat;     
}
.boxDesc
{
    margin:0;
    padding:9px 9px 0 9px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) top left no-repeat;    
}
.boxLink
{
    margin:0;
    padding:0 0 0 19px;
    background: url(http://www.takethetime.ca/images/skn1/boxLeft.gif) bottom left no-repeat;    
}

.boxLink div
{
    display:block;
    padding:0 9px 9px 0;
    margin:0 0 2px 0;
    font-style: normal;
    background: url(http://www.takethetime.ca/images/skn1/boxRight.gif) bottom right no-repeat;    
} 
.boxContainer a
{
    font-size:230%;
    color:#e70;
}

p
{
    width:800px;
}
</style>

</head>
<body>
<img src=\"http://www.takethetime.ca/images/skn1/logoTakeTheTime.gif\">
<div class=\"boxContainer\">
<div class=\"boxDesc\">
 ".TEXT_EMAIL::get("SYSADMIN_ORDERSUBMITTED")."
</div>
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>  

<div class=\"boxContainer\">
<div class=\"boxDesc\">

<div style=\"width:800px;\"  id=\"orderSummary\">

%CONTENT%
</div>


</div>
<div class=\"boxLink\">&nbsp;<div>&nbsp;</div>
</div>
</div>



</body>
</html>
";    
        return str_ireplace("%CONTENT%", $content, $html);    
    }    
}




class TEXT_EMAIL
{
    private $txt;
    private static $instance;

    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new TEXT_EMAIL();       
        } 
        return self::$instance;
    }    
    
    private function __construct()
    {
        $this->txt = array();
        if (ShopSession::LG()==1)
        {               
                                           
$this->txt['INTRO_ORDERCONF'] = 
"<p style=\"margin:0;padding:0;width:800px;\"><span style=\"font-weight:bolder;\">Infinite-ts.com</span> Order Confirmation<br><br>Thank you for placing your order with Infinite-ts.com.</p>
<br>
<p>
Your order will be shipped  promptly. If you need to check the status of your order or make changes, please visit our home page at Infinite-ts.com and click on Your Account at the top of our home page.
This e-mail will be followed up another informing you that your products have been shipped.<br>
Thank you for your patronage.</p>                                                                                     
";


$this->txt['SYSADMIN_ORDERSUBMITTED'] = "An order has been placed on ".COMPANY." !";
$this->txt['SYSADMIN_ORDERSUBMITTED'] = str_ireplace('/', "", str_ireplace('http://', "","An order has been placed on ".COMPANY." !"));

$this->txt['PWDASSIST_RESET_REQUESTED'] = "<p style=\"margin:0;padding:0;width:800px;\"><span style=\"font-weight:bolder;\">".COMPANY."</span> Password Assistance</p>
<br>
<p>We received a request to reset the password associated with this email address. If you made this request please follow the instructions below to reset your password. If you did not make this 
request you can safely ignore this email. Rest assured that your account is secure.</p>
<br>
<p>Click the link below to reset your password using our secure server:</p>
<a href='%LNK_HREF%'>%LNK_HREF%</a>
<br>
<br>
<p>
If clicking doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there. 
Once you have returned to ".COMPANY.", we will give instructions for resetting your password.<br>
 ".COMPANY." will never on any occasion e-mail you and ask you to disclose or verify your password, credit card, or banking account number. 
If you receive a suspicious e-mail with a link to update your account information, do not click on the link, and promptly report the e-mail to ".COMPANY." for investigation.
</p>";

$this->txt['PWDASSIST_RESET_COMPLETE'] = "<p style=\"margin:0;padding:0;width:800px;\"><span style=\"font-weight:bolder;\">".COMPANY."</span> Password Reset Confirmation
<br><br> As you requested, your password has successfully been changed.<br><br>
Thank you for shopping at ".COMPANY."!
";


        }
        else
        {
$this->txt['INTRO_ORDERCONF'] = 
"<p style=\"margin:0;padding:0;width:800px;\"><span style=\"font-weight:bolder;\">Infinite-ts.com</span> Order Confirmation<br>Thank you for placing your order with Infinite-ts.com.
Your order will be shipped  promptly. If you need to check the status of your order or make changes, please visitour home page at Infinite-ts.com and click on Your Account at the top of our home page.
This e-mail will be followed up another informing you that your products have been shipped.<br>
Thank you from your patronage.</p>
";            

$this->txt['SYSADMIN_ORDERSUBMITTED'] = str_ireplace('/', "", str_ireplace('http://', "","An order has been placed on ".HOMELNK2." !"));
        }
    }
    
    public function get($txtId)
    {
        $self = self::getInstance();        
        $txtId = strtoupper($txtId);
        return $self->txt[$txtId];       
    }    
    
}

/*
$email = "afamdient@yahoo.ca";
$recipientName = "Paul Okeke";
$orderNumber = "TTT1902982";
$date = date();
$orderHTML = "<h1>Your Order has been submitted</h1><h2>This is a test: $date</h2>";

EMAILER::sendOrderConfirmation($email, $recipientName, $orderNumber, $orderHTML);

echo "Complete!!!";
 */
 ?>