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
        $self = self::GetInstance();
        $fullPath .= ($fullPath[strlen($fullPath)-1] != "/") ? "/" : "";
        $self->dir_root = $fullPath;        
        $self->dir_tmplt = $self->dir_root.$self->dir_tmplt;
    }

    public static function setTemplateDir($fullPath)
    {
        $self = self::GetInstance();
        $fullPath .= ($fullPath[strlen($fullPath)-1] != "/") ? "/" : "";
        $self->dir_tmplt = $fullPath;
    }    
    
    public static function getTmplt($id, $tmpltType)
    {  
        $fileName = TMPLT_ITS::getFileName($id, $tmpltType);
        $dir = CONFIG_ADMINITS::$DIR_TMPLT;
        $tmplt = FileIO::readFileContentsToVariable($dir.$fileName);
        return $tmplt;
    }
    public static function setTmplt($id, $html, $tmpltType)
    {
        $fileName = TMPLT_ITS::getFileName($id, $tmpltType);
        $dirTmplt = CONFIG_ADMINITS::$DIR_TMPLT;
        $dirTmpltBkp = CONFIG_ADMINITS::$DIR_TMPLT_BKP;
        FileIO::backupFile($fileName, $dirTmplt, $dirTmpltBkp);
        FileIO::createFile($fileName, $html, $dirTmplt);            
    }
    public static function getFileName($id, $tmpltType)
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
            case TMPLT_TYPE::$webpg:
                return "tmplt_webpg_".strtoupper($id).".html";
                break;
            case TMPLT_TYPE::$wdgt:
                return "tmplt_wdgt_".strtoupper($id).".html";
                break;
            default:
                return "tmplt_frm_".strtoupper($id).".html";
                break;
        }
    }
   /* 
    public static function utilGuieReplacePlcHldr($id, $guieHtml, $tmplt)
    {
        $p1 = "<!--%guie_$id"."-->\n";
        $p2 = "<!--$id"."_guie%-->\n";
        $tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        return $tmplt;   
    }
    public static function utilGuieAddPlcHldr($id, $guieHtml)
    {
        $p1 = "<!--%guie_$id"."-->\n";
        $p2 = "<!--$id"."_guie%-->\n";
        return $p1.$guieHtml.$p2;
    }
    public static function utilWdgtReplacePlcHldr($wdgtType, $id, $contentToAdd, $tmplt)
    {   
        $uid = WDGT_TYPE::__getWdgtTypeUID($wdgtType);
        $p1 = "<!--%wdgt_$uid"."-->\n";
        $p2 = "<!--$uid"."_wdgt%-->\n";
        $tmplt = TMPLT_ITS::plcHldrsReplace($p1, $p2, $contentToAdd, $tmplt);// preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        return $tmplt;   
    }
    public static function utilSetWdgt($uid, $contentToAdd, $tmplt)
    {   
        $p1 = "<!--%wdgt_$uid"."-->\n";
        $p2 = "<!--$uid"."_wdgt%-->\n";
        $tmplt = TMPLT_ITS::plcHldrsReplace($p1, $p2, $contentToAdd, $tmplt);// preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        return $tmplt;   
    }
    */
    public static function utilSetWdgt($webpgTmplt, $wdgt, $wgtUID) /*USED*/
    {       
        $p1 = "<!--%wdgt_"."$wgtUID-->";
        $p2 = "<!--$wgtUID"."_wdgt%-->";
        
        //$tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        
        //return preg_replace("/$p1([.\s\S])*$p2/i", $wdgt, $webpgTmplt); 
        $html = preg_replace("/$p1([.\s])*$p2/i", $wdgt, $webpgTmplt);
        return $html;
    }     

    public static function setLinks($html, $dataRows=null)
    {   
        $plcHldrs = self::utilGetPlcHldrsLnk($html);
        $lnkValues = $dataRows;
        if ($lnkValues==null)
        {
            foreach($plcHldrs as $plcHldr)
            {
                $key = str_ireplace("%", "", str_ireplace("%lnk_", "", $plcHldr));
                $lnkValues[$key] = LNK::get($key);           
            }
            $lnkValues = [$lnkValues];                        
        }
        return self::setPlcHldrsLnk($html, $plcHldrs, $lnkValues);
    }    
    
    public static function setLbls($html, $dataRows=null)
    {   
        $plcHldrs = self::utilGetPlcHldrsLbl($html);
        $lblValues = $dataRows;
        if ($lblValues==null)
        {
            foreach($plcHldrs as $plcHldr)
            {
                $key = str_ireplace("%", "", str_ireplace("%lbl_", "", $plcHldr));
                $lblValues[$key] = TEXT::get($key);           
            }
            $lblValues = [$lblValues];            
        }
        return self::setPlcHldrsLbl($html, $plcHldrs, $lblValues);
    }
    
    public static function utilGetPlcHldrsLbl($html)
    {       
        return self::utilGetPlcHldrs($html, "lbl");
    }     
    
    public static function utilGetPlcHldrsLnk($html)
    {       
        return self::utilGetPlcHldrs($html, "lnk");
    }     
    
    public static function utilGetPlcHldrsData($html)
    {       
        return self::utilGetPlcHldrs($html, "data");
    }     
    
    private static function utilGetPlcHldrs($html, $tag)
    {       
        $plceHoldrs = array();
        $p1 = "%".$tag."_";
        $p2 = "%";
        
        //$tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        
        preg_match_all("/$p1([a-zA-z0-9]+)$p2/i", $html, $plceHoldrs);       
        return $plceHoldrs[0];
    }     
    
    public static function setDataPlaceHolders($html, $dataValues)
    {
        $plcHldrs = self::utilGetPlcHldrs($html, "data");
        $html = self::setPlcHldrsData($html, $plcHldrs, $dataValues);
        return $html;
    }

    private static function setPlcHldrsLnk($tmplt, $plcHldrs, $data)
    {
        return self::setPlcHldrs($tmplt, $plcHldrs, $data, "lnk");       
    }    
    
    private static function setPlcHldrsLbl($tmplt, $plcHldrs, $data)
    {
        return self::setPlcHldrs($tmplt, $plcHldrs, $data, "lbl");       
    }    
    
    private static function setPlcHldrsData($tmplt, $plcHldrs, $data)
    {
        return self::setPlcHldrs($tmplt, $plcHldrs, $data, "data");       
    }    
    
    private static function setPlcHldrs($tmplt, $plcHldrs, $data, $tag)
    {
        $html = "";
        foreach($data as $dataRow)
        {              
            $html_row = $tmplt;
            foreach($plcHldrs as $plcHldr)
            {  
                $colName = str_ireplace("%$tag"."_", "", $plcHldr);
                $colName = strtoupper(str_ireplace("%", "", $colName));
                //echo "here plcHldr:$plcHldr , col: $colName";
                $val = isset($dataRow[$colName]) ? $dataRow[$colName] : "";
                $html_row  = str_ireplace($plcHldr, $val, $html_row);
            }
            $html .= $html_row;
        } 
        return $html;       
    }    
    
    /*
    private static function plcHldrsReplace($p1, $p2, $contentToAdd, $tmplt)
    {
        $tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $contentToAdd, $tmpltToAddTo);
        return $tmplt;
    }
    */

}

