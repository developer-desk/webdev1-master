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
 
 
abstract class VALIDATORObj
{
    protected $errMsgsArr = null;
    protected $errCnt;
    
    public function errOccured($errCode)
    {
        return false;    
    }
    
    public function getFunctionName($dataType)
    {
        switch($dataType)
        {
            case DATATYPE::$char:
            return "isAlpha";
            break;

            case DATATYPE::$varchar:
            return "isAlpha";
            break;

            case DATATYPE::$int:
            return "isInt";
            break;

            case DATATYPE::$real:
            return "isReal";
            break;

            case DATATYPE::$double:
            return "isReal";
            break;

            case DATATYPE::$datetime:
            return "isDate";
            break;      
            
            default:
                return "ERR_FUNCTION_NOT_FOUND";
            
        }
    }
    
    protected abstract function createMsg($msg, $errorType, $required, $fieldName);
       
    public abstract function isInt($value, $required, $fieldName);
    public abstract function isReal($value, $required, $fieldName);
    public abstract function isDate($value, $required, $fieldName);
    public abstract function isEmail($value, $required, $fieldName);
    public abstract function isName($value, $required, $fieldName);
    public abstract function isTelephone($value, $required, $fieldName);
    public abstract function isAlpha($value, $required, $fieldName);
    public abstract function isAlphanumeric($value, $required, $fieldName);
    public abstract function isNotBlank($value, $fieldName);
    public abstract function isNotNull($value, $fieldName);
   
    public abstract function VALID();
    public abstract function getErrMsgs();
}

class VALIDATOR extends VALIDATORObj
{
    protected function createMsg($msg, $fieldName, $errCode, $severity)
    {
        ///$this->errMsgsArr[] = array("errCode"=>$errCode, "msg"=>$msg, "fieldName"=>$fieldName);
        $this->errMsgsArr[$fieldName] = new ERR($msg, $fieldName, $errCode, $severity);       
        //if required then "Required field $fieldName" + msg
        //msg either "field is not of expected data type integer" or "is not of expected data type integer"
        //or msg = "field cannot be blank" or "field cannot be null"
        return null;
    }

    public function getErrMsgs()
    {
        return $this->errMsgsArr;
    }

    public function isInt($value, $required, $fieldName)
    {
        //set error here if invalid
        return true;
    }
    public function isReal($value, $required, $fieldName)
    {
        return true;
    }
    public function isDate($value, $required, $fieldName)
    {
        return true;
    }
    public function isEmail($value, $required, $fieldName)
    {
        return true;
    }
    public function isName($value, $required, $fieldName)
    {
        return true;
    }
    public function isTelephone($value, $required, $fieldName)
    {
        return true;
    }
    public function isAlpha($value, $required, $fieldName)
    {
        return true;
    }
    public function isAlphanumeric($value, $required, $fieldName)
    {
        return true;
    }
    public function isNotBlank($value, $fieldName)
    {
        return true;
    }
    public function isNotNull($value, $fieldName)
    {
        return true;
    }
   
    public function VALID()
    {
        return true;
    }
    public function getResults()
    {
        return null;
    }

}
class VALIDATORFct
{
    public static function getObj($ValidatorType)
    {
        return new VALIDATOR();
    }
}
?>