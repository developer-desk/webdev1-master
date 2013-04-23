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
DBUG::SET_DBUG_OFF();          
class PwdRecoveryStep2
{
    public static function process()
    {
        $token = $_GET['token'];
        DBUG::OUT("<br>token=$token");
        if (SECURITY::validatePasswordResetToken($token))//security function handles redirect
        {
            PwdRecoveryStep2::display($token);
            return true;
            /*
            $dbdal = new dbdalCLIENT(1);//lg
            $sql = "SELECT * FROM SHOP_SECURITY_PWD_RESET WHERE TOKEN='$token'";
            $rs = $dbdal->executeSelect($sql);
            if (!isset($rs) || count($rs) == 0)
            {
                DBUG::OUT("Token Mismatch");
                $msg = "errMsg=".TEXT::get("PWDASSIST_INVALID_TOKEN");
                ShopSession::redirect_PwdAssist($msg);                
            }
            else
            {
                $tokenCreateDate = $rs[0]['DC'];
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
                }
                else
                {
                    //present pwd reset page
                    //token revalidated upon submittal
                }
            */
        
        }
        else
            return false;//errTrap - should never reach here because Security function redirects page on error
    }
    
    
    public static function display($token)
    {
        $root_web = ROOT_DIR_WEB;
        $errMsg = ShopSession::errMsg();       
       

        $frm =
"
<h1>".TEXT::get("PWD_ASSIST_RESET")."</h1>
<h3 class=\"header\">".TEXT::get("PWD_ASSIST_SUBHDR_ENTER_A_NEW_PASSWORD")."</h3>
$errMsg
<div id=\"formDiv\">
<form id=\"frmPWDASSIST_lid1\" class=\"frm\" name=\"\" action=\"".LNK::get("PWDASSIST_SUBMIT_PWDRESET")."\" method=\"POST\">
<table id='form'>
<tr>
    <td class=\"left\">
        <label id=\"\" for=\"CLIENT_PASSWORD\" class=\"frmLbl\" style=\"\" name=\"\" >".TEXT::get("PASSWORD").":</label>
    </td>
    <td style=\"text-align:left\"> 
        <input id=\"CLIENT_PASSWORD_r1_lid1\" class=\"frmTxt\" name=\"CLIENT_PASSWORD_r1_lid1[]\" value=\"\" type=\"password\">
    </td>
</tr>
<tr>
    <td class=\"left\">
        <label id=\"\" for=\"CLIENT_PASSWORD_REENTRY\" class=\"frmLbl\" style=\"\" name=\"\" >".TEXT::get("REENTER_PASSWORD").":</label>
    </td>
    <td style=\"text-align:left\">
        <input id=\"CLIENT_PASSWORD_REENTRY_r1_lid1\" class=\"frmTxt\" name=\"CLIENT_PASSWORD_REENTRY_r1_lid1[]\" value=\"\"  type=\"password\">
    </td>
</tr>
<tr>
    <td></td>
    <td><a class=\"sBtnContinue\" href=\"javascript:procFrm('frmPWDASSIST_lid1');\">".TEXT::get("CONTINUE")."</a></td>
</tr>
</table>
<input type=\"hidden\" id=\"\"  name=\"TOKEN_r1_lid1[]\" value=\"$token\">
<input type=\"hidden\" id=\"\"  name=\"lid\" value=\"_lid1\">
<input type=\"hidden\" id=\"ROWS_lid1\"  name=\"ROWS_lid1\" value=\"1\">
</form>
</div>
";          
        $style = "";    
        echo HTML_STORE::createWebPg($frm, $style, 1);    
        ////return $frm;        
    }
}


PwdRecoveryStep2::process();
//$frm = PwdRecovery::display();
//echo HTML_STORE::createWebPg($frm,1);



?>