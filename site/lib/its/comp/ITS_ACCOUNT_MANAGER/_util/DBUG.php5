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
 
 
include_once("DAL/File/FileIO.php5");
                                                                   
class DBUG_OUTPUT_OPTION
{
    public static $SCREEN = 1;
    public static $FILE = 2;  
    public static $SCREEN_AND_FILE = 3;
}             

class DBUG
{
    private static $instance = null;
          
    ////private $dbugLogFileDir = "D:\\Log\\takethetime.ca\\";
    private $dbugLogFileDir;
    private $dbugLogFileName = "dbugLogFile";
    private $outputOption;
    private $clearLog;
    
    protected $on;

    private function __construct()
    {
        $this->on = false;
        $this->dbugLogFileDir = CONFIG::$dbugLogFileDir;
    }
    
    private static function GetInstance()
    {
        // If the instance is null, make one
        if(!self::$instance)
        {
            self::$instance = new DBUG();
        }
 
        return self::$instance;
    }
    
    public static function SET_DBUG_ON($outputOption=null, $clearLog=false, $dbugLogFileName=null)
    {
        $self = self::GetInstance();
        $self->dbugLogFileName = "dbugLogFile.txt"; 
        $self->on = true;
        $self->clearLog = $clearLog;
        if (!isset($outputOption)) $outputOption = DBUG_OUTPUT_OPTION::$SCREEN;
        $self->outputOption = $outputOption;
        if (isset($dbugLogFileName))
            $self->dbugLogFileName = $dbugLogFileName;
        //$self->dbugLogFileName = $self->dbugLogFileDir.$self->dbugLogFileName;
        if ($clearLog || !FILEIO::chkFileExists($self->dbugLogFileName))
            FILEIO::createFile($self->dbugLogFileName,"",$self->dbugLogFileDir);
            //FILEIO::createFile($self->dbugLogFileName,"",$self->dbugLogFileDir,$self->dbugLogFileDir."_bkp\\");
    }

    public static function SET_DBUG_OFF()
    {
        $self = self::GetInstance();
        $self->dbugLogFileName = "dbugLogFile.txt"; 
        $self->on = false;
    }    
    
    public static function OUT($str, $func=null, $class=null)
    {
        $self = self::GetInstance(); 

        if ($self->on)
        {
            $output = "";
            if (isset($func)) $output = " | FUNC: $func";
            if (isset($class)) $output .= " | CLASS: $class";
            $str .= $output;
            
            //echo "output option: ". $self->outputOption;
            if ($self->outputOption!=DBUG_OUTPUT_OPTION::$FILE)
            {
                echo "debug: $str <br>";
            }
            
            if ($self->outputOption!=DBUG_OUTPUT_OPTION::$SCREEN)
            {
                    FILEIO::appendToFile($self->dbugLogFileDir.$self->dbugLogFileName, date("Y/m/d h:s:i")." ::-> ".$str."\r\n");  
            }
        }
    }
}
?>