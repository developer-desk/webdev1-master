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
 
 
class TMPLT_ITS
{
    private $dir_root;
    private $dir_tmplt = "_tmplt/";
    private $dir_override;
    
    private static $instance;
    
    public static function init()
    {
        self::GetInstance();
    }
    
    private function __construct()
    {
    }
    
    private static function GetInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new TMPLT_ITS();
            
        return self::$instance;
    }
    
    public static function setRootDir($fullPath)
    {
        $self = GetInstance();
        $self->dir_root = $fullPath;
    }

    public static function overrideTemplateDirectory($fullPath)
    {
        $self = GetInstance();
        $self->dir_override = $fullPath;
    }

}
TMPLT_ITS:init();

/*  THIS WOULD BE SET IN THE MAIN CONFIG OF THE WEBSITE   */
TMPLT_ITS::setRootDir(CONFIG::$ROOT_DIR);//mandatory
//TMPLT_ITS::setRootDir("d:/gmop/dev/");//mandatory
//FOr special casses: TMPLT_ITS::overrideTemplateDirectory($dirFullPath);

$tmpltId = "gmop1";
$tmpltType = TMPLT_ITS_TYPE::$webpg;
$dataValues = array();
$html = TMPLT_ITS::set($tmpltId, $tmpltType, $dataValues);

$tmpltIdWdgt = "wordImportSignin";
$tmpltTypeWdgt = TMPLT_ITS_TYPE::$wdgt;
$dataValuesWdgt = array();
$wdgtHtml = TMPLT_ITS::set($tmpltIdWdgt, $tmpltTypeWdgt, $dataValuesWdgt);

$html = TMPLT_ITS::setWdgt($html, $wdgtHtml, $tmpltIdWdgt);


class GMOP_ACCNT_SIGNIN
{
    private $webpg_tmplt_id;//later can allow this to be changed through a function
    private $wdgt_tmplt_id;//later can allow this to be changed through a function
    
    private function __construct()
    {
        if (!isset($webpg_tmplt_id)) $this->webpg_tmplt_id = GMOP_TMPLT_CONFIG::$WBPG_TMPLT_ID_GMOP;
        if (!isset($wdgt_tmplt_id)) $this->wdgt_tmplt_id = GMOP_TMPLT_CONFIG::$WDGT_TMPLT_ID_GMOP_SIGNIN;
    }   
     
    private static function process()
    {
        $default_email = BL::getDefaultEmail();
        return PL::getSigninPage(self::$webpg_tmplt_id, self::$wdgt_tmplt_id, $default_email);
    }   
    
    public static function view()
    {
        return GMOP_ACCNT_SIGNIN::process();
    }        
}

class GMOP_ACCNT_SIGNIN_SUBMIT
{
    
    private function __construct()
    {
        if (!isset($webpg_tmplt_id)) $this->webpg_tmplt_id = GMOP_TMPLT_CONFIG::$WBPG_TMPLT_ID_GMOP;
        if (!isset($wdgt_tmplt_id)) $this->wdgt_tmplt_id = GMOP_TMPLT_CONFIG::$WDGT_TMPLT_ID_GMOP_SIGNIN;
    }   
     
    private static function process()
    {
        $result = BL::authenticateSignIn();
        if ($result->valid)
        {
            $url = BL::getRedirectAfterSignIn();
            UTIL::redirect($url);
        }
        else
            UTIL::redirect($SIGIN_LINK, $result);
        
    }   
    
    public static function submit()
    {
        return GMOP_ACCNT_SIGNIN_SUBMIT::process();
    }        
}

?>