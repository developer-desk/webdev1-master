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
 
 
require("smtp.php");

class SMTP_CLIENT
{
    public static function sendEmail($emailTo, $nameTo, $emailFrom, $nameFrom, $emailReplyTo, $nameReplyTo, $emailSubject, $emailContent, $isHtmlContent=true)
    {
        $from = "$nameFrom <$emailFrom>";
        $to = "$nameTo <$emailTo>";    
        $replyTo= "$nameReplyTo <$emailReplyTo>";
        $subject = $emailSubject;
        $contentType = $isHtmlContent ? 'text/html;' : 'text/plain';        
        $date = date("%a, %d %b %Y %H:%M:%S %Z");            
        $content = $emailContent;
        $smtp = SMTP_CLIENT::getSmtpObj();
        
        $headers = array();
        $headers[] = "From: $from";
        $headers[] = "To: $to";
        $headers[] = "Reply-To: $replyTo";
        $headers[] = "Subject: $subject";
        $headers[] = "Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z");
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: $contentType;";
        $headers[] = "Content-Transfer-Encoding: 7bit";
        /*
        if($smtp->SendMessage($from, array($to), $headers, $content))
        {
            return true;        
        }
        else
        {
            $ErrMsg  =  $smtp->error;
            return false;
        }
        */
    }
    
    private static function getSmtpObj()
    {
        $smtp=new smtp_class;

        $smtp->host_name="mail.takethetime.ca";       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
        $smtp->host_port=25;                /* Change this variable to the port of the SMTP server to use, like 465 */
        $smtp->ssl=0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
        $smtp->start_tls=0;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
        $smtp->localhost="67.205.67.57";       /* Your computer address */
        $smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
        $smtp->timeout=20;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
        $smtp->data_timeout=20;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
                                               Set to 0 to use the same defined in the timeout variable */
        $smtp->debug=1;                     /* Set to 1 to output the communication with the SMTP server */
        $smtp->html_debug=1;                /* Set to 1 to format the debug output as HTML */
        $smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
        $smtp->user="";                     /* Set to the user name if the server requires authetication */
        $smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
        $smtp->password="";                 /* Set to the authetication password */
        $smtp->workstation="";              /* Workstation name for NTLM authentication */
        $smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
                                               Leave it empty to make the class negotiate if necessary */

        /*
         * If you need to use the direct delivery mode and this is running under
         * Windows or any other platform that does not have enabled the MX
         * resolution function GetMXRR() , you need to include code that emulates
         * that function so the class knows which SMTP server it should connect
         * to deliver the message directly to the recipient SMTP server.
         */
        if($smtp->direct_delivery)
        {
            if(!function_exists("GetMXRR"))
            {
                /*
                * If possible specify in this array the address of at least on local  DNS that may be queried from your network
                * DNS that may be queried from your network.
                */
                $_NAMESERVERS=array();
                include("getmxrr.php");
            }
            /*
            * If GetMXRR function is available but it is not functional, to use
            * the direct delivery mode, you may use a replacement function.
            */
            /*
            else
            {
                $_NAMESERVERS=array();
                if(count($_NAMESERVERS)==0)
                    Unset($_NAMESERVERS);
                include("rrcompat.php");
                $smtp->getmxrr="_getmxrr";
            }
            */
        }  
        
        return $smtp;      
    }
}
?>