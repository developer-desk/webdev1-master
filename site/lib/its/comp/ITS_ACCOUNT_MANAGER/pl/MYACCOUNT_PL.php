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
 
 
class MYACCOUNT_PL
{
    public static function getMyAccountPage($client_full_name)
    {

        $dataRow = array();
        $dataRow['CLIENT_FULL_NAME'] = $client_full_name;
        $dataTable = [$dataRow];

        $tmpltWdgt = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WDGT_TMPLT_MYACCOUNT);
        $tmpltWebpg = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WEBPG_TMPLT);
        $webpg = TMPLT_ITS::utilSetWdgt($tmpltWebpg, $tmpltWdgt, "MAIN");
        $webpg = TMPLT_ITS::setDataPlaceHolders($webpg, $dataTable);
        $webpg = TMPLT_ITS::setLbls($webpg);
        $webpg = TMPLT_ITS::setLinks($webpg);
        return $webpg;
    }
	
	public static function getSigninWdgt($client_full_name)
	{
	
    $tmpltWdgt = FileIO::readFileContentsToVariable($FILE_WDGT_TMPLT_SIGNIN_WDGT::$DIR_TMPLT.$FILE_WDGT_TMPLT_SIGNIN_WDGT::$FILENAME_WDGT_TMPLT_MYACCOUNT);
	$tmpltWdgt = FileIO::readFileContentsToVariable(...$FILE_WDGT_TMPLT_SIGNIN_WDGT);
    $ tmpltWdgt = TMPLT_ITS::setLbls($tmpltWdgt);
    $ tmpltWdgt = TMPLT_ITS::setLinks($tmpltWdgt);
	return $tmpltWdgt;
	}
	
    public static function getLoggedInWdgt()
	{
	$dataTable=string();
	$dataTable['first_name'] = $client_full_name;
	$dataTable['last_name'] = $client_full_name;
	$dataTable['user_id'] = $user_id;
    $tmpltWdgt = FileIO::readFileContentsToVariable($FILE_WDGT_TMPLT_LOGGEDIN_WDGT::$DIR_TMPLT.$FILE_WDGT_TMPLT_LOGGEDIN_WDGT::$FILENAME_WDGT_TMPLT_MYACCOUNT);
	$tmpltWdgt = FileIO::readFileContentsToVariable($FILE_WDGT_TMPLT_LOGGEDIN_WDGT);
    $tmpltWdgt = TMPLT_ITS::setDataPlaceHolders($tmpltWdgt, $dataTable);
    $tmpltWdgt = TMPLT_ITS::setLbls($tmpltWdgt);
    $tmpltWdgt = TMPLT_ITS::setLinks($tmpltWdgt);
	return $tmpltWdgt;
	}
	
}
?>