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
 
 
class dbdalCLIENT extends dbdalObj
{
	public function __construct($lg)
	{
		$this->tblName = "CLIENT";

		parent::__construct(DBConnection::Dev(), 1, $lg);


	}

	public function selectRecordNew($filters, $cnt=false, $isList=null)
	{

		$sql = "SELECT";
		$selectList = 
		$cnt ?" count(*) " :
"			CLIENT.CLIENT_ID AS CLIENT_CLIENT_ID 
			,CLIENT.FULL_NAME AS CLIENT_FULL_NAME 
			,CLIENT.EMAIL_ADDRESS AS CLIENT_EMAIL_ADDRESS 
			,CLIENT.PASSWORD AS CLIENT_PASSWORD 
			,CLIENT.CONTACT_ID AS CLIENT_CONTACT_ID 
			,CLIENT.CLIENT_TYPE_ID AS CLIENT_CLIENT_TYPE_ID 
";
		$from = 
		"		FROM CLIENT 
		";
$sql .= $selectList.$from;
		if (isset($filters["CLIENT_CLIENT_ID"]))
			$this->db->addWhere("CLIENT.client_id", $filters["CLIENT_CLIENT_ID"], DATATYPE::$int, $isList["CLIENT_CLIENT_ID"]);
		if (isset($filters["CLIENT_FULL_NAME"]))
			$this->db->addWhere("CLIENT.full_name", $filters["CLIENT_FULL_NAME"], DATATYPE::$varchar, $isList["CLIENT_FULL_NAME"]);
		if (isset($filters["CLIENT_EMAIL_ADDRESS"]))
			$this->db->addWhere("CLIENT.email_address", $filters["CLIENT_EMAIL_ADDRESS"], DATATYPE::$varchar, $isList["CLIENT_EMAIL_ADDRESS"]);
		if (isset($filters["CLIENT_PASSWORD"]))
			$this->db->addWhere("CLIENT.password", $filters["CLIENT_PASSWORD"], DATATYPE::$varchar, $isList["CLIENT_PASSWORD"]);
		if (isset($filters["CLIENT_CONTACT_ID"]))
			$this->db->addWhere("CLIENT.contact_id", $filters["CLIENT_CONTACT_ID"], DATATYPE::$int, $isList["CLIENT_CONTACT_ID"]);
		if (isset($filters["CLIENT_CLIENT_TYPE_ID"]))
			$this->db->addWhere("CLIENT.client_type_id", $filters["CLIENT_CLIENT_TYPE_ID"], DATATYPE::$int, $isList["CLIENT_CLIENT_TYPE_ID"]);
		if (isset($filters["CLIENT_TXT_CLIENT_ID"]))
			$this->db->addWhere("CLIENT_TXT.client_id", $filters["CLIENT_TXT_CLIENT_ID"], DATATYPE::$int, $isList["CLIENT_TXT_CLIENT_ID"]);
		if (isset($filters["CLIENT_TXT_LG_ID"]))
			$this->db->addWhere("CLIENT_TXT.lg_id", $filters["CLIENT_TXT_LG_ID"], DATATYPE::$int, $isList["CLIENT_TXT_LG_ID"]);
		if (isset($filters["CLIENT_TXT_NAME"]))
			$this->db->addWhere("CLIENT_TXT.name", $filters["CLIENT_TXT_NAME"], DATATYPE::$varchar, $isList["CLIENT_TXT_NAME"]);
		if (isset($filters["CLIENT_TXT_DESCR"]))
			$this->db->addWhere("CLIENT_TXT.descr", $filters["CLIENT_TXT_DESCR"], DATATYPE::$varchar, $isList["CLIENT_TXT_DESCR"]);
		if (isset($filters["CLIENT_TXT_CB"]))
			$this->db->addWhere("CLIENT_TXT.cb", $filters["CLIENT_TXT_CB"], DATATYPE::$int, $isList["CLIENT_TXT_CB"]);
		if (isset($filters["CLIENT_TXT_DC"]))
			$this->db->addWhere("CLIENT_TXT.dc", $filters["CLIENT_TXT_DC"], DATATYPE::$datetime, $isList["CLIENT_TXT_DC"]);
		if (isset($filters["CLIENT_TXT_MB"]))
			$this->db->addWhere("CLIENT_TXT.mb", $filters["CLIENT_TXT_MB"], DATATYPE::$int, $isList["CLIENT_TXT_MB"]);
		if (isset($filters["CLIENT_TXT_DM"]))
			$this->db->addWhere("CLIENT_TXT.dm", $filters["CLIENT_TXT_DM"], DATATYPE::$datetime, $isList["CLIENT_TXT_DM"]);
		if (isset($filters["CLIENT_TXT_TS"]))
			$this->db->addWhere("CLIENT_TXT.ts", $filters["CLIENT_TXT_TS"], DATATYPE::$timestamp, $isList["CLIENT_TXT_TS"]);

		$recordSet = parent::executeStmtSelect($sql);
		$this->db->clearWhere();
		return $this->db->recordSetGetAll_assoc($recordSet);

	}