class WDGT
{
    public static $HEADER = 1;
    public static $HOMEFEATURED = 100;
    public static $BESTSELLER = 2;
    public static $BUNDLES = 3;
    public static $FEATURED = 4;
    public static $HISTORY = 5;
    public static function __getWdgtUID($wdgtId)
    {
        switch($wdgtId)
        {
            case WDGT_TYPE::$HEADER:
                return "HEADER";
                break;
            case WDGT_TYPE::$HOMEFEATURED:
                return "HOMEFEATURED";
                break;
            case WDGT_TYPE::$BESTSELLER:
                return "BEST";
                break;
            case WDGT_TYPE::$BUNDLES:
                return "BUNDLES";
                break;
            case WDGT_TYPE::$FEATURED:
                return "FEATURED";
                break;
            case WDGT_TYPE::$HISTORY:
                return "HISTORY";
                break;
            default:
                return "";
                break;
        }
    }
    public static function __getWdgtTypeUID($wdgtUID)
    {
        switch($wdgtUID) 
        {
            case "HEADER":
                return "HEADER";
                break;
            case "SEARCH":
                return "SEARCH";
                break;
            case "HOMEBANNER":
                return "HOMEBANNER";
                break;
            case "HOMECATEGORIES":
                return "HOMECATEGORIES";
                break;
            case "HOMEFEATURED":
                return "HOMEFEATURED";
                break;
            case "HOMETOPCHOICES":
                return "HOMETOPCHOICES";
                break;
            default:
                return "TYPE_NOT_FOUND";
                break;
        }
    }    
    
