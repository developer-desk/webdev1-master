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
 
 
class DATATYPE
{
    public static $int = 100;
    public static $real = 101;
    public static $double = 102;
    public static $varchar = 200;
    public static $char = 201;
    public static $datetime = 300;
    public static $timestamp = 400;
    public static $intList = 1000;
    public static $other = 999;                         
    
    public static function getUID($val)
    {
        switch($val)
        {
            case DATATYPE::$int:
                return "int";
            break;
            case DATATYPE::$real:
                return "real";
            break;
             case DATATYPE::$double:
                return "double";
            break;
            case DATATYPE::$varchar:
                return "char";
            break;
            case DATATYPE::$char:
                return "char";
            break;
            case DATATYPE::$datetime:
                return "datetime";
            break;
            case DATATYPE::$timestamp:
                return "timestamp";
            break;
            case DATATYPE::$intList:
                return "intList";
            break;
            default:
                return "other";
            break;
       }
    }                
}

class DBTABLE_TYPE
{
    public static $primary = 1;
    public static $fkey = 2;
    public static $txt = 3;
    public static $fkeyTxt = 4;
    public static $cat = 5;
    public static $catTxt = 6;
    public static $other = 999;
}

class DBWHERE_OP
{
    public static $eq = 1;
    public static $gt = 2;
    public static $lt = 3;
    public static $gte = 4;
    public static $lte = 5;
    public static $ne = 6;
    public static $within = 50;
}

class DBWHERE_TYPE
{
    public static $and = 1;
    public static $or = 2;    
}

           
class DBCOL_TYPE
{
    public static $primary = 1;
    public static $fkey = 2;
    public static $txt = 3;
    public static $fkeyTxt = 4;
    public static $uid = 5;
    public static $sys = 6;
    public static $other = 999;
}

class DBSTMT_TYPE
{
    public static $insert = 1;
    public static $update = 2;
    public static $deactivate = 3;
    public static $delete = 4;
    public static $other = 999;
}

class GET_DBSTMT_TYPE
{
    public static function getDeclaration($dataType)
    {
        //echo "Data Type: $dataType";
        switch($dataType)
        {
            case DATATYPE::$int;
            return "DATATYPE::\$int";
            break;
            
            case DATATYPE::$real;
            return "DATATYPE::\$real";
            break;

            case DATATYPE::$double;
            return "DATATYPE::\$double";
            break;
            
            case DATATYPE::$varchar;
            return "DATATYPE::\$varchar";
            break;
            
            case DATATYPE::$char;
            return "DATATYPE::\$char";
            break;
            
            case DATATYPE::$datetime;
            return "DATATYPE::\$datetime";
            break;
            
            case DATATYPE::$timestamp;
            return "DATATYPE::\$timestamp";
            break;
            
            default:
            return "ERR_UNKOWN_DATATYPE";
            
        }
    }
}

class DBDAL
{
    // Holds the singleton instance
    private static $instance = null;
    
    // Contians each MySqlDAL object created;
    private $dbdals;
 
    private function __construct()
    {
        // Its private to prevent creation outside of the GetInstance function
        $this->dbdals = array();
    }
 
    public static function GetInstance()
    {
        // If the instance is null, make one
        if(!self::$instance)
        {
            self::$instance = new DBDAL();
        }
 
        return self::$instance;
    }
    public static function getConnection($connectionName)
    {
        if(!self::$instance)
        {
            DBConnect($connString); //registering
        }
        if(!is_null(isset(self::$instance->dbdals[$connectionName])))
        {
            if (is_null(self::$instance->dbdals[$connectionName][2])) //no connection has been established
            {
                $connectionStr = self::$instance->dbdals[$connectionName][0];
                $connection = DBConnectorMySQL::connect($connectionStr); 
                self::$instance->dbdals[$connectionName][2] = $connection;//store connection 
                return $connection;                  
            }
            else
            {
                return self::$instance->dbdals[$connectionName][2];
            }
        }
        else
        {
            //errorLog connection not registered - should never reach here
            //print "here5";
            return null;
        }
                    
    }                                                   

