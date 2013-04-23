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
 
 
class UTIL
{
    public static $SYSCOLS = array('CB','DC','MB','DM','TS','ROOT','LVL','KIDZ');
    ////public static $SYSCOLS = array('CB','DC','MB','DM','TS','STATUS_ID');
    
    public static function within($str, $list)
    {
       $match = false;
       foreach($list as $listItm)
       {
         if (strcasecmp($str, $listItm) == 0)
         {
            return true;
         }
       }
       return $match;
    }
    public static function isNull($val, $default)
    {
        if (!isset($val))
            return $default;
        else
            return $val;
    }
    
    public static function lid_setLID($tmplt)
    {
        $LID = GBL::LID(); 
        $html = str_ireplace("%LID%", $LID, $tmplt);
        return $html;
    }

    public static function tmplt_setRow($tmplt, $row)
    {
        $tmplt = str_ireplace("%ROW%", $row, $tmplt);
        return $tmplt;
    }

    public static function tmplt_setStnrdPlcHldrs($tmplt, $row=1)
    {
        //$tmplt = UTIL::lid_setLID($tmplt);
        $tmplt = UTIL::tmplt_setRow($tmplt, $row);
        return $tmplt;        
    }
    
    public static function tmplt_stripHtml_getBodyTagContent($html)
    {
        $matches[1] = null;
        preg_match("/<body\s*[^>]*>(.*)<\/body>/is", $html, $matches);
        $body = $matches[1];
        return $body;        
    }
    
    public static function tmpltconv_getFormName($tblName)
    {
        
        //return "frm".strtoupper($tblName)."%LID%";
        return "frm".strtoupper($tblName);
    }    

    public static function tmpltconv_getFormDivName($tblName)
    {
        
        //return "frm".strtoupper($tblName)."%LID%";
        //return "frm".strtoupper($tblName);
        return "frmDiv";
    }    

  
    
}

class HEADERS
{
    public static function setHeaderXML()
    {   
   
        if (stristr($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml"))
            header("Content-type: application/xhtml+xml;charset=utf-8");
        else
            header("Content-type: text/xml;charset=utf-8");    
    }
}

class STR
{
    public static function analyzeString($str)
    {
        $data = $str;

        foreach (count_chars($data, 1) as $i => $val) {
           echo "There were $val instance(s) of \"" , chr($i) , "\" in the string.<br>";
        }
        
    }

    public static function chk_Tab_Newline($str)
    {
        echo "\n: ". preg_match("/\n/",$str)."<br>";
        echo "tab: ". preg_match("/      /",$str)."<br>";        
    }
}
  
?>