	public function selectRecord_edit($CLIENT_client_id=null)
	{

		$sql = "SELECT
			CLIENT.CLIENT_ID AS CLIENT_CLIENT_ID 
			,CLIENT.FULL_NAME AS CLIENT_FULL_NAME 
			,CLIENT.EMAIL_ADDRESS AS CLIENT_EMAIL_ADDRESS 
			,CLIENT.PASSWORD AS CLIENT_PASSWORD 
			,CLIENT.CONTACT_ID AS CLIENT_CONTACT_ID 
			,CLIENT.CLIENT_TYPE_ID AS CLIENT_CLIENT_TYPE_ID 
			,CLIENT_TXT.CLIENT_ID AS CLIENT_TXT_CLIENT_ID 
			,CLIENT_TXT.LG_ID AS CLIENT_TXT_LG_ID 
			,CLIENT_TXT.NAME AS CLIENT_TXT_NAME 
			,CLIENT_TXT.DESCR AS CLIENT_TXT_DESCR 
			,CLIENT_TXT.CB AS CLIENT_TXT_CB 
			,CLIENT_TXT.DC AS CLIENT_TXT_DC 
			,CLIENT_TXT.MB AS CLIENT_TXT_MB 
			,CLIENT_TXT.DM AS CLIENT_TXT_DM 
			,CLIENT_TXT.TS AS CLIENT_TXT_TS 
		FROM CLIENT 
		INNER JOIN CLIENT_TXT 
			 ON CLIENT.CLIENT_ID = CLIENT_TXT.CLIENT_ID 
		INNER JOIN LG 
			 ON CLIENT_TXT.LG_ID = LG.LG_ID 
			INNER JOIN LG_TXT 
			 ON LG.LG_ID = LG_TXT.LG_ID 
		";
		if (isset($CLIENT_client_id))
			$this->db->addWhere("CLIENT.client_id", $CLIENT_client_id, DATATYPE::$int);

		$recordSet = parent::executeStmtSelect($sql);
		$this->db->clearWhere();
		return $this->db->recordSetGetAll_assoc($recordSet);

	}