    public static function getConnectionArr($connectionName)
    {
        self::getConnection($connectionName);
        return array(self::$instance->dbdals[$connectionName][0], self::$instance->dbdals[$connectionName][2]);                    
    }                                                   


    
    ////public static function DBConnect($connectionStr=DBConnectionString)
    public static function DBConnect(DBConnectionString $connectionStr)
    {
        $stmtObj = null;
        $self = self::GetInstance();
        //identify dbdals by their connection names
        $connectionName = $connectionStr->name();
        if(!isset($self->dbdals[$connectionName]))
        {
            //echo "<br>IS set!!!<br>";
            $stmtObj = DBStmtObjFactory::getDBStmtObj($connectionName, $connectionStr->dbms);
            $self->dbdals[$connectionName] = array($connectionStr, $stmtObj, null);
        }
        else
            $stmtObj = $self->dbdals[$connectionName][1];
 
        $stmtObj->init(); //reset values in case this connection has already been used
        return $stmtObj;   
        //may have to program case for when dbdal has already bee created
    }
}

class DBConnectionString
{
    private $name;
    private $sqlShowDbTables;
    public static $db_server;  
    public static $dbms; 
    public static $db_user;
    public static $db_pwd;   
    public static $db_name;
    public $test;
    
    public function __construct($connection_name, $dbServer, $dbms, $user, $pwd, $db)
    {
        $this->name = $connection_name;
        $this->db_server = $dbServer;
        $this->dbms = $dbms;
        $this->db_user = $user; 
        $this->db_pwd = $pwd;     
        $this->db_name = $db; 
        $this->sqlShowDbTables = "SHOW TABLES FROM $db";               
        $this->test = "TESTING!!!";
    }
    
    public function SQL_SHOW_DB_TABLES()
    {
        return $this->sqlShowDbTables;
    }
    
    public function name()
    {
        return $this->name;
    }
    
}

class DBConnection
{
    public static function Dev()
    {                             
        return new DBConnectionString("devsite", "127.0.0.1:3307", "mysql", "devUser1", 'devuser89', "devsite");
    }

    public static function blank()
    {                             
        return new DBConnectionString("", "", "", "", "", "");
    }    
}

/*
class DBConnection
{
    public static function TakeTheTime()
    {                             
        //return new DBConnectionString("TakeTheTime", "db1693.perfora.net", "mysql", "dbo261137401", "Kwbe2Kjn", "db261137401");
        return new DBConnectionString("TakeTheTime", "localhost", "mysql", "root", "cassiokeke", "MySQL");
    }
    public static function blank()
    {                             
        return new DBConnectionString("", "", "", "", "", "");
    }    
}
*/

interface DBConnectorObj
{    
    public static function connect($connString=DBConnectionString);
    public static function closeConnection($connection);
}
class DBConnectorMySQL implements DBConnectorObj
{
    public static function connect($connString=DBConnectionString)
    {
        $conn = MYSQL_CONNECT($connString->db_server, $connString->db_user, $connString->db_pwd, true) or die ("<H3>Server unreachable</H3>");    
        //$conn = null;
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
            //error log - "Could not connect"
        }
        DBConnectorMySQL::dbSelect($connString, $conn);
        return $conn;
        
    }
    
    public static function dbSelect($connString, $conn)
    {
        $db_selected = mysql_select_db($connString->db_name, $conn);
        if (!$db_selected)
        {
            die ('Can\'t open db $connString->db_name : ' . mysql_error());
        }    
    }
    
    public static function closeConnection($connection)
    {
        mysql_close($connection);    
    }
}
abstract class DBStmtObj
{
    protected static $connectionName;
    protected static $dbms;
    protected $recordSet;
    protected $sqlParameters = array();
    protected $sqlParameterValues = array();
    private $sqlWhere;
    private $errMsgs;
    private $dbWhereType;
                              
    public function __construct($connectionName, $dbms)
    {
        $this->connectionName = $connectionName;
        $this->dbms = $dbms;
        $this->dbWhereType = DBWHERE_TYPE::$and;//default        
    }
    
    public function init()
    {
        $this->sqlParameters = array();
        $this->sqlParameterValues = array();
        $this->recordSet = null;
        $this->sqlWhere = null;
        $this->errMsgs = null;        
    }

    public function getErrMsgs()
    {
        return $this->errMsgs;
    }   
    
