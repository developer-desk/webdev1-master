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
 
 
abstract class Frm_Validator
{
    protected $reqVals;
    protected $errMsgsArr = null;  

    public abstract function validate();

    public function getErrs() //should be in abstract class
    {
        return $this->errMsgsArr;
    }
            
    public function getReqVars() //should be in abstract class
    {
        return $this->reqVals;
    }

    protected function addErrMsg($msg, $fieldName, $errCode, $severity) //should be in abstract class
    {
        ////$this->errMsgsArr[$fieldName] = array("errCode"=>$errCode, "msg"=>$msg, "fieldName"=>$fieldName);
        $this->errMsgsArr[$fieldName] = new ERR($msg, $fieldName, $errCode, $severity);
        
        //if required then "Required field $fieldName" + msg
        //msg either "field is not of expected data type integer" or "is not of expected data type integer"
        //or msg = "field cannot be blank" or "field cannot be null"
    }

    protected function addErrMsgArr($errMsgArr) //should be in abstract class
    {
        $this->errMsgsArr = array_merge($this->errMsgsArr, $errMsgArr);
    }
}  
?>