	public function selectRecord($CLIENT_client_id=null)
	{

		$sql = "SELECT
			CLIENT.CLIENT_ID AS CLIENT_CLIENT_ID 
			,CLIENT.FULL_NAME AS CLIENT_FULL_NAME 
			,CLIENT.EMAIL_ADDRESS AS CLIENT_EMAIL_ADDRESS 
			,CLIENT.PASSWORD AS CLIENT_PASSWORD 
			,CLIENT.CONTACT_ID AS CLIENT_CONTACT_ID 
			,CLIENT.CLIENT_TYPE_ID AS CLIENT_CLIENT_TYPE_ID 
			,CLIENT_TXT.CLIENT_ID AS CLIENT_TXT_CLIENT_ID 
			,CLIENT_TXT.LG_ID AS CLIENT_TXT_LG_ID 
			,CLIENT_TXT.NAME AS CLIENT_TXT_NAME 
			,CLIENT_TXT.DESCR AS CLIENT_TXT_DESCR 
			,CLIENT_TXT.CB AS CLIENT_TXT_CB 
			,CLIENT_TXT.DC AS CLIENT_TXT_DC 
			,CLIENT_TXT.MB AS CLIENT_TXT_MB 
			,CLIENT_TXT.DM AS CLIENT_TXT_DM 
			,CLIENT_TXT.TS AS CLIENT_TXT_TS 
		FROM CLIENT 
		INNER JOIN CLIENT_TXT 
			 ON CLIENT.CLIENT_ID = CLIENT_TXT.CLIENT_ID 
		INNER JOIN LG 
			 ON CLIENT_TXT.LG_ID = LG.LG_ID 
			INNER JOIN LG_TXT 
			 ON LG.LG_ID = LG_TXT.LG_ID 
		";
		if (isset($CLIENT_client_id))
			$this->db->addWhere("CLIENT.client_id", $CLIENT_client_id, DATATYPE::$int);

		$recordSet = parent::executeStmtSelect($sql);
		$this->db->clearWhere();
		return $this->db->recordSetGetAll_assoc($recordSet);

	}

	public function selectRecord_listbox($CLIENT_client_id=null)
	{

		$sql = "SELECT
			CLIENT.CLIENT_ID AS CLIENT_CLIENT_ID 
			,CLIENT.FULL_NAME AS CLIENT_FULL_NAME 
			,CLIENT.EMAIL_ADDRESS AS CLIENT_EMAIL_ADDRESS 
			,CLIENT.PASSWORD AS CLIENT_PASSWORD 
			,CLIENT.CONTACT_ID AS CLIENT_CONTACT_ID 
			,CLIENT.CLIENT_TYPE_ID AS CLIENT_CLIENT_TYPE_ID 
			,CLIENT_TXT.CLIENT_ID AS CLIENT_TXT_CLIENT_ID 
			,CLIENT_TXT.LG_ID AS CLIENT_TXT_LG_ID 
			,CLIENT_TXT.NAME AS CLIENT_TXT_NAME 
			,CLIENT_TXT.DESCR AS CLIENT_TXT_DESCR 
		FROM CLIENT 
		INNER JOIN CLIENT_TXT 
			 ON CLIENT.CLIENT_ID = CLIENT_TXT.CLIENT_ID 
		INNER JOIN LG 
			 ON CLIENT_TXT.LG_ID = LG.LG_ID 
			INNER JOIN LG_TXT 
			 ON LG.LG_ID = LG_TXT.LG_ID 
		";
		if (isset($CLIENT_client_id))
			$this->db->addWhere("CLIENT.client_id", $CLIENT_client_id, DATATYPE::$int);

		$recordSet = parent::executeStmtSelect($sql);
		$this->db->clearWhere();
		return $this->db->recordSetGetAll_assoc($recordSet);

	}

