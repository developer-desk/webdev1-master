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
 
         
//include_once(CONFIG::$DIR_UTIL_DBDAL."DbUtilCategory.php5");
class dbdalObj
{
    protected $db;
    protected $valid;
    protected $isValid;
    protected $sql;

    protected $tblName;
    protected $uid;
    protected $pKeyArr;

    protected $lg;
  
    protected $tblArr;
    
    private $util;
    private $errMsgs;

    private $UtilCat_initialized;
    private $UtilCat_pkey;
    private $UtilCat_pid;
    private $UtilCat_root;
    private $UtilCat_lvl;  
    private $UtilCat_kidz;


    public function utilCat_getRootPidLvlKidz($cat_id, &$out_root, &$out_pid, &$out_lvl, &$out_kidz)
    {
        $pkeyName = $this->tblName."_ID";
        $sql = "SELECT ROOT, PID, LVL, KIDZ FROM $this->tblName where $pkeyName = $cat_id";
        DBUG::OUT("utilCat_getRootPidLvlKidz: $sql");
        $recordSet = $this->executeStmtSelect($sql);
        $recordSet = $this->db->recordSetGetAll_assoc($recordSet);
        $out_root = $recordSet[0]['ROOT'];
        $out_pid = $recordSet[0]['PID'];
        $out_lvl = $recordSet[0]['LVL'];
        $out_kidz = $recordSet[0]['KIDZ'];
    }
    
    public function utilCat_getChildren($pid)
    {
        $txtTable = $this->tblName."_txt";
        $pkeyName = $this->tblName."_ID";
        if (isset($pid) && $pid !="")
        {
            $sql_where_pid = "A.PID = $pid";            
        }
        else
            $sql_where_pid = "(A.PID IS NULL) or (A.PID = 0)";
            
        $sql = "SELECT A.$pkeyName, A.ROOT, A.PID, A.LVL, A.KIDZ, B.NAME, B.DESCR FROM $this->tblName A LEFT JOIN $txtTable B ON A.$pkeyName = B.$pkeyName where $sql_where_pid";
        $dataSet = $this->executeStmtSelect($sql);
        $dataSet = $this->db->recordSetGetAll_assoc($dataSet);
        return $dataSet;
    }
        
    public function __construct(DBConnectionString $connection, $validatorType, $lg)
    {
        $this->db = DBDAL::DBConnect($connection);        
        $this->valid = VALIDATORFct::getObj($validatorType);
        $this->lg = $lg;
        $this->UtilCat_initialized = false;
    }   
    protected function setErrMsgs($errMsgs)
    {
        $this->errMsgs = $errMsgs;
    }                                 
    public function getErrMsgs()
    {
        return $this->errMsgs;
    }                                     
    protected function setStandardParameters($stmtType=1, $uid)
    {
        $sysDate = date('Y/m/d');
        //INSERT SPECIFIC
        if ($stmtType==DBSTMT_TYPE::$insert && $uid != null)
        {
            $this->db->addParameter("cb", $uid, DATATYPE::$int);        
        }
        if ($stmtType==DBSTMT_TYPE::$insert)
        {
            $this->db->addParameter("dc", $sysDate, DATATYPE::$datetime);        
        }
        //UPDATE SPECIFIC
        if (($stmtType==DBSTMT_TYPE::$update || $stmtType==DBSTMT_TYPE::$deactivate) && $uid != null) 
        {
            $this->db->addParameter("mb", $uid, DATATYPE::$int);        
        }
        if (($stmtType==DBSTMT_TYPE::$update || $stmtType==DBSTMT_TYPE::$deactivate))
        {
            $this->db->addParameter("dm", $sysDate, DATATYPE::$datetime);        
        }
    }
    
    protected function setStandardParametersCat($pid)
    {
        DBUG::OUT("Setting CAT parameters","setStandardParametersCat","dbdalObj");
        $tblName = $this->tblName;
        $this->UtilCat_init($tblName, $pid);
        $root = $this->UtilCat_ROOT();
        $root = $root=="" ? null : $root;
        $lvl = $this->UtilCat_LVL();
        DBUG::OUT("Setting Cat Parameters: root:$root , lvl:$lvl","","dbdalObj2");    
        $this->db->addParameter("root", $root, DATATYPE::$int);        
        $this->db->addParameter("lvl", $lvl, DATATYPE::$int);                
    }

