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
 
 

class CLIENT_TXT_FrmParameters
{
    //declarations
    //protected $parameters = array();
    
    public static function getParameterList()
    {
		$parameters[] = "CLIENT_TXT_CLIENT_ID";
		$parameters[] = "CLIENT_TXT_LG_ID";
		$parameters[] = "CLIENT_TXT_NAME";
		$parameters[] = "CLIENT_TXT_DESCR";
		$parameters[] = "CLIENT_TXT_CB";
		$parameters[] = "CLIENT_TXT_DC";
		$parameters[] = "CLIENT_TXT_MB";
		$parameters[] = "CLIENT_TXT_DM";
		$parameters[] = "CLIENT_TXT_TS";

        return $parameters;
    }
    
}      

?>