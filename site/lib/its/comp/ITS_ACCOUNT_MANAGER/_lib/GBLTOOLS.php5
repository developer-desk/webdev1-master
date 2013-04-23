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
 
 
class WEBPG_BUILDER
{
    public static function utilGetRepeater($wdgt)
    {       
        $plceHoldrs = array();
        $p1 = "<!--%rpt_-->";
        $p2 = "<!--_rpt%-->";
        
        //$tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        
        preg_match_all("/$p1([.\s\S]*)$p2/i", $wdgt, $plceHoldrs);       
        return $plceHoldrs[0];
    } 
    
    public static function utilSetRepeater($html_rows, $wdgt, $rptrIndex="")
    {       
        $plceHoldrs = array();
        $p1 = "<!--%rpt$rptrIndex"."_-->";
        $p2 = "<!--_rpt$rptrIndex%-->";
        
        
        //$html = preg_replace("/$p1([.\s\S])*$p2/i", $html_rows, $wdgt);       
        $html = preg_replace("/$p1([.\s])*$p2/i", $html_rows, $wdgt);       
        return $html;
    } 
    
    
    public static function _utilRepeaterGetDbCols($rptr)
    {
        $dataPlcHldrs = WEBPG_BUILDER::utilRepeaterGetPlcHldrs($rptr);  
        if (is_array($dataPlcHldrs) && isset($dataPlcHldrs[0]))
        {
            $dbCols = array();
            foreach($dataPlcHldrs as $plcHldr)
            {
                $arr = array();
                $arr['dataPlcHldr'] = $plcHldr;
                $arr['dbColName'] = WEBPG_BUILDER::convertDataPlcHldr2DbCol($plcHldr);
                DBUG::OUT("dataPlcHldr:".$arr['dataPlcHldr'].", dbColName:".$arr['dbColName']);                            
                $dbCols[] = $arr;
            } 
            return $dbCols;            
        }   
        else
            return null;     
    }    
    
    public static function utilRepeaterGetPlcHldrs($rptr)
    {       
        $plceHoldrs = array();
        $p1 = "%data_";
        $p2 = "%";
        
        //$tmplt = preg_replace("/$p1([.\s\S]*)$p2/", $guieHtml, $tmplt);
        
        preg_match_all("/$p1([a-zA-z0-9]+)$p2/i", $rptr, $plceHoldrs);       
        return $plceHoldrs[0];
    }     
    
    private static function convertDataPlcHldr2DbCol($plcHldr)
    {
        return strtoupper(str_ireplace("%","",str_ireplace("%data_", "", $plcHldr)));
    }

    public static function _utilRepeaterGetRprtRow($dbCols, $rptr, $productRow)
    {
        $rptrValues = array();
        foreach($dbCols as $plcHldr)
        {
            //DBUG::OUT("**dbCols:".$this->printArr2($plcHldr));
            $arr=array();
            $arr['PLCHLDR'] = $plcHldr['dataPlcHldr'];
            $arr['NAME'] = $productRow[$plcHldr['dbColName']];
            if ($webpg_type_id!=10 && $plcHldr['dbColName']=='GNS_TXT_TEASER')
              $arr['NAME'] = substr($arr['NAME'],0,200).'...';
            //echo "test: ".$plcHldr['dbColName']; 
            if (($plcHldr['dbColName']=='SHOP_GNS_PRICE' || $plcHldr['dbColName']=='SHOP_GNS_PRICE_ORIGINAL') && trim($arr['NAME'])!="")
            {
              $arr['NAME'] = TOOLS::valM($arr['NAME'], 1);
            }                                  
            $rptrValues[] = $arr;
            //$rptrValues[] = array($plcHldr['dataPlcHldr'], $productRow[$plcHldr['dbColName']]);
        }
        //DBUG::OUT("**rptrValues:".$this->printArr2($rptrValues)); 
        $rptrRow = WEBPG_BUILDER::setPlcHldrs($rptr, $rptrValues, 0, 1); //index not yet implemented  
        DBUG::OUT("**rptrRow");          
        DBUG::OUT($rptrRow);
        return $rptrRow;
    }     

    private static function setPlcHldrs($tmplt, $vals, $targetIndex, $valIndex)
    {
        foreach($vals as $valArr)
        {
            dbug::OUT("target:".$valArr['PLCHLDR']." val:".$valArr['NAME']);
            //$tmplt = str_ireplace($valArr[$targetIndex], $valArr[$valIndex], $tmplt);   
            $tmplt = str_ireplace($valArr['PLCHLDR'], $valArr['NAME'], $tmplt);   
        }
        
        //DBUG::OUT("tmplt: $tmplt");
        return $tmplt;
    }
    
    
}
    
    

  
?>