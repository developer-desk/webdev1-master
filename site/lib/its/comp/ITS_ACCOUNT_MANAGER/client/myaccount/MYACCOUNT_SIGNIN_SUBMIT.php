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
 
 
    class MYACCOUNT_SIGNIN_SUBMIT
    {      
        public static function process()
        {
            $newClient = REQUEST::readIn("NEWCLIENT");       
            if ($newClient=="yes")
            {
                $rows = REQUEST::readIn(array('CLIENT_EMAIL_ADDRESS'), 1);
                $email = $rows[1]['CLIENT_EMAIL_ADDRESS'];
                ShopSession::redirect_MyAccntCreateAccnt("CLIENT_EMAIL_ADDRESS=".$email);
            }
            else
            {
                if (ShopSession::clientAuthenticate())
                {
                    ShopSession::redirect_MyAccnt();
                }
                else
                {
                    ShopSession::redirect_MyAccntSignIn_loginFailed();
                }
            }
        }      
          
        public static function submit()
        {
            return MYACCOUNT_SIGNIN_SUBMIT::process();
        }       
    }
?>