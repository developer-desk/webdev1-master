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
 
 
class MYACCOUNT_CREATE_PL
{
    public static function getCreateAccountPage($client_email_address, $client_email_address_reentry, $client_full_name, $errmsg)
    {

        $dataRow = array();
        $dataRow['CLIENT_EMAIL_ADDRESS'] = $client_email_address;
        $dataRow['CLIENT_EMAIL_ADDRESS_REENTRY'] = $client_email_address_reentry;
        $dataRow['CLIENT_FULL_NAME'] = $client_full_name;
        $dataRow['ERRMSG'] = $errmsg;
        $dataTable = [$dataRow];

        $tmpltSignInWdgt = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WDGT_TMPLT_CREATE);
        $tmpltWebpg = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WEBPG_TMPLT);
        $webpg = TMPLT_ITS::utilSetWdgt($tmpltWebpg, $tmpltSignInWdgt, "MAIN");
        $webpg = TMPLT_ITS::setDataPlaceHolders($webpg, $dataTable);
        $webpg = TMPLT_ITS::setLbls($webpg);
        $webpg = TMPLT_ITS::setLinks($webpg);
        return $webpg;
    }

    public static function getCreateAccountSuccessfulPage($client_full_name)
    {

        $dataRow = array();
        $dataRow['CLIENT_FULL_NAME'] = $client_full_name;
        $dataTable = [$dataRow];

        $tmpltWdgt = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WDGT_TMPLT_CREATE_ACCNT_SUCCESSFUL);
        $tmpltWebpg = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WEBPG_TMPLT);
        $webpg = TMPLT_ITS::utilSetWdgt($tmpltWebpg, $tmpltWdgt, "MAIN");
        $webpg = TMPLT_ITS::setDataPlaceHolders($webpg, $dataTable);
        $webpg = TMPLT_ITS::setLbls($webpg);
        $webpg = TMPLT_ITS::setLinks($webpg);
        return $webpg;
    }
    

}
?>