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
 
 

class TAX
{
    private $rate;
    private static $instance;

    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new TAX();       
        } 
        return self::$instance;
    }    
    
    private function __construct()
    {
        $this->rate = array();
        $this->rate['GST'] = 5;
        $this->rate['QC']['PST']  = 7.5;
        $this->rate['ON']['PST']  = 8.0;
        $this->rate['AB']['PST']  = 0;
        $this->rate['SK']['PST']  = 5;
        $this->rate['MN']['PST']  = 7;
        $this->rate['PE']['PST']  = 10;
        $this->rate['NB']['PST']  = 13;
        $this->rate['NS']['PST']  = 13;
        $this->rate['NF']['PST']  = 13;
        $this->rate['NT']['PST']  = 0;
        $this->rate['NU']['PST']  = 0;

        $this->rate['QC']['TXONTX'] = false;
        $this->rate['ON']['TXONTX']  = true;
        $this->rate['AB']['TXONTX']  = false;
        $this->rate['SK']['TXONTX']  = false;
        $this->rate['MN']['TXONTX']  = false;
        $this->rate['PE']['TXONTX']  = true;
        $this->rate['NB']['TXONTX']  = false;
        $this->rate['NS']['TXONTX']  = false;
        $this->rate['NF']['TXONTX']  = false;
        $this->rate['NT']['TXONTX']  = false;
        $this->rate['NU']['TXONTX']  = false;
    }
    
    public static function gst()
    {
       $self = self::getInstance();
       return $self->rate['GST']/100;
        
    }

    public static function pst($provCode)
    {
       $self = self::getInstance();
       return $self->rate[$provCode]['PST']/100;
    }
    
    public static function txontx($provCode)
    {
       $self = self::getInstance();
       return $self->rate[$provCode]['TXONTX'];
    }

    
} 


class PAYMENT_METHOD
{
    public static $CREDIT_CARD = "CC";
    public static $COD = "COD";
}
?>