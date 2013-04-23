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
 
 

class CLIENT_TXT_FrmSubmitCreate
{
    protected $user_id;
    protected $sec_validator;
    protected $errs;
    
    //dynamic
    protected $parameters = array();
    
    protected $validator = null;
    
    protected $dbdal = null;
    
    public function __construct()
    {
        $this->user_id = SEC::USER_ID();
        $this->readInParameters();
        
        $this->sec_validator = SecPermitFct::getObj("CLIENT_TXT", OP::$create);  
                
        //dynamic
        $this->validator = new CLIENT_TXT_FrmValidatorCreate($this->parameters);
    }

    public function readInParameters()
    {
        //dynamic primary
        $parameterList = CLIENT_TXT_frmParameters::getParameterList();                       
        $rows = 1;     
        //since rows is passed-in, the REQUEST function will return a multidimensional array  - for now we only use row 1 (since grid forms have not yet been implemented)                          
        $this->parameters = REQUEST::readIn($parameterList, $rows);
    }
    
    public function validate()
    {
        $sec_valid = $this->sec_validator->validate();
              
        //dynamic
        $valid = $this->validator->validate();
        
        return ($sec_valid && $valid);
    }                
    
    public function process()
    {
        if ($this->validate())//insert primary //insert txt
        {
            $lg_id = REQUEST::LG();//not needed if lg_id is part of form
            //dynamic
            $this->dbdal = new dbdalCLIENT_TXT($lg_id); //this LIDVAL is obsolete, even lg variable in dbdal seems obsolete
            
            //primary
            $row = 1;//for now we only use row 1 (since grid forms have not yet been implemented) - later may call insert for each row                          
            $this->dbdal->insertRecordByAssocArr($this->parameters[$row], $this->user_id);//***NEED TO RETRIEVE ID FROM PRIMARY INSERT IN ORDER TO DO TXT INSERT***  

            if (!$this->dbdal->VALID())
            {
                $this->errs = $this->dbdal->getErrMsgs();
                $this->errHandler();            
            }
            else
            {

                return true;
            }

        }
        else
        {
            //dynamic
            $errs = array_merge($this->sec_validator->getErrs(), $this->validator->getErrs);
            $this->errHandler();
        }
    }
    

    public function addParameter($key, $val, $row)
    {
        $this->parameters[$row][$key] = $val;
    }
    
    public function errHandler()
    {
        echo "In error Handler, class: CLIENT_TXT_FrmSubmitCreate";
    }

    public function getErrs()
    {
        return $this->errs;
    }

    protected function errReturnCreateForm($errs)
    {
        //dynamic
        //**could just include create file and set a GLOBAL parameter variable
        $frmCreate = new CLIENT_TXT_FrmCreate("CLIENT_TXT", $this->parameters, $errs);
        $frm = $frmCreate->genForm();
        echo $frm;            
    }
    
    public function VALID()
    {
        return(!isset($this->errs));
    }

}

?>