    protected function setErrMsgs($errMsgs)
    {
        $this->errMsgs = $errMsgs;
    } 
    
    protected function clearErrMsgs()
    {
        $this->errMsgs = null;
    }
    private function concatenate($arr, $flag=false)
    {
        $retVal = "";
        $c = "";
        if ($flag==true)
            $c = '$';

       foreach($arr as $key=>$value)
       {
            if($key!=0)
                $retVal .= ", ";
            $retVal .= $c.$value;
       } 
       return $retVal;
    }
    
    private function concatenateUpdate($arr1, $arr2)
    {
        $retVal = "";
        $count = count($arr1);
        for ($i = 0; $i < $count; $i++) 
        {
            if($i!=0)
                $retVal .= ", ";
            $retVal .= $arr1[$i] . " = " . $arr2[$i];              
        }
        return $retVal;
    
     }    
    
    public function sqlCreateStmtSelect($sql)
    {
        $sql .= " " . $this->sqlWhere;        
        return $sql;
    }


    public function sqlAddManualWhere($sql, $where)
    {
       if (isset($this->sqlWhere))
        $sql .= " AND " . $where;
       else        
        $sql .= " WHERE " . $where;

        return $sql;
    }    
    
    public function sqlCreateStmt($tableName)
    {
        $columns = $this->concatenate($this->sqlParameters);
        $values = $this->concatenate($this->sqlParameterValues);
        return "INSERT $tableName ($columns) values ($values)";
    }

    public function sqlCreateStmtUpdate($tableName)
    {
         DBUG::OUT("***where".$this->sqlWhere,"sqlCreateStmtUpdate", "dbdal");
        $updateCodePortion = $this->concatenateUpdate($this->sqlParameters, $this->sqlParameterValues);
        $pattern = "/where/i";
        $sql = "";
        //DBUG::OUT("DB Update errors occured", "executeStmtUpdate", "dbdalObj");            
        if (preg_match($pattern, $this->sqlWhere)>0)
        {
            $sql = "Update $tableName Set $updateCodePortion " . $this->sqlWhere;        
        }
        $pattern = "/ where /i";
        if (preg_match($pattern, $sql)==0)
            $sql = "";
        return $sql;
    }

    public function sqlCreateStmtCode($tableName)
    {
        $columns = $this->concatenate($this->sqlParameters);
        $values = $this->concatenate($this->sqlParameters, true);
        return "\$sql = \"INSERT $tableName ($columns) values ($values)\";";
    }
    
    public function clearParameters()
    {
        unset($this->sqlParameters);
        unset($this->sqlParameterValues);        
    }                                               
   /* 
    public function addParameter($parameter, $val, $datatype)
    {
        $retVal = $val;
        $this->sqlParameters[] = $parameter;
        if ($datatype == DATATYPE::$char || $datatype==DATATYPE::$datetime || $datatype == DATATYPE::$varchar)
        {
            $retVal =  "'" . $val . "'";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
        }
        if (!isset($val)||$val=="")
            $retVal = "null";
             
        DBUG::OUT("adding parameter :$parameter = $retVal , val:$val", __METHOD__, __CLASS__);
        $this->sqlParameterValues[] = $retVal;                              
        return $retVal;
    }

    public function addWhere($parameter, $val, $datatype, $isList=false)
    {   //new
        DBUG::OUT("In ADDWHERE  parameter:".$parameter." VAL:".$val);
        $retVal = $val;
        if ($datatype == DATATYPE::$char || $datatype==DATATYPE::$datetime || $datatype == DATATYPE::$varchar)
        {
            $retVal =  "'" . $val . "'";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
        }
        if ($this->sqlWhere == "")
        {
            if (!$isList)
                $this->sqlWhere = "Where ($parameter = $retVal)"; 
            else
                $this->sqlWhere = "Where ($parameter in ($retVal))";                 
        }
        else
        {
            if (!$isList)
                $this->sqlWhere .= " and ($parameter = $retVal)";
            else
                $this->sqlWhere .= " and ($parameter in ($retVal))";            
        }        
    }
    */

