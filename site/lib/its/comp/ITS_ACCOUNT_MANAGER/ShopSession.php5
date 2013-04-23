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
 
                                                           
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1            
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past    
//this is more for the root of the cart
define("ROOT_DIR_WEB", CONFIG::$WEB_ROOT);
define("ROOT_WEB", "/");
//define("ROOT_DIR_WEB", "/adminITS/_src/");
define("WEBSITE_ID", "ITSDEV");
define("HOMELNK", "http://www.infinite-ts.com/");
define("HOMELNK_REL", "/");
define("COMPANY", "Infinite Tech Solutions Inc.");
define("PRODIMGLNK", "images/store/products/");

////$websiteId = "TTT";

class ShopCookie
{
    public static function init()
    {                                                       
        if (!ShopCookie::cookieExists('TRKR_ID'))
            ShopCookie::setCookieId();
        if (!ShopCookie::cookieExists('WEBSITE_ID'))
            ShopCookie::setCookieWebsiteId();                
    }
    
    private static function cookieExists($name)
    {
        
        if (isset($_COOKIE[$name])&&$_COOKIE[$name]!="")
            return true;
        else
            return false;   
    }
    
    private static function setCookieId()
    {
        $cookieVal = ShopCookie::_utilGetNextCookieVal();
        $cookieName = "TRKR_ID";
        $expiration = ShopCookie::_utilGetExpiration();
        setcookie($cookieName, $cookieVal, $expiration);
    }
    
    private static function setCookieWebsiteId()
    {
        $cookieName = "WEBSITE_ID";
        $cookieVal = WEBSITE_ID;
        $expiration = ShopCookie::_utilGetExpiration();
        setcookie($cookieName, $cookieVal, $expiration);
    }

    private static function _utilGetExpiration()
    {
        $expiration = time()+60*60*24*29.5*12*2;//expires after 2 years  
        return $expiration;       
    }

    private static function _utilGetNextCookieVal()
    {
        //add:dbdal call to get cookie val
        return 1;
    }
    
    public static function setCartCookies($numItms, $cartValue)
    {
        $expiration = ShopCookie::_utilGetExpiration();
        $cookieName = "CART_ITEMS";
        $cookieVal = $numItms;
        setcookie($cookieName, $cookieVal, $expiration,"/");        
        $cookieName = "CART_VALUE";
        $cookieVal = $cartValue;
        setcookie($cookieName, $cookieVal, $expiration,"/");        
    }
    
    public static function deleteCartCookies()
    {
        $expiration = time()-(60*60*24*29.5*12*2);
        $cookieName = "CART_ITEMS";
        $cookieVal = $numItms;
        setcookie($cookieName, $cookieVal, $expiration,"/");        
        $cookieName = "CART_VALUE";
        $cookieVal = $cartValue;
        setcookie($cookieName, $cookieVal, $expiration,"/");        
    }

    public static function deleteLastViewedCookies()
    {   
        $expiration = time()-(60*60*24*29.5*12*2);
        $cookieName = "BROWSINGHIST";
        $cookieVal = null;
        setcookie($cookieName, $cookieVal, $expiration, "/");                
        $cookieName = "BROWSINGHIST_GNSLIST";
        $cookieVal = null;
        setcookie($cookieName, $cookieVal, $expiration, "/");                
    }

    
}

class ShopSession
{
    private $LG_ID;
    private static $instance = null;
    private $cartCartID;
    private $clientId;
    
    private $emailAddress;
    private $password;
    
    private $errMsgs;
    private $errMsg;
    private $err;
    private $errFlag;
    private $ERR_FLAG_TRAN;
    private $errCartItmsSoldOut;
    
    private $flgPromoCodeApplied;
    private $flgPromoCodeInvalid;
    private $flgPromoFreeShipping;
    private $flgCartUpdated; 
    private $flgTranGiftCardUsed;
    private $flgTranCreditCardUsed;  
    private $flgShipDiscounted; 
    private $flgShipFree; 
    private $flgPaymentMethod; 
    private $PromoCode;
    private $flgCartItmSoldOut;
 
