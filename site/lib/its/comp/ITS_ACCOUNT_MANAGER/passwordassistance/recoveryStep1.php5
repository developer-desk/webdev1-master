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
 
 
include_once("../config.php");
ShopSession::forceSSL();

class PwdRecoveryEmailSent
{
    public static function display()
    {
        $root_web = ROOT_DIR_WEB;
        $errMsg = ShopSession::errMsg();
        $email = $_GET['email'];       
        $txt =  str_ireplace("%EMAILADDRESS%", $email, TEXT::get("PWD_ASSIST_SUBHDR_RESET_EMAIL_SENT"));
        $html =
"
<h1>".TEXT::get("PWD_ASSIST_RESET_EMAIL_SENT")."</h1>
<h3 class=\"header\">".$txt.".</h3>
";            
        return $html;        
    }
}

$html = PwdRecoveryEmailSent::display();
$style = ""; 
echo HTML_STORE::createWebPg($html, $style, 1);



?>