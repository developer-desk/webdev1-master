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
 
 

class CLIENT_FrmParameters
{
    //declarations
    //protected $parameters = array();
    
    public static function getParameterList()
    {
		$parameters[] = "CLIENT_CLIENT_ID";
		$parameters[] = "CLIENT_FULL_NAME";
		$parameters[] = "CLIENT_EMAIL_ADDRESS";
		$parameters[] = "CLIENT_PASSWORD";
		$parameters[] = "CLIENT_CONTACT_ID";
		$parameters[] = "CLIENT_CLIENT_TYPE_ID";

        return $parameters;
    }
    
}      

?>