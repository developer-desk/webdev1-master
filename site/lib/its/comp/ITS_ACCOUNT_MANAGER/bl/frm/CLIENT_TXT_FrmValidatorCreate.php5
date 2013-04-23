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
 
 

class CLIENT_TXT_FrmValidatorCreate extends Frm_Validator
{
    //declarations
		protected $client_txt_client_id;
		protected $client_txt_lg_id;
		protected $client_txt_name;
		protected $client_txt_descr;
		protected $client_txt_cb;
		protected $client_txt_dc;
		protected $client_txt_mb;
		protected $client_txt_dm;
		protected $client_txt_ts;

    
    public function __construct($reqVals)
    {
        $this->reqVals = $reqVals; //submit script should readin Variables and then pass them to be validated
        $row = 1;
        //it will only be necessary to loop through once a grid create is implemented...in which case it may be a separate Validator class
        //foreach ($reqVals as $row)
        //{}
        //set variables     
		$this->client_txt_client_id = $reqVals[$row]['client_txt_client_id'];
		$this->client_txt_lg_id = $reqVals[$row]['client_txt_lg_id'];
		$this->client_txt_name = $reqVals[$row]['client_txt_name'];
		$this->client_txt_descr = $reqVals[$row]['client_txt_descr'];
		$this->client_txt_cb = $reqVals[$row]['client_txt_cb'];
		$this->client_txt_dc = $reqVals[$row]['client_txt_dc'];
		$this->client_txt_mb = $reqVals[$row]['client_txt_mb'];
		$this->client_txt_dm = $reqVals[$row]['client_txt_dm'];
		$this->client_txt_ts = $reqVals[$row]['client_txt_ts'];

    }

    public function validate() //declared in abstract
    {
        //validate each variable and add error message where necessary
        ////example adding error message: $this->addErrMsg("Too large!", 1, "GNS_GNS_ID", ERRCODE::$dbInputInvalid);
        return true;
    }     
    
}      

?>