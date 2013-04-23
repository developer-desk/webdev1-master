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
 
 
class MYACCOUNT_SIGNIN_PL
{
    public static function getSignInPage($email_address, $checked1, $checked2, $errMsg)
    {

        $dataRow = array();
        $dataRow['EMAIL_ADDRESS'] = $email_address;
        $dataRow['CHECKED1'] = $checked1;
        $dataRow['CHECKED2'] = $checked2;
        $dataRow['ERRMSG'] = $errMsg;
        $dataTable = [$dataRow];

        $tmpltWdgt = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WDGT_TMPLT_SIGNIN);
        $tmpltWebpg = FileIO::readFileContentsToVariable(ITS_ACCOUNT_MANAGER_CONFIG::$DIR_TMPLT.ITS_ACCOUNT_MANAGER_CONFIG::$FILENAME_WEBPG_TMPLT);
        $webpg = TMPLT_ITS::utilSetWdgt($tmpltWebpg, $tmpltWdgt, "MAIN");
        $webpg = TMPLT_ITS::setDataPlaceHolders($webpg, $dataTable);
        $webpg = TMPLT_ITS::setLbls($webpg);
        $webpg = TMPLT_ITS::setLinks($webpg);
        return $webpg;
    }
    

}
?>