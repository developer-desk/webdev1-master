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
 
 
//include_once("../../../../../_config/config.php");
include_once("../config.php");
ShopSession::forceSSL();

class PwdRecovery
{
    public static function display()
    {
        $root_web = ROOT_DIR_WEB;
        $errMsg = ShopSession::errMsg();           

        $frm =
"
<h1>".TEXT::get("PWD_ASSIST")."</h1>
<h2 class=\"header\">".TEXT::get("PWD_ASSIST_SUBHDR_ENTER_ACCOUNT_EMAIL")."</h2>
$errMsg
<div id=\"formDiv\">
<form id=\"frmPWDASSIST_lid1\" class=\"frm\" name=\"\" action=\"".LNK::get("PWDASSIST_SUBMIT_RESET_REQUEST")."\" method=\"POST\">
<table id='form'>
<tr>
    <td  class=\"left\"><label id=\"\" for=\"CLIENT_EMAIL_ADDRESS\" class=\"frmLbl\" style=\"font-weight:bold;text-align:right;\" name=\"\" >".TEXT::get("EMAIL_ADDRESS").":</label></td>
    <td><input id=\"CLIENT_EMAIL_ADDRESS_r1_lid1\" class=\"frmTxt\" name=\"CLIENT_EMAIL_ADDRESS_r1_lid1[]\" value=\"$EMAIL_ADDRESS\" type=text></td>
</tr>
<tr>
    <td  class=\"left\"><label id=\"\" for=\"CLIENT_EMAIL_ADDRESS_REENTRY\" class=\"frmLbl\" style=\"font-weight:bold;text-align:right;\" name=\"\" >".TEXT::get("PWD_ASSIST_EMAIL_ADDRESS_PLEASE_CONFIRM").":</label></td>
    <td><input id=\"CLIENT_EMAIL_ADDRESS_REENTRY_r1_lid1\" class=\"frmTxt\" name=\"CLIENT_EMAIL_ADDRESS_REENTRY_r1_lid1[]\" value=\"\" type=text></td>
</tr>
<tr>
    <td></td>
    <td><a class=\"sBtnContinue\" href=\"javascript:procFrm('frmPWDASSIST_lid1');\">".TEXT::get("CONTINUE")."</a></td>
</tr>
</table>
<input type=\"hidden\" id=\"\"  name=\"lid\" value=\"_lid1\">
<input type=\"hidden\" id=\"ROWS_lid1\"  name=\"ROWS_lid1\" value=\"1\">
</form>
</div>
";            
            
        return $frm;        
    }
}

$frm = PwdRecovery::display();
$style = ""; 
echo HTML_STORE::createWebPg($frm, $style, 1);



?>