    private function __construct()
    {
        $this->LG_ID = 1;
        $this->errFlag = null;
        $this->ERR_FLAG_TRAN = null;
        $this->flgPromoCodeApplied = false;
        $this->flgPromoCodeInvalid = false;
        $this->flgCartUpdated = false;
        $this->flgPromoItmsDontQualify = false;
        $this->flgTranGiftCardUsed = false;
        $this->flgTranCreditCardUsed = false;
        $this->flgShipDiscounted = false;
        $this->PromoCode = null;
        $this->flgCartItmSoldOut = false;
        ShopCookie::init();
        ////ShopSession::tranResetPaymentFlags();  
    }
    
    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new ShopSession();       
        } 
        return self::$instance;
    }    

    public static function init()
    {                            
       $self = self::getInstance();
        //if ($_SESSION['TESTPWD'] != "VALIDATED"){ header("Location: /_src/secchk.php5");} //prod testing
        if (self::sessionExists()==false)
        {
            self::startSession();            
            //DBUG::OUT("session didn't exsit");
        }
        else
        {
            session_start();
            $self->cartCartID = $_SESSION['CART_ID'];
            SECURITY::regActivity();
            //DBUG::OUT("session exists id:".session_id());            
        }    
         
        if (isset($_GET['err']))
            $self->err = $_GET['err'];
        if (isset($_GET['errMsg']))
            $self->errMsg = PL::errMsgCreateMsg($_GET['errMsg']);
    }
    
    
    public static function forceSSL()
    {
        SECURITY::forceSSL();
    }
    
    public static function LG()
    {
       $self = self::getInstance();
       return $self->LG_ID;        
    }
    public static function HOMELNK()
    {
       $self = self::getInstance();
       return HOMELNK;        
    }
    public static function PRODIMGLNK()
    {
       $self = self::getInstance();
       return PRODIMGLNK;        
    }
    
    
    public static function _adminClearTmpSessionVariables()
    {
        unset($_SESSION['TMP_CLIENT_FULL_NAME']);
        unset($_SESSION['TMP_CLIENT_EMAIL_ADDRESS']);
    }
    
    public static function msgHandlerPromoCodeErr()
    {
        $promo_id = ShopSession::_tmpPromoId();
        $promo_code = ShopSession::_tmpPromoCode();
        if (ShopSession::flgPromoItmsDontQualify())
            $msg = PL::msgCreateMsg(TEXT::get("PROMO_ITMS_DONT_QUALIFY")." <a href=\"".LNK::get("PROMO_ITMS")."&SHOP_PROMO_ID_r1_lid1=$promo_id\">".TEXT::get("PROMO_VIEW_PRODUCTS_THAT_QUALIFY").": $promo_code </a>");            
        elseif (ShopSession::flgPromoCodeInvalid())
            $msg = PL::msgCreateMsg(TEXT::get("PROMO_CODE_INVALID")); 
        else
            $msg = null;       
            
        return $msg;
    }
    
    public static function _utilGetRefreshFlg()
    {
        return date("Ymdhis");
    }    
 
    public static function flgCartUpdated()
    {
       $self = self::getInstance();
       return $self->flgCartUpdated;        
    }

    public static function flgCartItmSoldOut()
    {
       $self = self::getInstance();
       return $self->flgCartItmSoldOut;        
    }
    
    public static function setFlgCartItmSoldOut($val=true)
    {
       $self = self::getInstance();
       $self->flgCartItmSoldOut = $val;        
    }
    
    public static function flgShipDiscounted()
    {
       $self = self::getInstance();
       return $self->flgShipDiscounted;        
    }

    public static function setFlgShipDiscounted($val=true)
    {
       $self = self::getInstance();
       $self->flgShipDiscounted = $val;        
    }

    public static function flgPaymentMethod()
    {
       $self = self::getInstance();
       return $_SESSION['PAYMENT_METHOD'];        
    }
    
    public static function flgTranCreditCardUsed()
    {
       $self = self::getInstance();
       return $self->flgTranCreditCardUsed;        
    }

    public static function flgTranGiftCardUsed()
    {
       $self = self::getInstance();
       return $self->flgTranGiftCardUsed;        
    }

    public static function flgPromoCodeApplied()
    {
       $self = self::getInstance();
       return $self->flgPromoCodeApplied;        
    }

    public static function flgPromoFreeShipping()
    {
       //$self = self::getInstance();
       //return $self->flgPromoFreeShipping; 
       return $_SESSION['PROMO_FREE_SHIPPING'];       
    }

    public static function flgPromoItmsDontQualify()
    {
       $self = self::getInstance();
       return $self->flgPromoItmsDontQualify;        
    }    
    
    public static function flgPromoCodeInvalid()
    {
       $self = self::getInstance();
       return $self->flgPromoCodeInvalid;        
    }

    public static function flgTranError()
    {
       $self = self::getInstance();
       return $self->ERR_FLAG_TRAN;    
    }
    

    public static function setFlgCartUpdated()
    {
       $self = self::getInstance();
       $self->flgCartUpdated=true;        
    }

    public static function setFlgTranError($tranError)
    {
       $self = self::getInstance();
       $self->ERR_FLAG_TRAN = $tranError;    
    }
    
    
    public static function setFlgTranGiftCardUsed($val=true)
    {
       $self = self::getInstance();
       $self->flgTranGiftCardUsed=$val;        
    }

    public static function setFlgPaymentMethod($paymentMethod)
    {
       $self = self::getInstance();
       $_SESSION['PAYMENT_METHOD'] = $paymentMethod;        
    }
                       
    public static function setFlgTranCreditCardUsed($val=true)
    {
       $self = self::getInstance();
       $self->flgTranCreditCardUsed=$val;        
    }
                       
    public static function setFlgPromoCodeApplied()
    {
       $self = self::getInstance();
       $self->flgPromoCodeApplied=true;        
    }

    public static function setFlgPromoFreeShipping($val=false)
    {
       //$self = self::getInstance();
       //$self->$flgPromoFreeShipping=$val;
       $_SESSION['PROMO_FREE_SHIPPING'] = $val;       
    }

    public static function setFlgPromoItmsDontQualify()  
    {
       $self = self::getInstance();
       $self->flgPromoItmsDontQualify=true;
       ShopSession::setFlgTranError(TRAN_ERROR::$PROMOCODE_NOTAPPLIED);        
    }
  
    public static function setFlgPromoCodeInvalid()
    {
       $self = self::getInstance();
       $self->flgPromoCodeInvalid=true;                
       ShopSession::setFlgTranError(TRAN_ERROR::$PROMOCODE_NOTAPPLIED);        
    }
    
    public static function errMsg()
    {
       $self = self::getInstance();
       return $self->errMsg;        
    }
    public static function err()
    {
       $self = self::getInstance();
       return $self->err;        
    }
    
    public static function _tmpSetPromoId($val)
    {
        $self = self::getInstance();
        $self->_tmpPromoId=$val;                
    }
    
    public static function _tmpSetPromoCode($val)
    {
        $self = self::getInstance();
        $self->_tmpPromoCode=$val;                
    }

    public static function promoCode_setPromoCode($val)
    {
        $self = self::getInstance();
        $_SESSION['PROMO_CODE']=$val;                
    }
    public static function promoCode_getPromoCode()
    {
        $self = self::getInstance();
        return $_SESSION['PROMO_CODE'];                
    }
    
    public static function _tmpPromoId()
    {
        $self = self::getInstance();
        return $self->_tmpPromoId;                
    }
    
    public static function _tmpPromoCode()
    {
        $self = self::getInstance();
        return $self->_tmpPromoCode;                
    }
    
    public static function startSession()
    {
        ////ShopSession::_adminClearTmpSessionVariables();
        /*IF A CART EXISTS DO NOT LOSE THE CART ID*/
        //echo "clientid sent in: $clientid";
        ////$cart_id = ShopSession::getCartId();
        ////ShopSession::killSession();
        session_start();
        if (CONFIG::$CART_ACTIVE)
            self::cart_setNewCartId($cart_id);
        SECURITY::setSessionSecurtiyVariables(); 
        //if (isset($clientid))
          //  ShopSession::setClientId($clientid);
    }

    public static function setClientId($clientid)
    {
        $_SESSION['CLIENT_ID'] = $clientid;
    }

    public static function setClientName($name)
    {
        $_SESSION['CLIENT_NAME'] = $name;
    }

    public static function setClientEmail($email)
    {
        $_SESSION['CLIENT_EMAIL'] = $email;
        //echo 'Session  var set:'.$clientid;        
    }
    public static function getClientEmail()
    {
       return $_SESSION['CLIENT_EMAIL']; 
    }
  
    public static function getClientName()
    {
       return isset($_SESSION['CLIENT_NAME']) ? $_SESSION['CLIENT_NAME'] : null; 
    }
  
    private static function cartGetCartId()
    {
       return $_SESSION['CART_ID']; 
    }

    public static function getSessionUID()
    {
        return session_id();
    } 
    
    private static function cart_setNewCartId()
    {
       $self = self::getInstance();
       $sessionId = session_id();
       $values['SHOP_CART_SHOP_SESSION_UID'] = $sessionId;
       $values['SHOP_CART_CLIENT_IP'] = SECURITY::getUserIP();
       $values['SHOP_CART_CLIENT_BRWSER'] = SECURITY::getUserBrowser();
       $dbdalCart = new dbdalSHOP_CART(1);
       $cartId = $dbdalCart->insertRecordByAssocArr($values,88);           
       $self->cartCartID = $cartId; //add:load from db
       $_SESSION['CART_ID'] = $cartId; 
    }
    
    public static function setShippingAddressId($id)
    {
        $_SESSION['SHIPPING_ADDRESS_ID'] = $id;
    }
    private static function clearShippingAddressId()
    {
        $_SESSION['SHIPPING_ADDRESS_ID'] = "";
    }
    
    private static function setCreditCardId($id)
    {
        $_SESSION['CREDIT_CARD_ID'] = $id;
        if(!ShopSession::sessionVarExists('ORIG_CREDIT_CARD_ID'))
        {
           $_SESSION['ORIG_CREDIT_CARD_ID'] = $id;
        }
    }
    
    public static function setBillingAddressId($id)
    {
        $_SESSION['BILLING_ADDRESS_ID'] = $id;
    }
    public static function clearBillingAddressId()
    {
        $_SESSION['BILLING_ADDRESS_ID'] = "";
    }

    private static function tranGetCreditCardId()
    {
        return $_SESSION['CREDIT_CARD_ID'];
    }
    
    private static function tranGetsOrigCreditCardId()
    {
        return $_SESSION['ORIG_CREDIT_CARD_ID'];
    }
    
    public function tranGetOrderSummaryValues($addr, &$totals, &$itms, &$displayItms)
    {
        $provCode = $addr['PROVCODE'];

        $shipping = ShopSession::getShippingRate();
        if (ShopSession::flgPromoFreeShipping())
            $shipping = 0;
            
        $cart_id  = ShopSession::getCartId();
        $totals = array();
        $itms = array();
        $displayItms = array();
        $x = CART::getCart($cart_id, $provCode, $shipping, $totals, $itms, $displayItms);
    }
    
    public static function tranPromoApplyPromoCode($payInfo, &$msg)
    {
        //first clear any codes that are currently on cart
        //**Disable this promocode logic until credit card page altered to show currently used promocode
        //**only accept gift cards 
        Promo::removePromoCode();
        $promoCode = $payInfo['PROMO_CODE_1'];
        if (isset($promoCode) && $promoCode != "")
        {
            Promo::applyPromoCode($promoCode);
            if (ShopSession::flgPromoItmsDontQualify() || ShopSession::flgPromoCodeInvalid())
            {
                ShopSession::setFlgTranError(TRAN_ERROR::$PROMOCODE_NOTAPPLIED);
                $msg = ShopSession::msgHandlerPromoCodeErr();                
            }
        }
    }
    
    public static function tranUtilGetCCTypeName($id)
    {
         switch($id)
         {
             case 1:
                return "Visa";
                break;
             case 2:
                return "MasterCard";
                break;
             case 3:
                return "Discover";
                break;
             case 4:
                return "Amex";
                break;
             default:
                return "";
                break;
         }
    }
    
    public static function tranReadInAndSetPaymentInfo()
    {
        $self = self::getInstance();
        $giftCardUsed = false;
        $errMsgs="";
        //Readin Parameters
        $promo_code1 = $promo_code2 = $gc1 = $gc2 = null;
        ShopSession::setFlgPaymentMethod(REQUEST::readIn('PAYMENTMETHODOPTION'));
        $_SESSION['CREDIT_CARD_TYPE_ID'] = REQUEST::readIn('SHOP_CREDIT_CARD_SHOP_CREDIT_CARD_TYPE_ID');
        $_SESSION['CREDIT_CARD_NUMBER'] = REQUEST::readIn('SHOP_CREDIT_CARD_CREDIT_CARD_NUMBER');
        $_SESSION['CVD'] = REQUEST::readIn('CVD');
        $_SESSION['CARDHOLDER_NAME'] = REQUEST::readIn('SHOP_CREDIT_CARD_CARDHOLDERS_NAME');
        $_SESSION['EXP_MONTH'] = REQUEST::readIn('SHOP_CREDIT_CARD_EXP_MONTH');
        $_SESSION['EXP_YEAR'] = REQUEST::readIn('SHOP_CREDIT_CARD_EXP_YEAR');
        $_SESSION['PROMO_CODE'] = "";
        $_SESSION['GIFT_CARD_1'] = "";
        $_SESSION['GIFT_CARD_2'] = "";
        $code1 = REQUEST::readIn('CODE_1');
        $code2 = REQUEST::readIn('CODE_2');

        DBUG::OUT("CREDIT_CARD_TYPE_ID:".$_SESSION['CREDIT_CARD_TYPE_ID']);        
        DBUG::OUT("CREDIT_CARD_NUMBER:".$_SESSION['CREDIT_CARD_NUMBER']);        
        DBUG::OUT("CVD:".$_SESSION['CVD']);        
        DBUG::OUT("CARDHOLDERS_NAME:".$_SESSION['CARDHOLDER_NAME']);        
        DBUG::OUT("EXP_MONTH:".$_SESSION['EXP_MONTH']);        
        DBUG::OUT("EXP_YEAR:".$_SESSION['EXP_YEAR']);        
        DBUG::OUT("CODE_1:$code1");        
        DBUG::OUT("CODE_2:$code2"); 
        
       
        if (isset($code1))
        {
            if(PaymentTran::utilIsGiftCard($code1))
            {
                $_SESSION['GIFT_CARD_1'] = $code1;
                $giftCardUsed = true;
                $gc1 = $code1;                
            }
            elseif(PaymentTran::utilIsPromoCode($code1))
            {
                $_SESSION['PROMO_CODE'] = $code1;
                $promo_code1 = $code1;                                
            }
            else
            {
                //errTrap
                $errMsgs = "<p>The code entered is not a valid TakeTheTime gift card or promotional code.";
                $self->errFlag = ErrFlag::$CODE_UNRECOGNIZED;
                $promo_code1 = $code1;
                
            }            
        }

        if (isset($code2))
        {
            if (PaymentTran::utilIsGiftCard($code2))
            {
                if (isset($gc1))
                {
                    $_SESSION['GIFT_CARD_2'] = $code2;
                    $giftCardUsed = true;
                    $gc2 = $code2;
                    
                }
                else
                {
                    $_SESSION['GIFT_CARD_1'] = $code2;
                    $giftCardUsed = true;
                    $gc1 = $code2;                
                }
            }
            elseif (PaymentTran::utilIsPromoCode($code2))
            {
                if (isset($promo_code1))
                {
                    //errTrap
                    $errMsgs .= "<p>Only one promo code can be used per purchase.";
                    $self->errFlag = ErrFlag::$PROMOCODE_LIMIT;
                    $promo_code2 = $code2;
                    
                }
                else
                {
                    $_SESSION['PROMO_CODE'] = $code2;

                }
            }
            else
            {
                //errTrap
                $errMsgs .= "<p>The code entered is not a valid TakeTheTime gift card or promotional code.";
                $self->errFlag = ErrFlag::$CODE_UNRECOGNIZED;
                $promo_code2 = $code2;
                
            }   
        }
        //$self->errMsgs.= $errMsgs;
         
        $ccNum = $_SESSION['CREDIT_CARD_NUMBER'];
        if ($ccNum!="")
        {
            $l = strlen($ccNum)-4;   
            $ccNum = substr($ccNum, -4);
            $cnt=0;
            while($cnt++<$l)
            {
                $ccNum = "*".$ccNum;
            } 
        }
        //errTrap

        $values=array();
        $values['SHOP_CREDIT_CARD_SHOP_CREDIT_CARD_TYPE_ID'] = $_SESSION['CREDIT_CARD_TYPE_ID'];
        $values['SHOP_CREDIT_CARD_CREDIT_CARD_NUMBER'] = $ccNum;
        $values['SHOP_CREDIT_CARD_CARDHOLDERS_NAME'] = $_SESSION['CARDHOLDERS_NAME'];
        $values['SHOP_CREDIT_CARD_EXP_MONTH'] = $_SESSION['EXP_MONTH'];
        $values['SHOP_CREDIT_CARD_EXP_YEAR'] = $_SESSION['EXP_YEAR'];
        $values['SHOP_CREDIT_CARD_GIFT_CARD_CODE_1'] = $_SESSION['GIFT_CARD_1'];
        $values['SHOP_CREDIT_CARD_GIFT_CARD_CODE_2'] = $_SESSION['GIFT_CARD_2'];
        $values['SHOP_CREDIT_CARD_PROMO_CODE_1'] = $_SESSION['PROMO_CODE'];
        $values['SHOP_CREDIT_CARD_PROMO_CODE_2'] = $promo_code2;
        $values['SHOP_CREDIT_CARD_ORIG_SHOP_CREDIT_CARDID'] = ShopSession::tranGetsOrigCreditCardId();
        $dbdal = new dbdalSHOP_CREDIT_CARD(1);//lg
        $credit_card_id = $dbdal->insertRecordByAssocArr($values, 1);
        
        ShopSession::tran_setCCInfo($values['SHOP_CREDIT_CARD_SHOP_CREDIT_CARD_TYPE_ID'], $values['SHOP_CREDIT_CARD_CREDIT_CARD_NUMBER'], $values['SHOP_CREDIT_CARD_CARDHOLDERS_NAME'], $values['SHOP_CREDIT_CARD_EXP_MONTH'], $values['SHOP_CREDIT_CARD_EXP_YEAR'],$values['SHOP_CREDIT_CARD_GIFT_CARD_CODE_1'],$values['SHOP_CREDIT_CARD_GIFT_CARD_CODE_2'],$values['SHOP_CREDIT_CARD_PROMO_CODE_1']);
                
        if (isset($credit_card_id) && $credit_card_id!=0)
            ShopSession::setCreditCardId($credit_card_id);
        else
        {      
            $errMsgs .= "<p>Server Busy.... cannot process at this moment.:".$self->errFlag;
            $self->errFlag = ErrFlag::$DB_ERR_SAVE_CC_INFO;
            DBUG::OUT("Err: no credit card id returned after db call");
        }        
        
        DBUG::OUT("gc1:$gc1");
        DBUG::OUT("gc2:$gc2");
        DBUG::OUT("pr1:$promo_code1");
        DBUG::OUT("pr2:$promo_code2");
        DBUG::OUT("ErrFlG:".$self->errFlag);
        DBUG::OUT("ErrMsg:".$self->errMsgs);
        DBUG::OUT("ccNum:".$ccNum);
        DBUG::OUT("credit_card_id:".$credit_card_id);
        DBUG::OUT("Orig cc id :" .ShopSession::tranGetsOrigCreditCardId());

        if(isset($self->errFlag))
        {
            $self->errMsgs = $errMsgs;
            return false;
        }
        else
        {
            if ($giftCardUsed)
                ShopSession::setFlgTranGiftCardUsed();
            return true;
        }
        
        
    }

    private static function tran_resetAddr($addrTypeId)
    {
        $suffix = "";
        if ($addrTypeId==1)
            unset($_SESSION['BILLSAMEASSHIP']);
        else
            $suffix = "_BILL";
        
        unset($_SESSION['CLIENT_ADDRESS_CLIENT_ID'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_TYPE_ID'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_ATTENTION_TO'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_1'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_2'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_CITY'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_ADDR_PROVINCE_ID'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_POSTAL_CODE'.$suffix]);
        unset($_SESSION['CLIENT_ADDRESS_TELEPHONE_NUMBER'.$suffix]);
    }
    
    public static function tran_resetAddrInfoShip_session()
    {
        ShopSession::tran_resetAddr(1);
    }
    public static function tran_resetAddrInfoBill_session()
    {
        ShopSession::tran_resetAddr(2);
    }

    public static function tran_setAddrInfoShip_session($addr)
    {
        $_SESSION['CLIENT_ADDRESS_CLIENT_ID'] = $addr['CLIENT_ADDRESS_CLIENT_ID'];
        $_SESSION['CLIENT_ADDRESS_TYPE_ID'] = $addr['CLIENT_ADDRESS_CLIENT_ADDRESS_TYPE_ID'];
        $_SESSION['CLIENT_ADDRESS_ATTENTION_TO'] = $addr['CLIENT_ADDRESS_ATTENTION_TO'];
        $_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_1'] = $addr['CLIENT_ADDRESS_ADDRESS_LINE_1'];
        $_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_2'] = $addr['CLIENT_ADDRESS_ADDRESS_LINE_2'];
        $_SESSION['CLIENT_ADDRESS_CITY'] = $addr['CLIENT_ADDRESS_CITY'];
        $_SESSION['CLIENT_ADDRESS_ADDR_PROVINCE_ID'] = $addr['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
        $_SESSION['CLIENT_ADDRESS_POSTAL_CODE'] = $addr['CLIENT_ADDRESS_POSTAL_CODE'];
        $_SESSION['CLIENT_ADDRESS_TELEPHONE_NUMBER'] = $addr['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
        $_SESSION['BILLSAMEASSHIP'] = $addr['BILLSAMEASSHIP'];                        
    }

    public static function tran_setAddrInfoBill_session($addr)
    {
        $_SESSION['CLIENT_ADDRESS_CLIENT_ID_BILL'] = $addr['CLIENT_ADDRESS_CLIENT_ID'];
        $_SESSION['CLIENT_ADDRESS_TYPE_ID_BILL'] = $addr['CLIENT_ADDRESS_CLIENT_ADDRESS_TYPE_ID'];
        $_SESSION['CLIENT_ADDRESS_ATTENTION_TO_BILL'] = $addr['CLIENT_ADDRESS_ATTENTION_TO'];
        $_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_1_BILL'] = $addr['CLIENT_ADDRESS_ADDRESS_LINE_1'];
        $_SESSION['CLIENT_ADDRESS_ADDRESS_LINE_2_BILL'] = $addr['CLIENT_ADDRESS_ADDRESS_LINE_2'];
        $_SESSION['CLIENT_ADDRESS_CITY_BILL'] = $addr['CLIENT_ADDRESS_CITY'];
        $_SESSION['CLIENT_ADDRESS_ADDR_PROVINCE_ID_BILL'] = $addr['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
        $_SESSION['CLIENT_ADDRESS_POSTAL_CODE_BILL'] = $addr['CLIENT_ADDRESS_POSTAL_CODE'];
        $_SESSION['CLIENT_ADDRESS_TELEPHONE_NUMBER_BILL'] = $addr['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
    }
    
    public static function tran_setCCInfo($CREDIT_CARD_TYPE_ID, $CREDIT_CARD_NUMBER, $CARDHOLDERS_NAME, $EXP_MONTH, $EXP_YEAR, $GIFT_CARD_CODE_1, $GIFT_CARD_CODE_2, $PROMO_CODE_1)    
    {
        $_SESSION['$CREDIT_CARD_TYPE_ID'] = $CREDIT_CARD_TYPE_ID;    
        $_SESSION['$CREDIT_CARD_NUMBER'] = $CREDIT_CARD_NUMBER;    
        $_SESSION['$CARDHOLDERS_NAME'] = $CARDHOLDERS_NAME;    
        $_SESSION['$EXP_MONTH'] = $EXP_MONTH;    
        $_SESSION['$EXP_YEAR'] = $EXP_YEAR;    
        $_SESSION['$GIFT_CARD_CODE_1'] = $GIFT_CARD_CODE_1;    
        $_SESSION['$GIFT_CARD_CODE_2'] = $GIFT_CARD_CODE_2;    
        $_SESSION['$PROMO_CODE_1'] = $PROMO_CODE_1;    
    }
    
    public static function tranGetPaymentInfo4Processor()
    {   //reads payment info from session
        $info['CREDIT_CARD_TYPE_ID'] = $_SESSION['CREDIT_CARD_TYPE_ID'];
        $info['CREDIT_CARD_NUMBER'] = $_SESSION['CREDIT_CARD_NUMBER'];
        $info['CVD'] = $_SESSION['CVD'];
        $info['CARDHOLDER_NAME'] = $_SESSION['CARDHOLDER_NAME'];
        $info['EXP_MONTH'] = $_SESSION['EXP_MONTH'];
        $info['EXP_YEAR'] = $_SESSION['EXP_YEAR'];
        $info['GIFT_CARD_1'] = $_SESSION['GIFT_CARD_1'];
        $info['GIFT_CARD_2'] = $_SESSION['GIFT_CARD_2'];
        $info['CODE_1'] = $_SESSION['CODE_1'];
        $info['CODE_2'] = $_SESSION['CODE_2'];
        return $info;
    }
        
    //todo
    public static function cartGetCartTotals()
    {   //note: replace this function by adding totaling functionality to Cart class
        //      addd return these same named totals via pass by value
        $dbdal = new dbdalSHOP_CART(1);//lg
        ////$filter['SHOP_CART_SHOP_CART_ID'] = ShopSession:
        $filter['SHOP_CART_SHOP_CART_ID'] = ShopSession::cartGetCartId();
        if(isset($filter['SHOP_CART_SHOP_CART_ID']))
        {
            $rs = $dbdal->selectRecordNew($filter);
            if (isset($rs[0]))
            {
                $row = $rs[0];
                $totals['SUBTOTAL'] = $row['SHOP_CART_SUBTOTAL'];                    
                $totals['SHIPPING'] = $row['SHOP_CART_SHIPPING'];                    
                $totals['HANDLING'] = $row['SHOP_CART_HANDLING'];                    
                $totals['TOTAL_B4TAX'] = $row['SHOP_CART_TOTAL_B4TAX'];                    
                $totals['TOTAL_GST'] = $row['SHOP_CART_TOTAL_GST'];                    
                $totals['TOTAL_PST'] = $row['SHOP_CART_TOTAL_PST'];                    
                $totals['TOTAL_TAX3'] = $row['SHOP_CART_TOTAL_TAX3'];                    
                $totals['GRAND_TOTAL'] = $row['SHOP_CART_GRAND_TOTAL'];
                return $totals;                    
            }
            else
                return null;//errTrap
        }
        else
            return null;//errTrap
    }
 
 
    public static function cartGetCartItms()
    {   //note: replace this function by modifying Cart class to passback (by value) its cart itms
        //      also modify Order summary display to act same as Shopping cart display.
        $dbdal = new dbdalSHOP_CART(1);
        $sql = 
        "SELECT GNS_ID, SUBTOTAL, COUNT(GNS_ID) AS QTY, MAX(GNS_SKU) AS GNS_SKU, MAX(GNS_NAME) AS GNS_NAME,".
        "MAX(GNS_PRICE) AS GNS_PRICE".
        "FROM SHOP_CART_ITM".
        "GROUP BY GNS_ID, SUBTOTAL"; 
        $rs = $dbdal->executeSelect($sql);
        if (isset($rs) && is_array($rs))
        {
            return $rs;
        }
        else
            return null;
            
    }
    
    public static function tranInvoiceGetLastSuffix()
    {
        $suffix = $_SESSION['INVOICE_SUFFIX'];
        if ($suffix == "")
        {
            $suffix = 1;
        }
        else
            $suffix++;
        return $suffix;
    }
    
    
    public static function tranGetPaymentInfo()
    {   /* Function reads in payment info from the database and sets the payment flags indicating if gift cards and credit cards were used*/
        $creditCardId = ShopSession::tranGetCreditCardId();
        if (isset($creditCardId) && trim($creditCardId)!="" && $creditCardId!=0)
        {
            
            $dbdal = new dbdalSHOP_CREDIT_CARD(1);//lg
            $filter=array();
            $filter['SHOP_CREDIT_CARD_SHOP_CREDIT_CARD_ID'] = $creditCardId;
            $rs = $dbdal->selectRecordNew($filter);
            $info=array();
            if (isset($rs[0]))
            {
                $row = $rs[0];
                $info['CREDIT_CARD_TYPE_ID'] = $row['SHOP_CREDIT_CARD_SHOP_CREDIT_CARD_TYPE_ID'];
                $info['CREDIT_CARD_NUMBER'] = $row['SHOP_CREDIT_CARD_CREDIT_CARD_NUMBER'];
                $info['CC_AMOUNT'] = $row['SHOP_CREDIT_CARD_CC_AMOUNT'];
                $info['PROMO_CODE_1'] = $row['SHOP_CREDIT_CARD_PROMO_CODE_1'];
                $info['GIFT_CARD_CODE_1'] = $row['SHOP_CREDIT_CARD_GIFT_CARD_CODE_1'];
                $info['GIFT_CARD_CODE_2'] = $row['SHOP_CREDIT_CARD_GIFT_CARD_CODE_2'];
                $info['GC_AMOUNT_1'] = $row['SHOP_CREDIT_CARD_GC_AMOUNT_1'];
                $info['GC_AMOUNT_2'] = $row['SHOP_CREDIT_CARD_GC_AMOUNT_2'];
                DBUG::OUT("FOUND g1:".$info['GIFT_CARD_CODE_1']." g2:".$info['GIFT_CARD_CODE_2']);
                ShopSession::tranSetPaymentFlags($info);
                return $info;
            }
            else
                return null;
        }
        else
            return null;
    }        
    
    private static function tranSetPaymentFlags($payInfo)
    {
        $ccNum = $payInfo['CREDIT_CARD_NUMBER'];
        $giftCardNum1 = $payInfo['GIFT_CARD_CODE_1'];
        $giftCardNum2 = $payInfo['GIFT_CARD_CODE_2'];
        if ((isset($giftCardNum1) && $giftCardNum1 !="") || (isset($giftCardNum2) && $giftCardNum2 !=""))
            ShopSession::setFlgTranGiftCardUsed(true);
        if (isset($ccNum) && $ccNum !="")
            ShopSession::setFlgTranCreditCardUsed(true);
    }
    
    public static function tranGetCCandGiftCardAmounts($grand_total, $payInfo, &$amntCC, &$amntGiftCard1, &$amntGiftCard2, &$msg)
    {   /* If a gift card has been entered an error flag will be set if that card has no funds */
        $msg = "";
        $g1 = $payInfo['GIFT_CARD_CODE_1'];
        $g2 = $payInfo['GIFT_CARD_CODE_2'];
        
        DBUG::OUT("g1:$g1 , g2:$g2");
        
        $g1fundsAvailable = $g2fundsAvailable = 0;
        
        if (isset($g1) && $g1 != "")
        {
            GiftCard::init($g1);
            $gcard1 = GiftCard::freeze($g1fundsAvailable);
            if ($g1fundsAvailable<=0)
            {
                $msg = TEXT::get("GIFT_CARD_ZERO_FUNDS_AVAILABLE")." ($g1)";
                ShopSession::setFlgTranError(TRAN_ERROR::$nofundsGiftCard);                
            }
        }
        if (isset($g2) && $g2 != "")
        {
            GiftCard::init($g2);
            $gcard2 = GiftCard::freeze($g2fundsAvailable);
            if ($g2fundsAvailable<=0)
            {
                $msg = TEXT::get("GIFT_CARD_ZERO_FUNDS_AVAILABLE")." ($g2)";
                ShopSession::setFlgTranError(TRAN_ERROR::$nofundsGiftCard);                
            }
        }
        
        $amntCC = $amntGiftCard1 = $amntGiftCard2 = 0;
        if ($g1fundsAvailable>0)
        {
            if  ($grand_total >= $g1fundsAvailable)
                $amntGiftCard1 = $g1fundsAvailable;
            else
                $amntGiftCard1 = $grand_total;     
            $grand_total -= $amntGiftCard1;
        }
        
        if ($grand_total > 0)
        {
            if ($g2fundsAvailable>0)
            {
                if  ($grand_total >= $g2fundsAvailable)
                    $amntGiftCard2 = $g2fundsAvailable;
                else
                    $amntGiftCard2 = $grand_total;     
                $grand_total -= $amntGiftCard2;
            }
            
        }
        
        if ($grand_total>0)
            $amntCC = $grand_total;
    } 

    public static function getErrMsgs()
    {
       $self = self::getInstance();   
       return $self->errMsgs;
    }
    
    public static function resetClientInfo()
    {
        SHopSession::setClientId("");
        ShopSession::clearShippingAddressId();
        ShopSession::clearBillingAddressId();
    }
    public static function tranResetPaymentFlags()
    {
        ShopSession::setFlgTranCreditCardUsed(false);
        ShopSession::setFlgTranGiftCardUsed(false);
        ShopSession::setFlgPaymentMethod(PAYMENT_METHOD::$CREDIT_CARD);
        $_SESSION['CREDIT_CARD_ID'] = '';
        $_SESSION['CREDIT_CARD_TYPE_ID'] = '';
        $_SESSION['CREDIT_CARD_NUMBER'] = '';
        $_SESSION['CVD'] = '';
        $_SESSION['CARDHOLDER_NAME'] = '';
        $_SESSION['EXP_MONTH'] = '';
        $_SESSION['EXP_YEAR'] = '';
        $_SESSION['GIFT_CARD_1'] = '';    
        $_SESSION['GIFT_CARD_2'] = '';
        //Promo::removePromoCode();//may have to put in another function    
    }
    
    public static function tranValidatePaymentInfo() 
    {
       $self = self::getInstance();
       /*
       if (ShopSession::flgTranGiftCardUsed())
       {
           GiftCard::init($_SESSION['GIFT_CARD_1']);
           GiftCard::freeze($gc1FundsAvailable, $gc2FundsAvailable);
           if ($fundsAvailable>0)
           {
               ShopSession::tranSetGiftCardFundsAvailable($gc1Funds, $gc2Funds);
           }
       }
       */
       //if cc is empty check if a gift card has been entered, if so then full payment to be put on gift card 
       //latest
       if (($_SESSION['CREDIT_CARD_NUMBER']== "" && ShopSession::flgTranGiftCardUsed()) || ShopSession::flgPaymentMethod()==PAYMENT_METHOD::$COD)
            return true;
       elseif (PaymentTran::validateCCNumber($_SESSION['CREDIT_CARD_NUMBER'], $_SESSION['CREDIT_CARD_TYPE_ID']))
       {
            if(PaymentTran::validateCCExp($_SESSION['EXP_MONTH'], $_SESSION['EXP_YEAR']))
            {
                if(PaymentTran::validateCVD($_SESSION['CVD']))
                {
                    if(PaymentTran::validateCardHolderName($_SESSION['CARDHOLDER_NAME']))
                    {
                        ShopSession::setFlgTranCreditCardUsed(true);
                        return true;
                    }
                    else
                    {
                       $self->errFlag = ErrFlag::$INVALID_CARDHOLDER;
                       $self->errMsgs.="You have entered an invalid cardholder name";
                    }                    
                }      
               else
               {
                   $self->errFlag = ErrFlag::$INVALID_CVD;
                   $self->errMsgs.="You have entered an invalid cvd";
               }
            }          
           else
           {
               $self->errFlag = ErrFlag::$INVALID_CCEXP;
               $self->errMsgs.="You have entered an invalid expiry date";
           }
       }
       else
       {
           $self->errFlag = ErrFlag::$INVALID_CCNUMBER;
           $self->errMsgs.="You have entered an invalid credit card number";
       }
       //$self->ErrMsg.="any error msgs for promos or gcs go here";
       ShopSession::tranResetPaymentFlags();        
       return false;
    }
    
    private static function redirect($webpg)
    {
        header("Location: $webpg"); //add page        
    }
    

    public static function redirect_cartViewCart()
    {
        ShopSession::redirect(LNK::get("CART_VIEW_CART"));        
    }

    public static function redirect_cartViewCart_invalidPromoCode()
    {
        $msg = "We're sorry there was a problem applying the promotional code entered.<br>";
        $msg .= "The promotional code either doesn't exist or has expired.";
        ShopSession::redirect(LNK::get("CART_VIEW_CART")."&errMsg=$msg");        
    }
    
    public static function redirect_ChkoutClientLogin($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP1")."&$vars");
    }

    public static function redirect_MyAccnt($vars="")
    {
        ShopSession::redirect(LNK::get("MYACCNT")."&$vars");
    }    

    public static function redirect_MyAccntCreateAccnt($vars="")
    {
        ShopSession::redirect(LNK::get("MYACCNT_CREATE_ACCNT")."&$vars");
    }    

    public static function redirect_MyAccntCreateAccntSuccessful($vars="")
    {
        ShopSession::redirect(LNK::get("MYACCNT_CREATE_ACCNT_SUCCESSFUL")."&$vars");
    }    

    public static function redirect_MyAccntSignIn($vars="")
    {
        ShopSession::redirect(LNK::get("MYACCNT_SIGNIN")."&$vars");
    }    

    public static function redirect_MyAccntSignIn_loginFailed($vars="")
    {
        $msg = TEXT::get("LOGIN_FAILED");
        ShopSession::redirect_MyAccntSignIn("errMsg=$msg");
    }    

    public static function redirect_ChkoutShippingAddress($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP2")."&$vars");
    }    

    public static function redirect_ChkoutBillingAddress($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP3")."&$vars");
    }    

    public static function redirect_ChkoutShippingOptions($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP3C")."&$vars");
    }    

    public static function redirect_ChkoutPaymentInfo($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP4")."&$vars");
    }    

    public static function redirect_ChkoutOrderSummary($vars="")
    {
        ShopSession::redirect(LNK::get("CHKOUT_STEP5")."&$vars");
    }    

    public static function redirect_OrderConfirmation($vars="")
    {
        //ShopSession::redirect(ROOT_DIR_WEB."orderConfirmation.php5?$vars");
        ShopSession::redirect(LNK::get("ORDER_CONFIRMATION")."&$vars");
    }    
        
    public static function redirect_ClientAccountCreate($vars="")
    {
        //ShopSession::redirect(ROOT_DIR_WEB."frm/client_createClient.php5?x=123&$vars");
        ShopSession::redirect(LNK::get("MYACCNT_CREATE_ACCNT")."&$vars");
    }    

    public static function redirect_ClientAccountCreateSuccessful($vars="")
    {
        //ShopSession::redirect(ROOT_DIR_WEB."frm/client_createClient.php5?x=123&$vars");
        ShopSession::redirect(LNK::get("MYACCNT_CREATE_ACCNT_SUCCESSFUL")."&$vars");
    }    
    
    public static function redirect_PwdAssist($vars="")
    {
        ShopSession::redirect(LNK::get("PWD_ASSIST")."&$vars");        
    }

    public static function redirect_PwdAssistEmailSent($vars="")
    {
        ShopSession::redirect(LNK::get("PWDASSIST_RESET_EMAIL_SENT")."&$vars");        
    }
    
    
    public static function redirect_PwdAssistResetPwd($vars="")
    {
        ShopSession::redirect(LNK::get("PWDASSIST_RESET_PG")."&$vars");        
    }

    public static function redirect_PwdResetComplete($vars="")
    {
        ShopSession::redirect(LNK::get("PWDASSIST_RESET_COMPLETE")."&$vars");        
    }
    
    public static function redirect_ChkoutCreateClientAccount_emailExists()
    {
        $msg = "A TakeTheTime account already exists for the email address you entered.<br>";
        $msg .= 'If you have forgotten your password click here %lnkForgotPassword%';
        ShopSession::redirect_ChkoutCreateClientAccount("errMsg=$msg");
    }    

    public static function redirect_ChkoutClientLogin_loginFailed()
    {
        ////$msg = "Sorry your login failed.  Either an account does not exist with this email address or the password is incorrect.<br>";
        ////$msg .= 'Please renter your email and password or if you have forgotten your password click here %lnkForgotPassword%';
        $msg = TEXT::get("LOGIN_FAILED");
        ShopSession::redirect_ChkoutClientLogin("errMsg=$msg");
    }    

    
    public static function killSession()
    {
        session_start();
        /**
           * If you only wish to nullify all of the session variables.
           *
        **/
        $_SESSION = array();

        /**
           * read and save session name to later void session
           * cookie
           *
        **/
        $session_name = session_name();   

        /**
          * destroy session data.
          * no need to use session_unset() in PHP5
        **/
        session_regenerate_id();
        session_destroy();

        /**
           * If you wish to kill the session, then you must
           * delete the  session cookie.
           * An http request is needed to effectively
           * set the cookie to permanent inactive status;
           * only the browser can remove the cookie.
           * 
        **/

        if ( isset( $_COOKIE[ $session_name ] ) ) {
            setcookie(session_name(), '', time()-3600, '/');
        }
}

    public static function getCartId()
    {
        $self = self::getInstance();
        return $self->cartCartID;
    }
    
    public static function cartUpdateCart()
    {
        $cart_id = ShopSession::getCartId();
        $result = CART::updateCart($cart_id);
        if ($result)
            ShopSession::setFlgCartUpdated();
        return $result;        
    } 
    
    public static function utilShippingOptionsRedirectToOrderSummary()
    {
        if ($_POST['RDTOS']=="1")
            return true;
        else
            return false;
    }   
    
    
    public static function cartAddToCart()
    {
        $cart_id = ShopSession::getCartId();
        CART::addToCart($cart_id);
    }    

    public static function cartRemoveFromCart()
    {
        $cart_id = ShopSession::getCartId();
        CART::removFromCart($cart_id);
    }    

    
    public static function cartGetCart()
    {
        $cart_id = ShopSession::getCartId();
        DBUG::OUT("CART ID: $cart_id");
        $html= CART::getCart($cart_id, null, null, $totals, $itms, $displayItms);
        $numCartItms = isset($itms) && is_array($itms) ? count($itms) : 0;
        $cartTotal = isset($totals) && is_array($totals) ? $totals['SUBTOTAL'] : null;
        ShopCookie::setCartCookies($numCartItms, $cartTotal);//for now have not implemented showing cart total
        return $html; 
    }

    public static function cart_utilGetRows()
    {
        return isset($_POST['ROWS']) ? $_POST['ROWS'] : null;
    }
        
    public static function setShippingRate($val, $option)
    {
        $_SESSION['SHIPPING_RATE'] = $val;
        $_SESSION['SHIPPING_OPTION'] = $option;
    }

    public static function getShippingRate()
    {
        return $_SESSION['SHIPPING_RATE'];
    }
    
    public static function getShippingOption()
    {
        return $_SESSION['SHIPPING_OPTION'];
    }
    
    
    public static function checkout()
    {
        $self = self::getInstance();
        if (!isset($self->clientId))
        {
            header("Location: clientLogin.php"); //add page
        }
        else //**
        {
            //add: load client info: name
            //add: load addresses
            //update shopping cart and session 
        }
    }

    public static function checkout_loadClientInfo()
    {
        $self = self::getInstance();
        //add: load client name and adresses
    }

    public static function sessionExists($name=null)
    {
        return self::sessionVarExists('CART_ID');
    }

    public static function clientIsLogggedIn()
    {
        return self::sessionVarExists('CLIENT_ID');
    }    
    public static function clientAuthenticate()
    {
        $parameters[] = "CLIENT_EMAIL_ADDRESS";
        $parameters[] = "CLIENT_PASSWORD";
        $parameters[] = "NEWCLIENT";
        //DBUG::SET_DBUG_ON();
        $filters = REQUEST::readIn($parameters, 1);        
//        DBUG::OUT("email sent in:".$filters['CLIENT_EMAIL_ADDRESS']);
//        DBUG::OUT("password sent in:".$filters['CLIENT_PASSWORD']);
        /*
        $filters = array();
        $filters['CLIENT_EMAIL_ADDRESS']=$email;
        $filters['CLIENT_PASSWORD']=$pwd;
        */
        $dbdal = new dbdalCLIENT(1);//lg
        $rs = $dbdal->selectRecordNew($filters[1]);
        if (isset($rs[0]))
        {
            $row = $rs[0];
            //client session variables
            ShopSession::setClientId($row['CLIENT_CLIENT_ID']);     
            ShopSession::setClientEmail($row['CLIENT_EMAIL_ADDRESS']);     
            $_SESSION['CLIENT_NAME'] = $row['CLIENT_FULL_NAME']; 
            return true;    
        }
        else
            return false;        
    }    

    public static function client_getClientId()
    {
        return $_SESSION['CLIENT_ID'];
        
    }
    
    public static function clientBillingAddrTransferFromShippingAddr()
    {                                                
        //DBUG::SET_DBUG_ON();
        $ADDR = ShopSession::clientGetShippingAddress();
        if (isset($ADDR))
        {
            $CLIENT_ID = ShopSession::client_getClientId();
            $dbdal = new dbdalCLIENT_ADDRESS(1);//lg
            $values = array();
            $values['CLIENT_ADDRESS_CLIENT_ID'] = $CLIENT_ID;
            $values['CLIENT_ADDRESS_CLIENT_ADDRESS_TYPE_ID'] = 2;
            $values['CLIENT_ADDRESS_ATTENTION_TO'] = $ADDR['ATTENTION_TO'];
            $values['CLIENT_ADDRESS_ADDRESS_LINE_1'] = $ADDR['ADDRESS_LINE1'];
            $values['CLIENT_ADDRESS_ADDRESS_LINE_2'] = $ADDR['ADDRESS_LINE2'];
            $values['CLIENT_ADDRESS_CITY'] = $ADDR['CITY'];
            $values['CLIENT_ADDRESS_ADDR_PROVINCE_ID'] = $ADDR['PROVINCE_ID'];
            $values['CLIENT_ADDRESS_POSTAL_CODE'] = $ADDR['POSTAL_CODE'];
            $values['CLIENT_ADDRESS_TELEPHONE_NUMBER'] = $ADDR['TELEPHONE'];
            $sql = "DELETE FROM CLIENT_ADDRESS WHERE CLIENT_ADDRESS_TYPE_ID=2 AND CLIENT_ID = $CLIENT_ID";
            $dbdal->executeSqlStmt($sql);
            $client_address_id = $dbdal->insertRecordByAssocArr($values,1);
            if (isset($client_address_id))
            {
                $date=date("Y/m/d");
                $sql = "INSERT INTO CLIENT_ADDRESS_TXT (CLIENT_ADDRESS_ID,LG_ID,CB,DC) VALUES ($client_address_id,1,99,'$date')";
                $dbdal->executeSqlStmt($sql);
                ShopSession::setBillingAddressId($client_address_id);
                return true;
            }
            else
                return false;//errTrap
        }
        else
        {
            //errTrap - no shipping address to transfer
            return false;
        }
    }
    
    public static function clientGetShippingAddress()
    {
        if (!self::sessionVarExists('SHIPPING_ADDRESS_ID'))
        {
            $client_id = ShopSession::client_getClientId();
            if (isset($client_id))
            {
                $dbdal = new dbdalCLIENT_ADDRESS(1);//lg;
                $filters = array();
                $filters['CLIENT_ADDRESS_CLIENT_ID'] = $client_id;
                $filters['CLIENT_ADDRESS_CLIENT_ADDRESS_TYPE_ID'] = 1;//SHIPPING ADDRESS
                $rs = $dbdal->selectRecordNew($filters);
                if (isset($rs[0]))
                {
                    $ADDR['CLIENT_ADDRESS_ID'] = $rs[0]['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'];
                    $ADDR['ATTENTION_TO'] = $rs[0]['CLIENT_ADDRESS_ATTENTION_TO'];
                    $ADDR['ADDRESS_LINE1'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_1'];
                    $ADDR['ADDRESS_LINE2'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_2'];
                    $ADDR['CITY'] = $rs[0]['CLIENT_ADDRESS_CITY'];
                    $ADDR['PROVINCE'] = $rs[0]['ADDR_PROVINCE_TXT_NAME'];
                    $ADDR['PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['PROVCODE'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['POSTAL_CODE'] = $rs[0]['CLIENT_ADDRESS_POSTAL_CODE'];
                    $ADDR['TELEPHONE'] = $rs[0]['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
                    $ADDR['COUNTRY_NAME'] = $rs[0]['ADDR_COUNTRY_TXT_NAME'];
                    
                    ShopSession::setShippingAddressId($ADDR['CLIENT_ADDRESS_ID']);//SET SESSION
                    $_SESSION['CLIENT_ADDRESS_ADDR_PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];//fix:COD
                    
                    return $ADDR;
                }
                else
                    return null;
            }
            else
                return null;//errTrap
            
            //load shipping address info from db
            //if found load session and return true
            //return true;
            //else return false
            return false;
            
        }
        else
        {
                $dbdal = new dbdalCLIENT_ADDRESS(1);//lg;
                $filters = array();
                $filters['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'] = $_SESSION['SHIPPING_ADDRESS_ID'];
                $rs = $dbdal->selectRecordNew($filters);
                if (isset($rs[0]))
                {
                    $ADDR['CLIENT_ADDRESS_ID'] = $rs[0]['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'];
                    $ADDR['ATTENTION_TO'] = $rs[0]['CLIENT_ADDRESS_ATTENTION_TO'];
                    $ADDR['ADDRESS_LINE1'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_1'];
                    $ADDR['ADDRESS_LINE2'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_2'];
                    $ADDR['CITY'] = $rs[0]['CLIENT_ADDRESS_CITY'];
                    $ADDR['PROVINCE'] = $rs[0]['ADDR_PROVINCE_TXT_NAME'];
                    $ADDR['PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['PROVCODE'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['POSTAL_CODE'] = $rs[0]['CLIENT_ADDRESS_POSTAL_CODE'];
                    $ADDR['TELEPHONE'] = $rs[0]['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
                    $ADDR['COUNTRY_NAME'] = $rs[0]['ADDR_COUNTRY_TXT_NAME'];
                    
                    $_SESSION['CLIENT_ADDRESS_ADDR_PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];//fix:COD
                                                      
                    return $ADDR;
                }
                else
                    return null;            
        }

    }    

    public static function clientGetBillingAddress()
    {
        if (!self::sessionVarExists('BILLING_ADDRESS_ID'))
        {
            DBUG::OUT("BILLING ADD ID DOESNT EXIST");
            $client_id = ShopSession::client_getClientId();
            if (isset($client_id))
            {
                $dbdal = new dbdalCLIENT_ADDRESS(1);//lg;
                $filters = array();
                $filters['CLIENT_ADDRESS_CLIENT_ID'] = $client_id;
                $filters['CLIENT_ADDRESS_CLIENT_ADDRESS_TYPE_ID'] = 2;//BILLING ADDRESS
                $rs = $dbdal->selectRecordNew($filters);
                if (isset($rs[0]))
                {
                    $ADDR['CLIENT_ADDRESS_ID'] = $rs[0]['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'];
                    $ADDR['ATTENTION_TO'] = $rs[0]['CLIENT_ADDRESS_ATTENTION_TO'];
                    $ADDR['ADDRESS_LINE1'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_1'];
                    $ADDR['ADDRESS_LINE2'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_2'];
                    $ADDR['CITY'] = $rs[0]['CLIENT_ADDRESS_CITY'];
                    $ADDR['PROVINCE'] = $rs[0]['ADDR_PROVINCE_TXT_NAME'];
                    $ADDR['PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['PROVCODE'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['POSTAL_CODE'] = $rs[0]['CLIENT_ADDRESS_POSTAL_CODE'];
                    $ADDR['TELEPHONE'] = $rs[0]['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
                    $ADDR['COUNTRY_NAME'] = $rs[0]['ADDR_COUNTRY_TXT_NAME'];
                    
                    ShopSession::setBillingAddressId($ADDR['CLIENT_ADDRESS_ID']);//SET SESSION
                    
                    return $ADDR;
                }
                else
                    return null;
            }
            else
                return null;//errTrap
            
            //load shipping address info from db
            //if found load session and return true
            //return true;
            //else return false
            return false;
            
        }
        else
        {
                DBUG::OUT("BILLING ADD ID EXISTS!!!");

                $dbdal = new dbdalCLIENT_ADDRESS(1);//lg;
                $filters = array();
                $filters['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'] = $_SESSION['BILLING_ADDRESS_ID'];
                $rs = $dbdal->selectRecordNew($filters);
                if (isset($rs[0]))
                {
                    $ADDR['CLIENT_ADDRESS_ID'] = $rs[0]['CLIENT_ADDRESS_CLIENT_ADDRESS_ID'];
                    $ADDR['ATTENTION_TO'] = $rs[0]['CLIENT_ADDRESS_ATTENTION_TO'];
                    $ADDR['ADDRESS_LINE1'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_1'];
                    $ADDR['ADDRESS_LINE2'] = $rs[0]['CLIENT_ADDRESS_ADDRESS_LINE_2'];
                    $ADDR['CITY'] = $rs[0]['CLIENT_ADDRESS_CITY'];
                    $ADDR['PROVINCE'] = $rs[0]['ADDR_PROVINCE_TXT_NAME'];
                    $ADDR['PROVINCE_ID'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['PROVCODE'] = $rs[0]['CLIENT_ADDRESS_ADDR_PROVINCE_ID'];
                    $ADDR['POSTAL_CODE'] = $rs[0]['CLIENT_ADDRESS_POSTAL_CODE'];
                    $ADDR['TELEPHONE'] = $rs[0]['CLIENT_ADDRESS_TELEPHONE_NUMBER'];
                    $ADDR['COUNTRY_NAME'] = $rs[0]['ADDR_COUNTRY_TXT_NAME'];
                                  
                    return $ADDR;
                }
                else
                    return null;            
        }

    } 

    
    public static function clientBillingAddressExists()
    {
        if (!self::sessionVarExists('CLIENT_BILLING_ADDRESS_ID'))
        {
            //load shipping address info from db
            //if found load session and return true
            //return true;
            //else return false
            return false;
            
        }
        return true;
    }    
    
    public static function sessionVarExists($name)
    {
       $self = self::getInstance();        
       if (isset($_SESSION[$name])&&$_SESSION[$name]!="")
        return true;
       else
        return false;
    }

}

class PL
{
    public static function errMsgCreateMsg($msgs)
    {
        if (isset($msgs)&&$msgs!="")
        {
            $html = "<div class='errMsg'>$msgs</div>";
            $html = str_ireplace("%lnkForgotPassword%", "<a href='#'>forgot my password</a>", $html);            
            $html = str_ireplace('\\', "", $html);            
        }
        else
            $html = "";
        return $html;
    }  

    public static function msgCreateMsg($msgs)
    {
        $html = "";
        if (isset($msgs)&&$msgs!="")
        {
            $html = "<div class='mainMsg'>$msgs</div>";
            $html = str_ireplace("%lnkForgotPassword%", "<a href='#'>forgot my password</a>", $html);            
        }
        else
            $html = "";
        return $html;
    }      
      
}

class ErrFlag
{
    public static $CODE_UNRECOGNIZED=1;
    public static $PROMOCODE=2;
    public static $GIFTCARD=3;
    public static $GIFTCARD_CODE_INVALID=300;
    public static $INVALID_CARDHOLDER=4;
    public static $INVALID_CVD=5;
    public static $INVALID_CCEXP=6;
    public static $INVALID_CCNUMBER=7;    
    public static $DB_ERR_SAVE_CC_INFO=900;    
    
}

class Validate
{
    //geo api key: ABQIAAAALk2YRPPXsyNoBwbQIBNqBxQgVuyLDKNIn7hNBO27FCMxT8tw3BRreN7LrsjyDnSpq_Uwcgi4C6ftbQ
    
    public static function clientAddress_attentionTo($name, &$msg)
    {
        $arr = split(" ", $name);
        $cnt = count($arr);
        $len  = strlen(str_ireplace(" ", "", $name));
        if ($cnt < 2 || $len < 3)
        {
          $msg = "Sorry, the Attention to field  must consist of a minimum of a First and Last name.";
          return false;
        }
        else
          return true;
    }
    public static function clientAddress_addressLine1($val, &$msg)   
    {
        $arr = split(" ", $val);
        $cnt = count($arr);
        $len  = strlen(str_ireplace(" ", "", $val));
        if ($cnt < 2 || $len < 3)
        {
          $msg = "Sorry, the Address Line 1 field  must consist of a street number and street name.";
          return false;
        }
        else
          return true;        
    }
    public static function clientAddress_addressLine2($email, &$msg)    
    {
        return true;        
    }
    public static function clientAddress_city($val, &$msg)
    {
        $len  = strlen(str_ireplace(" ", "", $val));
        if ($len < 3)
        {
          $msg = "Sorry, the City entered is invalid.";
          return false;
        }
        else
          return true;        
    }
    public static function clientAddress_addrProvinceId($val, &$msg)
    {
        if ($val == "")
        {
          $msg = "A province wasn't selected, please choose a province.";
          return false;
        }
        else
          return true;                
    }

    public static function clientAddress_postalCode($postalCode, &$msg)    
    {
        if (Validate::validateCanadaZip($postalCode))
            return true;        
        else
        {
            $msg = "Sorry, the postal code entered is not valid. Please enter a valid postal code.";
            return false;                
            
        }
    }
    
    public static function clientAddress_telephoneNumber($val, &$msg)  
    {
        $val=str_ireplace(" ","", $val);
        $val=str_ireplace("-","", $val);
        $val=str_ireplace("(","", $val);
        $val=str_ireplace(")","", $val);

        if (preg_match('/^\d+$/', $val) && strlen($val)==10)
            return true;
        else
        {
            $msg = "Sorry, the telephone number entered is not valid. Please enter a valid phone number in the format 555 555 5555.";
            return false;                            
        }
                
    }

    public static function clientAcccountCreate_emailAddress($email, $email_reentry, &$msg)
    {
        $validator = new EmailAddressValidator; 
        if (!isset($email) || $email=="" || !$validator->check_email_address($email))
        {
            $msg = TEXT::get("EMAIL_INVALID");
            return false;                
        } 
        elseif (!isset($email_reentry) || $email_reentry=="")
        {
            $msg = TEXT::get("ACCOUNT_CREATE_EMAIL_REENTER_MISSING");
            return false;                
        } 
        elseif ($email != $email_reentry)
        {
            $msg = TEXT::get("ACCOUNT_CREATE_EMAILS_DONTMATCH");
            return false;                
        }
        $dbdal = new dbdalCLIENT(1);//lg
        $filter=array();
        $filter['CLIENT_EMAIL_ADDRESS'] = $email;
        $rs = $dbdal->selectRecordNew($filter);
        if (isset($rs[0]['CLIENT_EMAIL_ADDRESS']))
        {
            $msg = TEXT::get("CLIENT_ACCOUNT_ALREADY_EXISTS");
            //$msg = "<p>A TakeTheTime account already exists for the email address you entered.";
            //$msg .= '<p>If you have forgotten your password click here %lnkForgotPassword%';
            return false;    
        }
    
        return true;        
    }

    public static function clientAcccountCreate_password($password, $password_reentry, &$msg)
    {
        $validator = new PasswordValidator; 
        if (!isset($password) || !$validator->validate($password))
        {
            $msg = TEXT::get("PASSWORD_INVALID");
            return false;                
        } 
        elseif (!isset($password_reentry) || trim($password_reentry)=="")
        {
            $msg = TEXT::get("ACCOUNT_CREATE_PASSWORD_REENTER_MISSING");
            return false;                
        } 
        elseif ($password != $password_reentry)
        {
            $msg = TEXT::get("ACCOUNT_CREATE_PASSWORDS_DONTMATCH");
            return false;                
        }
        return true;        
    }    
    
    public static function clientAccountCreate_fullName($name, &$msg)
    {
        //DBUG::SET_DBUG_ON();
        //DBUG::OUT("name: $name");
        $arr = split(" ", $name);
        $cnt = count($arr);
        $len  = strlen(str_ireplace(" ", "", $name));
        if ($cnt < 2 || $len < 3)
        {
          $msg = "<p>Sorry, your full name must consist of a minimum of your First and Last name.";
          return false;
        }
        else
          return true;
    }    


    public static function pwdAssist_emailAddress($email, $email_reentry, &$msg, &$clientId, &$clientName)
    {
        $validator = new EmailAddressValidator; 
        if (!isset($email) || $email=="" || !$validator->check_email_address($email))
        {
            $msg = TEXT::get("PWDASSIST_EMAIL_INVALID");
            return false;                
        } 
        elseif (!isset($email_reentry) || $email_reentry=="")
        {
            $msg = TEXT::get("PWDASSIST_EMAIL_REENTER_MISSING");
            return false;                
        } 
        elseif ($email != $email_reentry)
        {
            $msg = TEXT::get("PWDASSIST_EMAILS_DONTMATCH");
            return false;                
        }
        $dbdal = new dbdalCLIENT(1);//lg
        $filter=array();
        $filter['CLIENT_EMAIL_ADDRESS'] = $email;
        $rs = $dbdal->selectRecordNew($filter);
        if (!isset($rs[0]['CLIENT_EMAIL_ADDRESS']) || count($rs)==0)
        {
            $msg = TEXT::get("PWDASSIST_ACCOUNT_DOESNT_EXIST");
            return false;    
        }
        else
        {
            $clientId = $rs[0]['CLIENT_CLIENT_ID'];
            $clientName = $rs[0]['CLIENT_FULL_NAME'];
        }
    
        return true;        
    }    
    
    
    private static function validateCanadaZip($zip_code)
    {
        $zip_code = strtoupper($zip_code);
        $zip_code = str_replace(" ", "", $zip_code);
        $zip_code = str_replace("-", "", $zip_code);

        $count = count($zip_code);

        if(strlen($zip_code)!= 6) 
        {
            return false;
        }

        //function by Roshan Bhattara(http://roshanbh.com.np)
        if(preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i",$zip_code))
            return true;
        else
            return false;
    }

    
}

class PaymentTran
{                                                  
    public static function validateCardHolderName($name)
    {
        $arr = split(" ", $name);
        $cnt = count($arr);
        $len  = strlen(str_ireplace(" ", "", $name));
        if ($cnt < 2 || $len < 3)
        {
          return false;
        }
        else
          return true;
    }
    
    public static function validateCCExp($expMonth, $expYear)
    {
        return PaymentTran::expVal($expMonth.$expYear);    
    }

    public static function validateCVD($cvd)
    {
        //if (ereg('[^0-9]', $cvd) || strlen($cvd)!=3)
        if (ereg('[^0-9]', $cvd))
        {
            return false;
        }
        else
            return true;
    }
    
    public static function validateCCNumber($ccNum, $type)
    {
        if ($type==1)
            $name = "vis";
        elseif($type==2)
            $name = "mcd";
        elseif($type==3)
            $name = "dsc";
        elseif($type==4)
            $name = "amx";
        else
            return false;
        $exp = $expMonth.$expYear;
        return PaymentTran::CCVal($ccNum, $name, $exp);  
    }
    
  private static function expVal($Exp) 
  {
    if (strlen($Exp)) {
      $Month = substr($Exp, 0, 2);
      $Year  = substr($Exp, -2);

      $WorkDate = "$Month/01/$Year";
      $WorkDate = strtotime($WorkDate);
      $LastDay  = date("t", $WorkDate);

      $Expires  = strtotime("$Month/$LastDay/$Year 11:59:59");
      if ($Expires < time()) 
        return false;
      else
        return true;
    }
    else
        return false;
  }

  private static function CCVal($Num, $Name = "n/a", $Exp = "") 
  {
//  Innocent until proven guilty
    $GoodCard = true;

//  Get rid of any non-digits
    $Num = ereg_replace("[^0-9]", "", $Num);

//  Perform card-specific checks, if applicable
    switch ($Name) {

    case "mcd" :
      $GoodCard = ereg("^5[1-5].{14}$", $Num);
      break;

    case "vis" :
      $GoodCard = ereg("^4.{15}$|^4.{12}$", $Num);
      break;

    case "amx" :
      $GoodCard = ereg("^3[47].{13}$", $Num);
      break;

    case "dsc" :
      $GoodCard = ereg("^6011.{12}$", $Num);
      break;

    case "dnc" :
      $GoodCard = ereg("^30[0-5].{11}$|^3[68].{12}$", $Num);
      break;

    case "jcb" :
      $GoodCard = ereg("^3.{15}$|^2131|1800.{11}$", $Num);
      break;
  
    case "dlt" :
      $GoodCard = ereg("^4.{15}$", $Num);
      break;

    case "swi" :
      $GoodCard = ereg("^[456].{15}$|^[456].{17,18}$", $Num);
      break;

    case "enr" :
      $GoodCard = ereg("^2014.{11}$|^2149.{11}$", $Num);
      break;
    }

//  The Luhn formula works right to left, so reverse the number.
    $Num = strrev($Num);

    $Total = 0;

    for ($x=0; $x<strlen($Num); $x++) {
      $digit = substr($Num,$x,1);

//    If it's an odd digit, double it
      if ($x/2 != floor($x/2)) {
        $digit *= 2;

//    If the result is two digits, add them
        if (strlen($digit) == 2)
          $digit = substr($digit,0,1) + substr($digit,1,1);
      }

//    Add the current digit, doubled and added if applicable, to the Total
      $Total += $digit;
    }

//  If it passed (or bypassed) the card-specific check and the Total is
//  evenly divisible by 10, it's cool!
    if ($GoodCard && $Total % 10 == 0) return true; else return false;
  }    
    
    public static function utilIsGiftCard($code)
    {
        if (isset($code))
        {
            if (strtoupper(substr($code,0,2))=="GC")
                return true;
            else
                return false;
        }
        else
            return false;    
    }
    public static function utilIsPromoCode($code)
    {
        if (isset($code))
        {
            if (strtoupper(substr($code,0,2))=="PR")
                return true;
            else
                return false;
        }
        else
            return false;            
    }
    
}

class TOOLS
{
    public static function valM($val, $format=null)
    {
        $val = TOOLS::val($val);
        $curr = $format==1 ? "&#36;" : ($format==2 ? "" : "CDN$ ");
        //return $curr." ".round($val, 2);;
        return $curr."".number_format(round($val, 2),2);
    }

    public static function val($val)
    {
        if(!isset($val)||$val=="")
            return 0;
        else
            return $val;
    }
    
    public static function b($val)
    {
        if(!isset($val))
            return "";
        else
            return $val;
    }
    
    public static function formatPhone($phone)
    {    
        $phone = preg_replace("/[^0-9]/", "", $phone);
        if(strlen($phone) == 7)        
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
        elseif(strlen($phone) == 10)
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
       else        
            return $phone;
    }    
}

//echo "test";
//ShopCookie::init();
DBUG::SET_DBUG_OFF();
ShopSession::init();
ShopSession::setFlgPromoFreeShipping(false);

if (isset($_GET['err']))
    $self->err = $_GET['err'];
if (isset($_GET['errMsg']))
    $self->errMsg = PL::errMsgCreateMsg($_GET['errMsg']);
/***
* FIXES
* replace split(" ", $name); WITH explode(" ", $name);
* replace split(" ", $val); WITH explode(" ", $val); 
* 
*/
?>