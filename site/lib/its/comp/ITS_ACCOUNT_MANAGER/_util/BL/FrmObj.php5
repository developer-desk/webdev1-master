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
 
 
abstract class FrmObj1
{
    protected $id;
    protected $frmType;
    protected $tmpltType;
    protected $cacheSetting;
    protected $tmpltSetting;
    protected $html;
    protected $tmplt;
    protected $cacheRefresh = false;
    protected $tmpltRefresh = false;
    
    protected $reqVals;
    protected $errMsgs;
    protected $tmpltPlcHldrsOn;
    
    
    //abstract public function genFrm();
    abstract protected function setDefaults();
    abstract protected function readInFrmValues();
    //abstract protected function readInRequestValues();
    abstract protected function setRequestValues($row);
    
    abstract protected function createFrm();
    abstract protected function createTmplt();
    abstract protected function setTmpltGuies($tmplt);
    abstract protected function setValues();
    abstract protected function setTmpltPlcHldrs();
    
    protected function __construct($id, $frmType, $cacheSetting=null, $tmpltSetting=null, $reqVals=null, $errMsgs=null) //fix1025
    {
        $this->id = $id;
        $this->frmType = $frmType;
        $this->tmpltType = $frmType;
        $cacheSetting = !isset($cacheSetting)?CACHE_SETTING_GUI::$CACHED:$cacheSetting;
        $this->cacheSetting = $cacheSetting;
        $tmpltSetting = !isset($tmpltSetting)?CACHE_SETTING_GUI::$TMPLT:$tmpltSetting;
        $this->tmpltSetting = $tmpltSetting;
        
        $this->reqVals = $reqVals;
        $this->errMsgs = $errMsgs;
    }
    
    public function readInRequestVars($varList)
    {
        $rows = 1; //for now hard coding 1  since grid forms are not yet needed
        REQUEST::readIn($varList, $rows);
        //for each frmValue readin REQUEST variable for each "row"
        //return array of arrays
            //note: array will only have one row unless its a multi-row/grid input
            //return array(array('var_name1'=>$value1, 'var_name2'=>$value2));
        return null;
    }    

    
    protected function genFrm()
    {
        if ($this->cacheSetting==CACHE_SETTING_GUI::$CACHED && $this->frmType!=FRM_TYPE::$frmEdit) //new
        {
            $html = $this->getCachedFrm();
            if(!isset($html) || $html==false || $this->cacheRefresh)
            {
                $html = $this->createFrm();
                $this->setCachedFrm($html);//cache element
            }                             
            ////$html = !isset($html)||$html==""?$this->createHtml():$html;           
            $this->html = $html;
            //return $html;        
        }
        else ////if ($this->cacheSetting==CACHE_SETTING_GUI::$OFF)
        {
            $this->html = $this->createFrm();
        }
        ////if (isset($val)) $this->setValue($val);
        //$this->setValues();
        return $this->html;
    }  
    
    protected function getTmplt()
    {
        ////if ($this->tmpltSetting==TMPLT_SETTING_GUI::$TMPLT) //fix1025
            $tmplt = $this->loadTmplt();
            
        if(!isset($tmplt) || $tmplt==false)
        {
            $tmplt = $this->createTmplt();
            $this->saveTmplt($tmplt);
        }   
                                  
        $this->tmplt = $tmplt;
        return $tmplt;
    } 
       
    protected function getCachedFrm()
    {  
        return CACHE_ITS::frmGetCachedFrm($this->id, $this->frmType);
    }    

    protected function setCachedFrm($html)
    {
        CACHE_ITS::frmSetCachedFrm($this->id, $html, $this->frmType);
    }
  
    protected function loadTmplt()
    {  
        return TMPLT_ITS::getTmplt($this->id, $this->tmpltType);
    }    

    protected function saveTmplt($html)
    {
        TMPLT_ITS::setTmplt($this->id, $html, $this->tmpltType);
    }


    /*

    public function genHtml()
    {
        $tmplt = $html = "";
        $tmplt = $this->getHtml();//gets tmplt from cache or creates it

        
        $row = 1;
        $this->setRequestValues($row-1); //row1
        $html .= $this->setValues($tmplt);
        return $html;    
    }   



    protected function getHtml()
    {
        if ($this->cacheSetting==CACHE_SETTING_GUI::$CACHED)
        {
            $html = $this->getCachedTmplt();
            if(!isset($html) || $html==false || $this->cacheRefresh)
            {
                $html = $this->createHtml();
                $this->setCachedTmplt($html);//cache element
            }                             
            ////$html = !isset($html)||$html==""?$this->createHtml():$html;           
            $this->html = $html;
            //return $html;        
        }
        else ////if ($this->cacheSetting==CACHE_SETTING_GUI::$OFF)
        {
            $this->html = $this->createHtml();
        }
        ////if (isset($val)) $this->setValue($val);
        //$this->setValues();
        return $this->html;
    }  
    */

    
    
    
/*
    protected function getTmplt()
    {
        if ($this->tmpltSetting==TMPLT_SETTING_GUI::$TMPLT)
        {
            $html = $this->loadTmplt();
            if(!isset($html) || $html==false || $this->tmpltRefresh)
            {
                $html = $this->createTmplt();
                $this->saveTmplt($html);//cache element
            }                             
            ////$html = !isset($html)||$html==""?$this->createHtml():$html;           
            $this->html = $html;
            //return $html;        
        }
        else ////if ($this->cacheSetting==CACHE_SETTING_GUI::$OFF)
        {
            $this->html = $this->createTmplt();
        }
        ////if (isset($val)) $this->setValue($val);
        //$this->setValues();
        return $this->html;
    }    
*/ 

    /*
    protected function getCachedTmplt()
    {  
        return CACHE_ITS::tmpltGetCachedTmplt($this->id, $this->tmpltType);
    }    

    protected function setCachedTmplt($html)
    {
        CACHE_ITS::tmpltSetCachedTmplt($this->id, $html, $this->tmpltType);
    }
    */
}  
?>