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
 
 
class CACHE_ITS
{
    public static function guieGetCachedElement($id, $htmle_type)
    {  
        $fileName = CACHE_ITS::guieGetCacheFileName($id, $htmle_type);
        $dir = CONFIG_ADMINITS::$DIR_CACHE_TMPLT;
        $tmplt = FileIO::readFileContentsToVariable($dir.$fileName);
        return $tmplt;
    }
    
    public static function guieSetCachedElement($id, $html, $htmle_type)
    {
        $fileName = CACHE_ITS::guieGetCacheFileName($id, $htmle_type);
        $dirTmplt = CONFIG_ADMINITS::$DIR_CACHE_TMPLT;
        $dirTmpltBkp = CONFIG_ADMINITS::$DIR_CACHE_TMPLT_BKP;
        FileIO::backupFile($fileName, $dirTmplt, $dirTmpltBkp);
        FileIO::createFile($fileName, $html, $dirTmplt);            
    }
    
    public static function guieGetCacheFileName($id, $htmle_type)
    {
        switch($htmle_type)
        {
            case HTMLE::$frmListbox:
            return "tmplt_".strtoupper($id)."_list.html";
            break;
            case HTMLE::$frmListboxOption:
            return "tmplt_".strtoupper($id)."_listOptions.html";
            break;
            case HTMLE::$frmChk:
            return "tmplt_".strtoupper($id)."_chkboxOptions.html";
            break;            
            case HTMLE::$frmRadio:
            return "tmplt_".strtoupper($id)."_radioOptions.html";
            break;
            case HTMLE::$frmTxt:
            return "tmplt_".strtoupper($id)."_txt.html";
            break;
            case HTMLE::$frmTxta:
            return "tmplt_".strtoupper($id)."_txta.html";
            break;
            default:
            return "tmplt_".strtoupper($id).".html";            
        }
    }  

    public static function tmpltGetCachedTmplt($id, $tmpltType)
    {  
        $fileName = CACHE_ITS::tmpltGetCacheFileName($id, $tmpltType);
        $dir = CONFIG_ADMINITS::$DIR_CACHE_TMPLT;
        $tmplt = FileIO::readFileContentsToVariable($dir.$fileName);
        return $tmplt;
    }

    public static function tmpltSetCachedTmplt($id, $html, $tmpltType)
    {
        $fileName = CACHE_ITS::tmpltGetCacheFileName($id, $tmpltType);
        $dirTmplt = CONFIG_ADMINITS::$DIR_CACHE_TMPLT;
        $dirTmpltBkp = CONFIG_ADMINITS::$DIR_CACHE_TMPLT_BKP;
        FileIO::backupFile($fileName, $dirTmplt, $dirTmpltBkp);
        FileIO::createFile($fileName, $html, $dirTmplt);            
    }

    public static function tmpltGetCacheFileName($id, $tmpltType)
    {
        switch($tmpltType)
        {
            case TMPLT_TYPE::$frmCreate:
                return "tmplt_frm_".strtoupper($id)."_create.html";
                break;
            case TMPLT_TYPE::$frmEdit:
                return "tmplt_frm_".strtoupper($id)."_edit.html";
                break;
            case TMPLT_TYPE::$frmView:
                return "tmplt_frm_".strtoupper($id)."_view.html";
                break;
            default:
                return "tmplt_frm_".strtoupper($id).".html";
                break;
        }
    }
    
    public static function frmGetCachedFrm($id, $frmType)
    {  
        $fileName = CACHE_ITS::frmGetCacheFileName($id, $frmType);
        $dir = CONFIG_ADMINITS::$DIR_CACHE_FRM;
        $tmplt = FileIO::readFileContentsToVariable($dir.$fileName);
        return $tmplt;
    }

    public static function frmSetCachedFrm($id, $html, $frmType)
    {
        $fileName = CACHE_ITS::frmGetCacheFileName($id, $frmType);
        $dirFrm = CONFIG_ADMINITS::$DIR_CACHE_FRM;
        $dirFrmBkp = CONFIG_ADMINITS::$DIR_CACHE_FRM_BKP;
        FileIO::backupFile($fileName, $dirTmplt, $dirFrmBkp);
        FileIO::createFile($fileName, $html, $dirFrm);            
    }

    public static function frmGetCacheFileName($id, $frmType)
    {
        switch($frmType)
        {
            case FRM_TYPE::$frmCreate:
                return "frm_".strtoupper($id)."_create.html";
                break;
            case FRM_TYPE::$frmEdit:
                return "frm_".strtoupper($id)."_edit.html";
                break;
            case FRM_TYPE::$frmView:
                return "frm_".strtoupper($id)."_view.html";
                break;
            default:
                return "frm_".strtoupper($id).".html";
                break;
        }
    }        
}
 
class CACHE_SETTING_GUI
{
    public static $OFF = 1;
    public static $CACHED = 100;
    public static $TMPLT = 200; 
} 
  
?>