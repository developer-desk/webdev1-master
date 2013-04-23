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
 
 
  define("ITS_ROOT_DIR", $_SERVER['DOCUMENT_ROOT']."/");
  
  include_once ITS_ROOT_DIR."lib/its/comp/ITS_ACCOUNT_MANAGER/config.php";  
  include_once ITS_ROOT_DIR."lib/its/util/GUI/TMPLT_ITS.php";  
  TMPLT_ITS::setRootDir(ITS_ROOT_DIR);
?>