    public function addParameter($parameter, $val, $datatype)
    {
        $retVal = $val;
        $this->sqlParameters[] = $parameter;
        if ($datatype == DATATYPE::$char || $datatype==DATATYPE::$datetime || $datatype == DATATYPE::$varchar)
        {
            $retVal =  "'" . $val . "'";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
        }
        if (!isset($val)||$val=="")
            $retVal = "null";
             
        DBUG::OUT("adding parameter :$parameter = $retVal , val:$val", __METHOD__, __CLASS__);
        $this->sqlParameterValues[] = $retVal;                              
        return $retVal;
    }

    public function setDBWhereType($dbWhereType)
    {
        DBUG::OUT("SETTING WHERE TYPE: $dbWhereType");
        $this->dbWhereType = $dbWhereType;
    }   

    
    public function addWhere($parameter, $val, $datatype, $isList=false, $parameterType=1)
    {
        $parameterType==""||$parameterType==null ? $parameterType=1 : $parameterType=$parameterType;
       //new
        DBUG::OUT("In ADDWHERE  parameter:".$parameter." VAL:".$val.", parameterType: $parameterType");
        $retVal = $val;
        if ($datatype == DATATYPE::$char || $datatype==DATATYPE::$datetime || $datatype == DATATYPE::$varchar && !$isList)
        {
            DBUG::OUT("**A");
            if ($parameterType==2)
                $val =  "%" . $val . "%";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            $retVal =  "'" . $val . "'";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
        }
        if ($this->sqlWhere == "")
        {                                          
            DBUG::OUT("**b");
            if (!$isList)
            {
            DBUG::OUT("**c");
                if ($parameterType==1)
                    $this->sqlWhere = "Where ($parameter = $retVal)"; 
                elseif ($parameterType==2)
                    $this->sqlWhere = "Where ($parameter like $retVal)";                                 
                elseif ($parameterType==4)
                    $this->sqlWhere = "Where ($parameter >= $retVal)";                                 
                elseif ($parameterType==5)
                    $this->sqlWhere = "Where ($parameter <= $retVal)";                                 
            DBUG::OUT("**c ".$this->sqlWhere);  
            }
            else //if it is a list then it is a type number parameter
            {
                $this->sqlWhere = "Where ($parameter in ($retVal))";                             
            }

        }
        else
        {
            $dbWhereType = $this->dbWhereType == DBWHERE_TYPE::$and ? "and" : "or";
            if (!$isList)
            {
                if ($parameterType==1)
                    $this->sqlWhere .= " $dbWhereType ($parameter = $retVal)"; 
                elseif ($parameterType==2)
                    $this->sqlWhere .= " $dbWhereType ($parameter like $retVal)";                                 
                elseif ($parameterType==4)
                    $this->sqlWhere .= " $dbWhereType ($parameter >= $retVal)";                                 
                elseif ($parameterType==5)
                    $this->sqlWhere .= " $dbWhereType ($parameter <= $retVal)";                                 
            }
            else //if it is a list then it is a type number parameter
                $this->sqlWhere .= " $dbWhereType ($parameter in ($retVal))";                             
        }        
        DBUG::OUT("sqlWhere  parameter:".$this->sqlWhere);
    }
    
    

   public function clearWhere()
   {
       $this->sqlWhere = "";
   }
                      
    
    
    
/*    public function addParameterHolder($parameter, $val, $datatype)
    {
        $retVal = $val;
        $this->sqlParameters[] = $parameter;
        if ($datatype == DATATYPE::$char || $datatype==DATATYPE::$datetime || $datatype == DATATYPE::$varchar)
        {
            $retVal =  "'%s'";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
        } 
        $this->sqlParameterValues[] = $retVal;                              
        return $retVal;
    }
*/
    protected function connect()
    {
        return DBDAL::getConnection($this->connectionName);
    }
    protected function connect2()
    {
        return DBDAL::getConnectionArr($this->connectionName);
    }

//  abstract private function connect();
    abstract public function execute($sql);  
    abstract public function executeSelect($sql);  
    abstract public function executeSchemaShowTables();  
    abstract public function executeSchemaTableExists($table);  
    abstract public function executeSchemaShowFields($table);  
    abstract public function recordSetGetNext($recordset);  
    abstract public function recordSetGetNext_assoc($recordset);  
}
                     
?>