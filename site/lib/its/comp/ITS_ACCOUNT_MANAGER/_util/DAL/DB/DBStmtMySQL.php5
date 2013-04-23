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
 
 
class DBStmtMySQL extends DBStmtObj
{   
    
    public function __construct($connectionName)
    {
        parent::__construct($connectionName, "mysql");
    }

    public function execute($sql)
    {                                                                                      
        //safety statement needed
        parent::clearErrMsgs();
        $connection = $this->connect();
        ////DBUG::OUT("sql==". str_ireplace("(","",str_ireplace(")","",$sql)));
        DBUG::OUT("Final SQL exe:", $sql);
        $result = mysql_query($sql, $connection);
        //errchk
        $uid = mysql_insert_id();                                        
        return $uid;
    }      
                                
    public function executeUpdate($sql)
    {                                                                                      
        //safety statement needed
        parent::clearErrMsgs();
        $connection = $this->connect();
        DBUG::OUT("Final SQL Update:", $sql);

        $result = mysql_query($sql, $connection);
        //errchk
        return $result;
    } 
    
    public function executeUpdate2($sql)
    {                                                                                      
        //safety statement needed
        parent::clearErrMsgs();
        $connection = $this->connect();
        DBUG::OUT("Final SQL Update:", $sql);

        $result = mysql_query($sql, $connection);
        //errchk
        return mysql_affected_rows();
    }     
                                     
    public function executeSelect($sql)
    {
        //safety statement needed
        parent::clearErrMsgs();
        $connection = $this->connect();
        //echo $sql . "<br>";
        $this->recordSet = mysql_query($sql, $connection);
        return $this->recordSet;
    }                                  
    public function executeSchemaShowTables()
    {                                       
        parent::clearErrMsgs();
        $ret_val = $this->connect2();       
        $connectionStr = $ret_val[0];
        $connection = $ret_val[1];        
        $this->recordSet = mysql_query($connectionStr->SQL_SHOW_DB_TABLES(), $connection);
        return $this->recordSet;    
    }
    
    public function executeSchemaTableExists($table) 
    {
        // open db connection
        //$connectionLink = $this->connect();
        $ret_val = $this->connect2();       
        $connectionStr = $ret_val[0];
        $connection = $ret_val[1];
        $sql = $connectionStr->SQL_SHOW_DB_TABLES() . " like '$table'";
        //print $sql."<br>";    
           
        $result = mysql_query($sql, $connection) or die ('error reading database');
        if (mysql_num_rows ($result)>0)
        {
            return $result;
        }
        else
            return false;
    }

    public function executeSchemaShowFields($table) 
    {
        // open db connection
        //$connectionLink = $this->connect();
        $ret_val = $this->connect2();       
        $connectionStr = $ret_val[0];
        $connection = $ret_val[1];
        $sql = "SHOW FIELDS FROM ".$table;
        //print $sql."<br>";    
        //$sql = $connectionStr->SQL_SHOW_DB_TABLES() . " like '$table'";
        //$sql = "select * from supp";
        
        //print $sql."<br>";        
        $result = mysql_query($sql, $connection) or die ('error reading database');
        //print "got here";
        if (mysql_num_rows ($result)>0)
        {
            return $result;
        }
        else
            return false;
    }
    
    public function recordSetGetNext($recordset)
    {
        return mysql_fetch_row($recordset);
    }

    public function recordSetGetNext_assoc($recordset)
    {
        if ($recordset)
            return mysql_fetch_assoc($recordset);
        else
            return null;
    }

    public function recordSetGetAll($recordset)
    {
        $allRows= array();
        while ($row=$this->recordSetGetNext($recordset))
            $allRows[] = $row;
        return $allRows;
    }

    public function recordSetGetAll_assoc($recordset)
    {
        $allRows= array();
        //$cnt = 0;
        while ($row=$this->recordSetGetNext_assoc($recordset))
            $allRows[] = $row;
        return $allRows;
    }
}
    
abstract class DBStmtObjFactory
{
    public static function getDBStmtObj($connectionName, $dbms)
    {
        if (strcasecmp($dbms, 'mysql')==0)
        {
            return new DBStmtMySQL($connectionName);
        }
        else
        {
                print "NOT MYSQL";
            //errorLog - currently only support mysql at this time - errorLog)
            return null;
        }
    }    
}

  
?>