   protected function addWhere($columnName, $value, $dataType)
   {
        $this->db->addWhere($columnName, $value, $dataType);   
   }  
   
   protected function clearWhere()
   {
       $this->db->clearWhere();
   }
                      
   protected function errProcessing()
   {
        $this->errMsgs = $this->valid->getErrMsgs();
        return -999;
   }
   

    protected function executeStmtSelect($sql, $addWhereManually=null, $orderBy=null)
    {
        $sql = $this->db->sqlCreateStmtSelect($sql);
        if (isset($addWhereManually))
            $sql .= " $addWhereManually";
        if (isset($orderBy))
            $sql .= " $orderBy";
        DBUG::OUT("debug sql: ".$sql, "executeStmtSelect", "dbdalObj");
        $recordSet = $this->db->executeSelect($sql);
        return $recordSet;
    }

   protected function executeStmt()   //This function should be only for performing inserts
   {
        $sql = $this->db->sqlCreateStmt($this->tblName);
        //$code = $this->db->sqlCreateStmtCode($this->tblName);
        DBUG::OUT("sql: ".$sql, "executeStmt", "dbdalObj");
        $retVal = $this->db->execute($sql);
        DBUG::OUT("retval: ".$retVal, "executeStmt", "dbdalObj");
        if ($retVal<0)
            $this->errMsgs = $this->db->getErrMsgs();
        else
        {
           DBUG::OUT("About to Update calculated fields",__METHOD__,__CLASS__);    
            $this->updateCalculatedFields($retVal);
        }
        
        return $retVal;
   }

   public function executeSqlStmt($sql)   //This function should be only for performing inserts
   {
        DBUG::OUT("sql: ".$sql, __method__, __class__);
        $retVal = $this->db->execute($sql);
        if ($retVal<0)
            $this->errMsgs = $this->db->getErrMsgs();
        return $retVal;
   }
   
   public function executeUpdate($sql)   //This function should be only for performing inserts
   {
        return $this->db->executeUpdate2($sql);
   }
      
   public function executeSelect($sql)   //This function should be only for performing inserts
   {
        DBUG::OUT("sql: ".$sql, __method__, __class__);
        $recordSet = $this->db->executeSelect($sql);
        return $this->db->recordSetGetAll_assoc($recordSet);
   }
  
   protected function executeStmtUpdate()
   {
        $sql = $this->db->sqlCreateStmtUpdate($this->tblName);
        //DBUG::OUT("HERE IT IS: ".$sql, "executeStmtSelect", "dbdalObj");
        //echo "orig sql: " . $sql;
        //echo "<br>";
        //$sql2 = "Update GNS_TYPE_TXT Set name = 'Product HARD CODE2', descr = 'Product HARD CODE2', mb = 199, dm = '2009/08/15' Where (GNS_TYPE_TXT.gns_type_id = 1) and (GNS_TYPE_TXT.lg_id = 1)";

       // echo "sql2: " . $sql2;
        //DBUG::OUT("THIS WORKS: ".$sql2);
        $retVal = $this->db->executeUpdate($sql);
        if ($retVal<0)
        {
            DBUG::OUT("DB Update errors occured", "executeStmtUpdate", "dbdalObj");
            $this->errMsgs = $this->db->getErrMsgs();            
        }
        else
        {
           DBUG::OUT("About to Update calculated fields","executeStmtUpdate","dbdalObj2");    
            $this->updateCalculatedFields($retVal);
        }
   }

   private function updateCalculatedFields($id)
   {
       if ($this->UtilCat_isInitialized())
       {
           DBUG::OUT("Updating calculated fields",__METHOD__,__CLASS__);    
           $this->UtilCat_updateKidz($this->UtilCat_PID());//updates parents calculated field "kidz"
           $this->UtilCat_updateRoot($id);
           $this->UtilCat__reset();
       }
   }
   
    public function VALID()
    {
        return $this->valid->VALID();
    }


   public function UtilCat_ROOT()
   {
       return $this->UtilCat_root;
   }

   public function UtilCat_PID()
   {
       return $this->UtilCat_pid;
   }

   public function UtilCat_LVL()
   {
       return $this->UtilCat_lvl;
   }