    private static function __getWdgtTypeUID_old($wdgtId)
    {
        switch($wdgtId)
        {
            case WDGT::$HEADER:
                return WDGT_TYPE::__getWdgtTypeUID(WDGT_TYPE::$HEADER);
                break;
            case WDGT::$BESTSELLER:
                return WDGT_TYPE::__getWdgtTypeUID(WDGT_TYPE::$BEST);
                break;
            case WDGT::$BUNDLES:
                return WDGT_TYPE::__getWdgtTypeUID(WDGT_TYPE::$BUNDLES);
                break;
            case WDGT::$FEATURED:
                return WDGT_TYPE::__getWdgtTypeUID(WDGT_TYPE::$FEATURED);
                break;
            case WDGT::$HISTORY:
                return WDGT_TYPE::__getWdgtTypeUID(WDGT_TYPE::$HISTORY);
                break;
            default:
                return "";
                break;
        }
    }
}
class WDGT_TYPE
{
    public static $HEADER = 1;
    public static $BESTSELLER = 2;
    public static $BUNDLES = 3;
    public static $FEATURED = 4;
    public static $HISTORY = 5;
    public static $HOMEFEATURED = 6;
    public static $HOMETOPCHOICES = 7;
    public static function __getWdgtTypeUID($wdgtType)
    { 
        switch($wdgtType)
        {
            case WDGT_TYPE::$HEADER:
                return "HEADER";
                break;
            case WDGT_TYPE::$BESTSELLER:
                return "BEST";
                break;
            case WDGT_TYPE::$BUNDLES:
                return "BUNDLES";
                break;
            case WDGT_TYPE::$FEATURED:
                return "FEATURED";
                break;
            case WDGT_TYPE::$HISTORY:
                return "HISTORY";
                break;
            case WDGT_TYPE::$HOMEFEATURED:
                return "HOMEFEATURED";
                break;
            case WDGT_TYPE::$HOMETOPCHOICES:
                return "HOMETOPCHOICES";
                break;
            default:
                return "";
                break;
        }
    }
}
class WEBPG_TYPE
{
    public static $HOMEPG = 1;
    public static $CATEGORYPG = 2;
    public static $PRODUCTDETAILPG = 3;
    public static $SRCHRSLTSPG = 4;
    public static function __getWEBPGUID($wdgtType)
    {
        switch($wdgtType)
        {
            case WEBPG_TYPE::$HOMEPG:
                return "HOMEPG";
                break;
            case WEBPG_TYPE::$CATEGORYPG:
                return "CATEGORYPG";
                break;
            case WEBPG_TYPE::$PRODUCTDETAILPG:
                return "PRODUCTDETAILPG";
                break;
            case WEBPG_TYPE::$SRCHRSLTSPG:
                return "SRCHRSLTSPG";
                break;
            default:
                return "";
                break;
        }
    }
}
 
class TMPLT_SETTING_GUI
{
    public static $OFF = 0;
    ////public static $CACHED = 100;
    public static $TMPLT = 200; 
} 
class PROCESS_TMPLT
{
    public function process($tmpltUID)
    {
        //load tmplt
        $fileName = TMPLT_ITS::getFileName($tmpltUID, TMPLT_TYPE::$webpg);
        $dir = CONFIG_ADMINITS::$DIR_TMPLT_WEBPG;
        $tmplt = FileIO::readFileContentsToVariable($dir.$fileName);
        //decipher list of wdgts
        //load in wdgt tmplts
        //read in wdgt lbls and links
        //replace lbls and lnks
        //extract repeater
        //readin data
        //foreach data row replace repeater labels
        
    }
}  
class TMPLT_UID_WEBPG
{
    public static $HOMEPG = "HMPG";
    public static $CATEGORYPG = "CATEGORY";    
}
?>