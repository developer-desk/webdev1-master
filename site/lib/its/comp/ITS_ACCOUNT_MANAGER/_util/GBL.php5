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
 
 

class GBL
{

    private static $instance = null;
    public $LID_ENABLED;
    private $LID;
    private $LG;
    private $INCLUDE_AUTO_CODE_EXEC;

    
    private function __construct()
    {
        $this->LID_ENABLED = true;
        $this->INCLUDE_AUTO_CODE_EXEC = true;
    }
    
    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new GBL();       
        } 
        return self::$instance;
    }
    
    public static function lidEnable()
    {
        $self = self::getInstance();
        $self->LID_ENABLED = true;
    }

    public static function lidDisable()
    {
        $self = self::getInstance();
        $self->LID_ENABLED = false;
    }

    public static function LID_ENABLED()
    {
        $self = self::getInstance();
         return $self->LID_ENABLED; 
    }

    
    private static function getLID()
    {
        $self = self::getInstance();
        $lid = $self->LID;
        if (!isset($lid)) //if there is no lid check to see if it was sent in a request variable
        {
            $lid = REQUEST::LID();
            if (!isset($lid) || $lid == "") //if no lid is in request variable the default lid is 1
                $lid = 1; 
            $self->LID = $lid;                
        }
        return $lid;    
    }

    public static function LID()
    {
        $lid = self::getLID();
        $lid = str_ireplace("_lid", "", $lid);
        return "_lid$lid"; 
    }

    public static function LIDVAL()
    {
        $lid = self::getLID();
        return $lid; 
    }
    
    
    private static function getLG()
    {
        $self = self::getInstance();
        $lg = $self->LG;
        if (!isset($lg)) //if there is no lg check to see if it was sent in a request variable
        {
            $lg = REQUEST::LG();
            if (!isset($lg) || $lg == "") //if no lid is in request variable the default lg is 1
                $lg = 1; 
            $self->LG = $lg;                
        }
        return $lg;    
    }

    public static function LG()
    {
        $lg = self::getLG();
        return $lg; 
    }
    
    
/*

    public static function LID()
    {
        $self = self::getInstance();
        $lid = $self->LID;
        if (!isset($lid))
        {
            $lid = REQUEST::readIn("lid");
            if (!isset($lid) || $lid == "")
                $lid = 1; 
            $self->LID = $lid;                
        }
        return "_lid$lid"; 
    }

    public static function LIDVAL()
    {
        $self = self::getInstance();
        $lid = $self->LID;
        if (!isset($lid))
            $self->LID = $lid = 1;
        return $self->LID; 
    }

  */  
    
    public static function setLID($lid)
    {
        $self = self::getInstance();
        $self->LID = $lid; 
    }
    public static function setLIDNext()
    {
        $self = self::getInstance();
        if (isset($self->LID))
            $self->LID++;
        else
            $self->LID=1;
    }

    
    public static function INCLUDE_AUTO_CODE_EXEC()
    {
        $self = self::getInstance();
        return $self->INCLUDE_AUTO_CODE_EXEC;
    }

    public static function INCLUDE_AUTO_CODE_EXEC_Disable()
    {
        $self = self::getInstance();
        $self->INCLUDE_AUTO_CODE_EXEC = false;
    }

    public static function INCLUDE_AUTO_CODE_EXEC_Enable()
    {
        $self = self::getInstance();
        $self->INCLUDE_AUTO_CODE_EXEC = true;
    }

}

class OP
{
    public static $create = 10;
    public static $edit = 20;
    public static $deactivate = 30;
    public static $delete = 40;
}

class HTTP_OUTPUT_OPTIONS
{
    public static $FULL_PAGE = 1;
    public static $AJAX_INNER_BODY = 2;
    public static $AJAX_OTHER = 3;
}



?>