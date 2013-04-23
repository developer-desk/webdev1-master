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
 
 
class ERR
{
    public $errCode;
    public $msg;
    public $severity;
    public $fieldName;
    
    public function __construct($msg, $fieldName, $errCode, $severity)
    {
        $this->msg = $msg;
        $this->fieldName = $fieldName;
        $this->errCode = $errCode;
        $this->severity = $severity;
    }
}


class ERRCODE
{
    public static $dbInputInvalid = -1;
    public static $frmEmailInvalid = -2;
}

?>