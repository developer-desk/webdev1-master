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
 
 
include_once CONFIG_ADMINITS::$DIR_UTIL."DBUG.php5";  
  class REQUEST
  {
    private static $instance = null;
    private $lid;
    private $lg_id;
    private $rows;
    
    private function __construct()
    {
        $this->lid = REQUEST::LID();
        //$this->lg_id = REQ::readInVarPost("lg_id")."";
        $this->lg_id = 1;
        $this->rows = REQUEST::ROWS();
    }
    
    private static function getInstance()
    {
        
        if (!self::$instance)
        {
            self::$instance = new REQUEST();       
        } 
        return self::$instance;
    }
         
    public static function readIn($var, $rows=null) //sending $rows in indicates that row notation is on/being used
    {
        //DBUG::OUT("rows: $rows", "readIn", "REQUEST4");
        
        $self = self::getInstance();//make sure an instance exists
        $ret_val = array();
        
        if (isset($rows))
        {
            if (!is_array($var)) $var = array($var);
            /*
            for ($row=1;$row<=$rows;$row++)
            {
                $vals = array();
                foreach($var as $rqVal)
                {
                    DBUG::OUT("request var: $rqVal", "readIn", "REQUEST4");
                    $val = REQUEST::readInVarPost($rqVal, $row);
                    DBUG::OUT("val returned: $val[0]", "readIn", "REQUEST4");
                    $vals[$rqVal] = $val[$row];
                }
                $ret_val[$row] = $vals;
            }
            */
            foreach($var as $rqVal)
            {
                DBUG::OUT("request var: $rqVal", "readIn", "REQUEST4");
                for ($row=1;$row<=$rows;$row++)
                {
                    $val = REQUEST::readInVarPost($rqVal, $row);
                    DBUG::OUT("val returned: ". $val[0], "readIn", "REQUEST4");
                    $ret_val[$row][$rqVal] = $val[0];
                }
            }
            return $ret_val;
        }
        else
            return REQUEST::readInVarPost($var);         
        
    }
    public static function readinManyToMany($keyId, $valListId, $txtListId=null)
    {
        $keys = REQUEST::readIn($keyId);
        if (!is_array($keys))
            $keys = array($keys);
        $i=0;
        $arr = array();
        foreach($keys as $key)
        {
            $i++;
            //echo "Key: $keyId= " . $key. "<br>";
            $valList = REQUEST::readIn("$valListId", null, $i);
            if (!is_array($valList))
                $valList = array($valList);
           
            $txtList = isset($txtListId)? REQUEST::readIn("$txtListId", null, $i):null;
           //// echo "txtListId: " . $txtListId. "<br>"; 
            
            if (isset($txtListId) && !is_array($txtListId))
                $txtList = array($txtListId);
                
            $arr[] = array($key, $valList, $txtList);
            foreach ($valList as $val)
                echo "-->$valListId: " . $val."<br>";
            if (is_array($txtList))
            {
                foreach ($txtList as $val)
                    echo "-->$txtListId: " . $val."<br>";            
            }
        }
        return $arr;
    
    }
    
    public static function readInVarPost($var, $row=null)
    {
        $self = self::getInstance();//make sure an instance exists
        $suffix = GBL::LID_ENABLED()? isset($self->lid)?$self->lid:"":"";
        return REQ::readInVarPost($var, $suffix, $row);
    }
    
    public static function readInVarGet($var, $suffix='', $row=null)
    {
        $self = self::getInstance();//make sure an instance exists
        $suffix = GBL::LID_ENABLED()?$self->lid:"";
        return REQ::readInVarGet($var, $suffix, $row);
    }
    
    public static function LID()
    {
        return REQ::readInVarPost("lid")."";
    }
   /* 
    protected static function LID()
    {
        return REQ::readInVarPost("lid")."";
    }
    */
    /*
    public static function LG_ID()
    {
        $self = self::getInstance();//make sure an instance exists
        return $self->lg_id;
    }
    */
    public static function LG()
    {
        return REQ::readInVarPost("lg")."";
    }

    public static function ROWS()
    {
        return REQ::readInVarPost("rows")."";
    }
    
    public static function displayReqVars()
    {
        echo("REQUEST VARS:");
        foreach($_POST as $key=>$val)
        {
            echo("key: $key,  val:$val");
        }

        foreach($_POST as $key=>$val)
        {
            echo("key: $key,  val:$val");
        }
        echo("END REQUEST VARS:");
    }
    //public static
    
    
  }

class REQ
{
    public static function readInVarPost($var, $suffix='', $row=null)
    {
        //$suffix .= isset($row)?"_".$row:"";
        $suffix = isset($row)?"_r".$row.$suffix:$suffix;
        ////echo"<br>var: $var suffix: $suffix</br>";
         if (is_array($var))
         {
             $values = array();
             foreach($var as $varName)
             {
                $varName .= $suffix;
                if (array_key_exists($varName, $_POST))
                    $values[$varName] = $_POST[$varName];
             }
             return $values;
         }            
         else
         {
            ///echo "variable::$var".$suffix;
            $var = $var.$suffix;
            //DBUG::OUT("final var name searched for: $var", "readIn", "REQUEST4");
            $val = self::POST_THEN_GET($var);            
            return $val;
                
         }
    }
    
    private static function POST_THEN_GET($var)
    {
        $val = isset($_POST[$var]) ? $_POST[$var] : null;
        if (!isset($val) || $val == "")            
            $val = isset($_GET[$var]) ? $_GET[$var] : null;
        return $val;   
    }
   /* 
    public static function readInVarPost($var, $suffix='', $row=null)
    {
        //$suffix .= isset($row)?"_".$row:"";
        $suffix = isset($row)?"_r".$row.$suffix:$suffix;
        ////echo"<br>var: $var suffix: $suffix</br>";
         if (is_array($var))
         {
             $values = array();
             foreach($var as $varName)
             {
                $varName .= $suffix;
                if (array_key_exists($varName, $_POST))
                    $values[$varName] = $_POST[$varName];
             }
             return $values;
         }            
         else
         {
            ///echo "variable::$var".$suffix;
            $val = $_POST[$var.$suffix];
            if (!isset($val) || $val == "")            
                $val = $_GET[$var.$suffix];
            return $val;
                
         }
    }
    */    
    
    public static function readInVarGet($var, $suffix='', $row=null)
    {
        $suffix .= isset($row)?"_".$row:"";
         if (is_array($var))
         {
             $values = array();
             foreach($var as $name)
             {
                if (array_key_exists($_GET[$name.$suffix], $_GET))
                    $values[$name] = $_GET[$name.$suffix];   
             }
             return $values;
         }
         else
            return $_GET[$var.$suffix];
    }
    
    private static function GET_POST($name, $GET_POST)
    {
        switch ($GET_POST)
        {
            case "GET":
            return $_GET[$name];
            break;
            case "POST":
            return $_POST[$name];
            break;
            default:
            return $_POST[$name];
            break;
        }
    }
}  
  
  
?>