   public function UtilCat_KIDZ()
   {
       return $this->UtilCat_kidz;
   }
   
   public function UtilCat_isInitialized()
   {
       return $this->UtilCat_initialized;
   }

 
   public function UtilCat_init($tblName, $pid)
   {
       DBUG::OUT("init: tblName:$tblName pid:$pid", __METHOD__, __CLASS__);
       $this->UtilCat_pkey = $this->utilGetPkey($tblName); //Technically do not have to calculate this every time...will always be the same
       $this->UtilCat_pid = $pid;
       $this->UtilCat_root = null;
       $this->UtilCat_lvl = null;
       $this->UtilCat_getRootAndLvl();
       $this->UtilCat_initialized = true;
    
   }

   public function UtilCat__reset()
   {
        $this->UtilCat_initialized = false;
   }
    
   private function utilGetPkey($tblName)
   {
       return strtoupper($tblName)."_ID";
   }
    
   private function UtilCat_getRootAndLvl()
   {
       if (!isset($this->UtilCat_pid)||$this->UtilCat_pid=="")
       {
           DBUG::OUT("Determining LEVEL&ROOT : TOP LEVEL");
           $this->UtilCat_root = 0;
           $this->UtilCat_lvl = 1;           
       }
       else
       {
           $sql = "SELECT ROOT, LVL FROM $this->tblName where $this->UtilCat_pkey = $this->UtilCat_pid";
           DBUG::OUT("Determining LEVEL&ROOT : SEARCHING: $sql",__METHOD__,__CLASS__);
           //DBUG::OUT("SQL: $sql");
           $recordSet = $this->executeStmtSelect($sql);
           $recordSet = $this->db->recordSetGetAll_assoc($recordSet);
           $this->UtilCat_root = $recordSet[0]['ROOT'];
           $this->UtilCat_lvl = $recordSet[0]['LVL'];
           if (!isset($this->UtilCat_lvl)||$this->UtilCat_lvl=="")
           {
                $this->UtilCat_lvl = 1;    
           }
           else
           {
                $this->UtilCat_lvl++;
           }              
       }
   }

   public function UtilCat_getKidz($id)
   {
       $sql = "SELECT COUNT(*) AS 'KIDZ' FROM $this->tblName where pid = $id";
       //DBUG::OUT("SQL: $sql");
       $recordSet = $this->executeStmtSelect($sql);
       $recordSet = $this->db->recordSetGetAll_assoc($recordSet);
       $kidz = $recordSet[0]['KIDZ'];
       if (!isset($kidz)||$kidz=="")
       {
            $this->UtilCat_kidz = 0;    
       }
       else
       {
            $this->UtilCat_kidz=$kidz;
       } 
       return $this->UtilCat_kidz;          
   }     
   
   public function UtilCat_updateKidz($id)
   {
       $kidz = $this->UtilCat_getKidz($id);
       $sql = "UPDATE $this->tblName SET KIDZ = $kidz WHERE $this->UtilCat_pkey = $id";
       $rv = $this->db->executeUpdate($sql);
       return $rv;          
   }     

   public function UtilCat_updateRoot($id)
   {
       DBUG::OUT("***UPDATING ROOT id: $id",__METHOD__,__CLASS__);
       $pid = $this->UtilCat_PID();
       $root = null;
       if (isset($pid))
       {
           $sql = "SELECT ROOT from $this->tblName where $this->UtilCat_pkey = $pid";
           DBUG::OUT("SEARCHING FOR ROOT: $sql",__METHOD__,__CLASS__);
           //DBUG::OUT("SQL: $sql");
           $recordSet = $this->executeStmtSelect($sql);
           $recordSet = $this->db->recordSetGetAll_assoc($recordSet);
           $root = $recordSet[0]['ROOT'];
           if (!isset($root))
           {
                $root = $pid;//
           }           
       }
       else
            $root = $id;
            
       $this->UtilCat_root = $root;              

       $sql = "UPDATE $this->tblName SET ROOT = $root WHERE $this->UtilCat_pkey = $id";
       DBUG::OUT("UPDATING ROOT: $root, sql:$sql",__METHOD__,__CLASS__);
       $rv = $this->db->executeUpdate($sql);
       return $rv;          
   }     

    
}

  
?>