	private function setParameters($stmtType=1, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{

		$this->db->clearParameters();
		$this->db->addParameter("full_name", $CLIENT_full_name, DATATYPE::$varchar);
		$this->db->addParameter("email_address", $CLIENT_email_address, DATATYPE::$varchar);
		$this->db->addParameter("password", $CLIENT_password, DATATYPE::$varchar);
		$this->db->addParameter("contact_id", $CLIENT_contact_id, DATATYPE::$int);
		$this->db->addParameter("client_type_id", $CLIENT_client_type_id, DATATYPE::$int);


		parent::setStandardParameters($stmtType, $user_id);


	}

	private function setParametersUpdate($stmtType=1, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{

		$this->db->clearParameters();
		$this->db->addParameter("full_name", $CLIENT_full_name, DATATYPE::$varchar);
		$this->db->addParameter("email_address", $CLIENT_email_address, DATATYPE::$varchar);
		$this->db->addParameter("password", $CLIENT_password, DATATYPE::$varchar);
		$this->db->addParameter("contact_id", $CLIENT_contact_id, DATATYPE::$int);
		$this->db->addParameter("client_type_id", $CLIENT_client_type_id, DATATYPE::$int);


		parent::setStandardParameters($stmtType, $user_id);


	}

	public function insertRecord($CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{

		$stmtType = DBSTMT_TYPE::$insert;

		$valid = $this->validate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $CLIENT_client_id, $user_id);
		if ($valid)
		{
			$this->setParameters($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id);        
			return parent::executeStmt();
		}
		else
		{
			return parent::errProcessing();
		}
	}

	public function insertRecordByAssocArr($valArr,$user_id)
	{

		$CLIENT_full_name = $valArr['CLIENT_FULL_NAME'];
		$CLIENT_email_address = $valArr['CLIENT_EMAIL_ADDRESS'];
		$CLIENT_password = $valArr['CLIENT_PASSWORD'];
		$CLIENT_contact_id = $valArr['CLIENT_CONTACT_ID'];
		$CLIENT_client_type_id = $valArr['CLIENT_CLIENT_TYPE_ID'];



		$stmtType = DBSTMT_TYPE::$insert;

		$valid = $this->validate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $CLIENT_client_id, $user_id);
		if ($valid)
		{
			$this->setParameters($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id);        
			return parent::executeStmt();
		}
		else
		{
			return parent::errProcessing();
		}
	}

	public function updateRecord($CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{

		$stmtType = DBSTMT_TYPE::$update;

		$valid = $this->validate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id);
		if ($valid)
		{
			$this->setParametersUpdate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id); 
		if (isset($CLIENT_client_id))
			$this->db->addWhere("CLIENT.client_id", $CLIENT_client_id, DATATYPE::$int);
               
			return parent::executeStmtUpdate();
		}
		else
		{
			return parent::errProcessing();
		}
	}

	public function updateRecordByAssocArr($valArr,$user_id)
	{
		$CLIENT_client_id = $valArr['CLIENT_CLIENT_ID'];
		$CLIENT_full_name = $valArr['CLIENT_FULL_NAME'];
		$CLIENT_email_address = $valArr['CLIENT_EMAIL_ADDRESS'];
		$CLIENT_password = $valArr['CLIENT_PASSWORD'];
		$CLIENT_contact_id = $valArr['CLIENT_CONTACT_ID'];
		$CLIENT_client_type_id = $valArr['CLIENT_CLIENT_TYPE_ID'];


		$stmtType = DBSTMT_TYPE::$update;

		$valid = $this->validate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id);
		if ($valid)
		{
			$this->setParametersUpdate($stmtType, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id); 
		if (isset($CLIENT_client_id))
			$this->db->addWhere("CLIENT.client_id", $CLIENT_client_id, DATATYPE::$int);
               
			return parent::executeStmtUpdate();
		}
		else
		{
			return parent::errProcessing();
		}
	}

	protected function validate($stmtType=1, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{
		$this->valid->isInt($user_id, 1, "user_id");

		$this->valid->isAlpha($CLIENT_full_name, 1, "CLIENT_full_name");
		$this->valid->isAlpha($CLIENT_email_address, 1, "CLIENT_email_address");
		$this->valid->isAlpha($CLIENT_password, 1, "CLIENT_password");
		$this->valid->isInt($CLIENT_contact_id, 1, "CLIENT_contact_id");
		$this->valid->isInt($CLIENT_client_type_id, 1, "CLIENT_client_type_id");


		return $this->valid->VALID();
	}

	protected function validate_update($stmtType=1, $CLIENT_full_name, $CLIENT_email_address, $CLIENT_password, $CLIENT_contact_id, $CLIENT_client_type_id, $user_id)
	{
		$this->valid->isInt($user_id, 1, "user_id");
		$this->valid->isAlpha($CLIENT_full_name, 1, "CLIENT_full_name");
		$this->valid->isAlpha($CLIENT_email_address, 1, "CLIENT_email_address");
		$this->valid->isAlpha($CLIENT_password, 1, "CLIENT_password");
		$this->valid->isInt($CLIENT_contact_id, 1, "CLIENT_contact_id");
		$this->valid->isInt($CLIENT_client_type_id, 1, "CLIENT_client_type_id");


		return $this->valid->VALID();
	}

}
?>