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
 
 
class TEXT
{
    private $txt;
    private static $instance;

    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new TEXT();       
        } 
        return self::$instance;
    }    
    
    private function __construct()
    {
        $this->txt = array();
        if (ShopSession::LG()==1)
        {   
            /*** GENERAL ***/            
            $this->txt['HI'] = "Hi";
            $this->txt['CLOSE_THIS_WINDOW'] = "Close this window";
            $this->txt['CONTINUE'] = "Continue";
            $this->txt['SIGNIN'] = "Signin";
            $this->txt['SIGNOUT'] = "Sign out";
            /*** END GENERAL ***/            
                                      
            $this->txt['FTAX_NUM'] = "GST#";                               
            $this->txt['PTAX_NUM'] = "PST#";                               

            $this->txt['PGTITLE_TAKETHETIME_CHECKOUT'] = "Infinite-ts.com Secure Check Out";
                                           
            $this->txt['LOGIN_ACCOUNT_LOGIN'] = "Account Login";
            $this->txt['LOGIN_HDR_QUICK_AND_EASY'] = "Quick and Easy Infinite-ts.com Check-out";
            $this->txt['LOGIN_ENTER_EMAIL'] = "Enter your e-mail address";
            $this->txt['LOGIN_I_AM_NEW'] = "I am a new customer";
            $this->txt['LOGIN_YOULL_CREATE_PWD_LATER'] = "you'll create a password later";
            $this->txt['LOGIN_EXISTING_CUSTOMER_PWD'] = "I am an existing Infinite-ts.com customer,<br>and my password is:";
            $this->txt['LOGIN_FORGOT_YOUR_PASSWORD'] = "Forgot your password? Click here";
            $this->txt['LOGIN_CONTINUE_SECURE_CHECKOUT'] = "Continue to secure check out";  
            $this->txt['LOGIN_FAILED'] = "Sorry your login failed.  Either an account does not exist with this email address or the password is incorrect.<br>Please renter your email and password or if you have forgotten your password click here:<br> <a href=\"".LNK::get("PWD_ASSIST")."\">forgot my password</a>";          
            
            $this->txt['CLIENT'] = "Client";
            $this->txt['CLIENT_FULL_NAME'] = "Full Name";
            $this->txt['EMAIL_ADDRESS'] = "E-mail address";
            $this->txt['REENTER_EMAIL_ADDRESS'] = "Re-enter E-mail address";
            $this->txt['EMAIL_INVALID'] = "Sorry, the e-mail address entered is not valid. Please enter a valid e-mail address.";
            $this->txt['ACCOUNT_CREATE_NEW_ACCOUNT'] = "Create New Account";
            $this->txt['ACCOUNT_CREATE_NEW_TO_TAKETHETIME'] = "New to infinite-ts.com? Registering is quick and easy";
            $this->txt['ACCOUNT_CREATE_ENTER_EMAIL_NAME_PWD'] = "Enter your name and e-mail address and choose a password for your account.";
            $this->txt['ACCOUNT_CREATE_CLIENT_FULL_NAME'] = "Full Name:";
            $this->txt['ACCOUNT_CREATE_CLIENT_EMAIL'] = "e-mail:";
            $this->txt['ACCOUNT_CREATE_CLIENT_RENTER_EMAIL'] = "Re-enter E-mail:";
            $this->txt['CLIENT_ACCOUNT_ALREADY_EXISTS'] = "A Infinite-ts.com account already exists for the e-mail address you entered.<br>If you have forgotten your password click here:<br> <a href=\"".LNK::get("PWD_ASSIST")."\">forgot my password</a>";
            $this->txt['ACCOUNT_CREATE_EMAIL_REENTER_MISSING'] = "Please re-enter your e-mail address";
            $this->txt['ACCOUNT_CREATE_EMAILS_DONTMATCH'] = "The e-mails entered do not match...please re-enter your e-mail address";
            $this->txt['PWDASSIST_EMAIL_INVALID'] = "Sorry, the e-mail address entered is not valid. Please enter a valid e-mail address.";
            $this->txt['PWDASSIST_EMAIL_REENTER_MISSING'] =  "Please re-enter your e-mail address";
            $this->txt['PWDASSIST_EMAILS_DONTMATCH'] = "The e-mails entered do not match...please re-enter your e-mail address";
            $this->txt['PWDASSIST_ACCOUNT_DOESNT_EXIST'] = "We are sorry but a infinite-ts.com account does not exist for the e-mail address you entered.";
            $this->txt['PWDASSIST_INVALID_TOKEN'] = "We are sorry but there seems to be a problem with your password recovery request. Please resubmit your password recovery request. For further assistance contact our customer service department at ".CONFIG::$PHONENUM_CUSTOMER_SERVICE;
            $this->txt['PWDASSIST_EXPIRED_TOKEN'] = "We are sorry but your password reset request has expired. To provide our shoppers with the best in security customers must complete their password reset within 30 minutes of the original request. If a password reset is not completed within 30 minutes of the original request, shoppers are required to resubmit their requests to reset their password. Please resubmit your password recovery request. If you require further assistance contact our customer service department at ".CONFIG::$PHONENUM_CUSTOMER_SERVICE;
            $this->txt['PWD_ASSIST_SYSERR'] = "We are sorry but there was a problem resetting your password. For further assistance contact our customer service department at ".CONFIG::$PHONENUM_CUSTOMER_SERVICE;
            $this->txt['PWD_ASSIST_RESET_SUCCESSFUL'] = "Your ".COMPANY." account password has been successfully reset.";

            $this->txt['PASSWORD'] = "Password";
            $this->txt['REENTER_PASSWORD'] = "Re-enter Password";
            $this->txt['ACCOUNT_CREATE_CLIENT_PASSWORD'] = "password:";
            $this->txt['PASSWORD_INVALID'] = "Sorry, the password entered is not valid. Please enter a case sensitive password that is at least 6 characters long, and a maximum of 16 characters.";
            $this->txt['ACCOUNT_CREATE_CLIENT_RENTER_PASSWORD'] = "Re-enter Password:";
            $this->txt['ACCOUNT_CREATE_PASSWORD_REENTER_MISSING'] = "\"Re-enter Password\" cannot be left blank...please enter your password";
            $this->txt['ACCOUNT_CREATE_PASSWORDS_DONTMATCH'] = "The passwords entered do not match...please re-enter your password";

            $this->txt['ACCOUNT_CREATE_CREATED_SUCCESSFULLY'] = "Your ".COMPANY." account was created successfully";
            $this->txt['ACCOUNT_CREATE_CREATED_WELCOME'] = "Welcome to ".COMPANY."!";
            
            $this->txt['PWD_ASSIST'] = "Password Assistance";
            $this->txt['PWD_ASSIST_RESET_SUCCESSFUL'] = "Password Assistance - Account modification complete";
            $this->txt['PWD_ASSIST_SUBHDR_RESET_SUCCESSFUL'] = "You have changed your password successfully";
            $this->txt['PWD_ASSIST_RESET'] = "Password Asstance - Step 2 - Create your new ".COMPANY." password";
            $this->txt['PWD_ASSIST_SUBHDR_ENTER_ACCOUNT_EMAIL'] = "Enter the e-mail address associated with your ".COMPANY." account, then click Continue.";
            $this->txt['PWD_ASSIST_SUBHDR_ENTER_A_NEW_PASSWORD'] = "Enter a new password for your ".COMPANY." account, then click Continue.";
            $this->txt['PWD_ASSIST_EMAIL_ADDRESS_PLEASE_CONFIRM'] = 'Please confirm your email address';

            $this->txt['PWD_ASSIST_RESET_EMAIL_SENT'] = "Password Assistance - check your e-mail";
            $this->txt['PWD_ASSIST_SUBHDR_RESET_EMAIL_SENT'] = "An email has been sent to %EMAILADDRESS% with instructions on how to reset your".COMPANY." password. If you do not receive this e-mail please verify your email filter settings and also try having a check in your junk email folder. If you require further assistance contact our customer service department at ".CONFIG::$PHONENUM_CUSTOMER_SERVICE;

            $this->txt['MYACCNT_CREATE_ACCNT'] = "Create Account";
            $this->txt['MYACCNT_ACCNT_CREATED'] = "Your Account has been Created.";
            $this->txt['MYACCNT_MSG_ACCNT_CREATED'] = "Your ".COMPANY." account has been sucessfully created.".
                                                        "<br><br><span class=h2>Thank you, and welcome to infinite-ts.com</span><br><br>".
                                                        "<span class='salutationSincere'>Sincerely,</span>".
                                                        "<span class='salutationSignature'>The Infinite-ts.com Team.</span></div>";

            $this->txt['MYACCNT_HDR'] = "My" . COMPANY . " Account";
            $this->txt['MYACCNT_HDR2'] = "";
            $this->txt['MYACCOUNT_WELCOME'] = "Welcome to your personal account.";  

            $this->txt['MYACCNT_SIGNIN'] = "Sign In";
            $this->txt['MYACCNT_NAV_SIGNIN'] = "My Account";
            $this->txt['MYACCNT_HDR_SIGNIN'] = "Sign in to My Account";
            $this->txt['MYACCOUNT_WHATISYOUR_EMAILADDRESS'] = "What is your email address?";
            $this->txt['MYACCOUNT_DOYOU_HAVE_A_PASSWORD'] = "Do you have a ".COMPANY." password?";

            $this->txt['MYACCNT_ENTER_EMAIL'] = "E-mail address";
            $this->txt['MYACCNT_I_AM_NEW'] = "No, I am a new customer";
            $this->txt['MYACCNT_EXISTING_CUSTOMER_PWD'] = "Yes my password is:";

            
            $this->txt['MYACCNT_HDING_ORDER_NUMBER'] = "Order Number";
            $this->txt['MYACCNT_HDING_ORDER_DATE'] = "Order Date";
            $this->txt['MYACCNT_HDING_SHIP_ATT_TO'] = "Attention to";
            $this->txt['MYACCNT_HDING_SHIP_ADDR1'] = "Street address";
            $this->txt['MYACCNT_HDING_SHIP_CITY'] = "City";
            $this->txt['MYACCNT_HDING_SHIP_POSTAL_CODE'] = "Postal Code";
            $this->txt['MYACCNT_HDING_SHIP_PROV'] = "Province";
            $this->txt['MYACCNT_HDING_ORDER_STATUS'] = "Status";
            
            $this->txt['ADDR_SHIPPING_INFORMATION'] = "Shipping Information";
            $this->txt['ADDR_MY_SHIPPING_ADDR'] = "My Shipping Address";
            $this->txt['ADDR_PLEASE_ENTER'] = "Please Enter your Shipping Address below and then click 'continue'";
            $this->txt['ADDR_BILLING_INFORMATION'] = "Billing Information";
            $this->txt['ADDR_BILLING_ADDRESS'] = "Billing Address";
            $this->txt['ADDR_MY_BILLING_ADDR'] = "My Billing Address";
            $this->txt['ADDR_PLEASE_ENTER_BILL'] = "Please Enter your Billing Address below and then click 'continue'";
            $this->txt['ADDR_ATTENTION_TO'] = "Attention to";
            $this->txt['ADDR_ADDRESS_LINE_1'] = "Address Line 1";
            $this->txt['ADDR_ADDRESS_LINE_2'] = "Address Line 2";
            $this->txt['ADDR_OR_COMPANY_NAME'] = "or company name";
            $this->txt['ADDR_STREET_ADDRESS_PO_BOX'] = "Street address, P.O. box, company name, c/o";
            $this->txt['ADDR_OPTIONAL'] = "optional";
            $this->txt['ADDR_APARTMENT_SUITE_ETC'] = "Apartment, suite, unit, building, floor, etc.";
            $this->txt['ADDR_CITY'] = "City";
            $this->txt['ADDR_PROVINCE'] = "Province/Region";
            $this->txt['ADDR_IF_APPROPRIATE'] = "if appropriate";
            $this->txt['ADDR_POSTAL_CODE'] = "Postal Code / ZIP";
            $this->txt['ADDR_COUNTRY'] = "Country";
            $this->txt['ADDR_TELEPHONE_NUMBER'] = "Telephone Number";
            $this->txt['ADDR_USE_MY_SHIP_FOR_BILL'] = "Use my shipping Address for my billing address<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (if not we'll ask you for it later)";
            $this->txt['ADDR_USE_MY_SHIP_FOR_BILL_AS_BELOW'] = "Use my shipping Address for my billing address (as seen below)";
            $this->txt['ADDR_IWOULDLIKE_DIFF_BILL'] = "I would like to enter a different billing address";
            $this->txt['ADDR_CHANGE_MY_SHIP'] = "Change my shipping address";
            $this->txt['ADDR_USE_THIS_SHIP'] = "Use this shipping address";
            $this->txt['ADDR_CHANGE_MY_BILL'] = "Change my billing address";
            $this->txt['ADDR_USE_THIS_BILL'] = "Use this billing address";
            $this->txt['ADDR_SELECT_A_PROVINCE'] = "Select a Province";
            $this->txt['ADDR_ALBERTA'] = "ALBERTA";
            $this->txt['ADDR_BRITISH_COLUMBIA'] = "BRITISH COLUMBIA";
            $this->txt['ADDR_MANITOBA'] = "MANITOBA";
            $this->txt['ADDR_NEWBRUNSWICK'] = "NEWBRUNSWICK";
            $this->txt['ADDR_NEWFOUNDLAND_AND_LABRADOR'] = "NEWFOUNDLAND AND LABRADOR";
            $this->txt['ADDR_NORTHWEST_TERRITORIES'] = "NORTHWEST TERRITORIES";
            $this->txt['ADDR_NOVA_SCOTIA'] = "NOVA SCOTIA";
            $this->txt['ADDR_NUNAVUT'] = "NUNAVUT";
            $this->txt['ADDR_ONTARIO'] = "ONTARIO";
            $this->txt['ADDR_PRINCE_EDWARD_ISLAND'] = "PRINCE EDWARD ISLAND";
            $this->txt['ADDR_QUEBEC'] = "QUEBEC";
            $this->txt['ADDR_SASKATCHEWAN'] = "SASKATCHEWAN";
            $this->txt['ADDR_YUKON'] = "YUKON";
            $this->txt['ADDR_BTN_CONTINUE'] = "continue";
            
            
            
            $this->txt['PROMO_CODE_APPLIED'] = "Congratulations, your promotional code qualifies you for great savings!";
            $this->txt['CART_EMPTY'] = "Your Shopping Cart is Empty.";
            $this->txt['PROMO_REMOVE_PROMO_CODE'] = "remove promo code";
            $this->txt['PROMO_CODE_INVALID'] = "There was a problem applying the promotional code entered.<br>Please make sure the promotion has not expired.";
            $this->txt['CART_UPDATED'] = "Your Shopping Cart was updated.";
            $this->txt['DELETE'] = "delete";                                                                   
            //$this->txt['PROMO_ITMS_DONT_QUALIFY'] = "Sorry the items in your shopping cart do not qualify for this promotion <br> To see the items that do qualify click here";
            $this->txt['PROMO_ITMS_DONT_QUALIFY'] = "Sorry the items in your shopping cart do not qualify for this promotion";
            $this->txt['PROMO_VIEW_PRODUCTS_THAT_QUALIFY'] = "view products that qualify for promotion code";
            $this->txt['TRAN_ERROR_INSUFFICIENT_GIFTCARD_FUNDS'] = "Insufficient Gift Card funds available for this order <br> To bill part of or the entire order on your credit card, please enter your credit card info below.";
            $this->txt['TRAN_ERROR_PAYMENT_INFO_MISSING'] = "Payment Info missing - please supply your credit card and/or gift card information below.";
            $this->txt['TRAN_SYSERROR_GIFT_CARD_UNABLE_TO_DEBIT'] = "Unable to debit gift card";
            $this->txt['TRAN_SYSERROR_UNABLE_TO_CREATE_INVOICE_NUMBER'] = "SYS: Unable to create inv num";
            $this->txt['TRAN_ERROR_SECURITY_CHECK_FAILED'] = "Sec check failed";
            $this->txt['SECURITY_SESSION_IP_MISMATCH'] = "Sec: Session IP mismatch";
            $this->txt['SECURITY_SESSION_BRWSR_MISMATCH'] = "Sec: Session browser mismatch";

            $this->txt['GIFT_CARD_ZERO_FUNDS_AVAILABLE'] = "Gift card has zero funds available";

            
            $this->txt['SHOPPING_CART'] = "Shopping Cart";
            $this->txt['UPDATE_CART'] = "Update Cart";
            $this->txt['SHOPPING_CART_ITEMS'] = "Shopping Cart Items";
            $this->txt['PRICE'] = "Price";
            $this->txt['QTY'] = "Qty";
            $this->txt['PROMOTIONAL_CODE'] = "Promotional Code";
            $this->txt['PROCEED_TO_CHECKOUT'] = "Proceed to Checkout";
            $this->txt['CODE'] = "Code";
            $this->txt['SUBTOTAL'] = "SubTotal";
            $this->txt['CART_MAKE_ANY_CHANGES'] = "Make any changes below";
            $this->txt['APPLY'] = "apply";
            $this->txt['CART_READY_TO_CHECKOUT_WAIT'] = "Ready to check-out? Wait";
            $this->txt['ADD'] = "Add";
            $this->txt['CART_READY_TO_CHECKOUT_FREE_SHIP'] = "to your cart and qualify for Free shipping!";
            
            $this->txt['PAYMENT_METHOD'] = "Payment Method";            
            $this->txt['PAYMENT_METHOD_CC'] = "Credit Card";            
            $this->txt['PAYMENT_METHOD_COD'] = "Cash On Delivery";            
            $this->txt['PAYMENT_CVD_WHATSTHIS'] = "what's this?";   
            $this->txt['CASH_ON_DELIVERY'] = "Cash On Delivery";                     
            $this->txt['CC_CARD_TYPE'] = "Credit Card Type";
            $this->txt['CC_CARD_NUMBER'] = "Credit Card No.";
            $this->txt['CC_CVD'] = "Card Security Code";
            $this->txt['CC_CARDHOLDERS_NAME'] = "Cardholder's Name";
            $this->txt['CC_EXP_DATE'] = "Expiration Date";            

            $this->txt['PAYMENT_INFORMATION'] = "Payment Information";            
            $this->txt['PAYMENT_DOYOU_HAVE_GIFTCARD'] = "Do you have a Gift Card or promotional code";            
            $this->txt['PAYMENT_GIFTCARD_HAVEMORETHAN_ONE'] = "if you have more than one gift card click 'enter another'. If not click the 'continue' button below";            
            $this->txt['PAYMENT_ENTER_CODE'] = "Enter Code";            
            $this->txt['ENTER_ANOTHER'] = "enter another";            
            $this->txt['REMOVE'] = "remove";            
            $this->txt['CONTINUE'] = "continue"; 
            
            $this->txt['EDIT'] = "edit";                    
            $this->txt['EDIT_ITEMS'] = "edit items";                    
            $this->txt['ORDER'] = "Order";
            $this->txt['ORDER_SHIPPING_DETAILS'] = "Shipping Details";                    
            $this->txt['ORDER_SHIPPING_TO'] = "Shipping to";                    
            $this->txt['ORDER_SHIPPING_OPTIONS'] = "Shipping Options";                    
            $this->txt['ORDER_ITEMS'] = "Order Items";                    
            $this->txt['ORDER_QUANTITY'] = "Quantity";                    
            $this->txt['ORDER_SUMMARY'] = "Order Summary";                    
            $this->txt['BILLING_INFORMATION'] = "Billing Information";                    
            $this->txt['BILLING_SUMMARY'] = "Billing Summary";                    
            $this->txt['ORDER_TOTAL_B4TAX'] = "Total Before Tax";
            $this->txt['ORDER_GST'] = "GST";
            $this->txt['ITEMS'] = "Items";                    
            $this->txt['HANDLING'] = "Handling";                    
            $this->txt['SHIPPING'] = "Shipping";
            $this->txt['PST'] = "PST";
            $this->txt['ORDER_TOTAL'] = "Order Total";
            $this->txt['PAYMENT_METHOD'] = "Payment Method";
            $this->txt['CREDIT_CARD'] = "Credit Card";
            $this->txt['TYPE'] = "Type";
            $this->txt['EXP'] = "Exp";
            $this->txt['AMOUNT'] = "Amount";
            $this->txt['GIFT_CARD'] = "Gift Card";
            $this->txt['CODE'] = "Code";
            $this->txt['ORDER_PLEASE_REVIEW_AND_SUBMIT'] = "Please review and submit your order";
            $this->txt['PLACE_ORDER'] = "place your order";
                    
            $this->txt['TRAN_SESSION_EXPIRED_REENTER_INFO'] = "Your session has expired. Please re-enter your payment information.";       
            
            $this->txt['TRAN_DECLINED_INVALID_CVD'] = "Transaction declined. An Invalid CVD value was entered. Please re-enter your payment information.";
            $this->txt['TRAN_DECLINED'] = "Transaction declined. Please review your transaction information before submitting your transaction.";
            $this->txt['TRAN_SERVER_BUSY'] = "Server busy due to high volume.<br>Due to high traffic volumes order processing is temporarily unavailable, please try again later.<br>";
            
            $this->txt['SHIP_YOUVE_RECEIVED_FREE_SHIPPING'] = "You've received free shipping!!";
            $this->txt["SHIP_OPTION_ORDER_ITEM"] = "Order Item";
            $this->txt["SHIP_OPTION_QUICKEST_AVAILABLE"] = "Quickest Shipping Method Available";
            $this->txt["SHIP_OPTION_OPTIONS_AVAILABLE"] = "Shipping Options";
            $this->txt["SHIP_OPTION_ITM_DETAILS"] = "Order Item Shipping Details";
            $this->txt["SHIP_OPTION_CHOOSE_SPEED"] = "Choose a shipping speed";
            $this->txt["SHIP_OPTION_DESC_XPRESS"] = "Express (averages 1 to 2 business days)";
            $this->txt["SHIP_OPTION_DESC_EXPEDITED"] = "Expedited (averages 1 to 7 business days)";
            $this->txt["SHIP_OPTION_DESC_REGULAR"] = "Regular (averages 5 to 10 business days)";
            $this->txt["SHIP_OPTION_DESC_NEXTDAY"] = "Guaranteed Next Day";            
            $this->txt["SHIP_OPTION_DESC2_XPRESS"] = "averages 1-2 business days)";
            $this->txt["SHIP_OPTION_DESC2_EXPEDITED"] = "Expedited (averages 1 to 7 business days)";
            $this->txt["SHIP_OPTION_DESC2_REGULAR"] = "Regular (averages 5 to 10 business days)";
            $this->txt["SHIP_OPTION_DESC2_NEXTDAY"] = "Guaranteed Next Day";     
            $this->txt['SHIP_OPTION_ERR_MUST_SELECT'] = "A shipping option was not selected. Please select your desired shipping speed below";  
            
            $this->txt['CART_READY_TO_CHKOUT'] = "Ready to Checkout?"; 
            $this->txt['CART_DISCOUNTS_AVAIALBLE'] = "Shipping Discount Available";
            $this->txt['CART_WAIT_ADD_MORE'] = "Wait, add %x% more and your cart qualifies for free shipping!";
            $this->txt['CART_WAIT_ADD_MORE_FOR_DISCOUNT'] = "Wait, add %x% more and your cart qualifies for a shipping discount!";
            
            
            $this->txt['DISCNT_SHIP_YOUVE_RECEIVED_DISCOUNTED_RATES'] = "You've received discounted shipping rates!";
            $this->txt['DISCNT_SHIP_DISCOUNT_CONDITIONS'] = "Recieve a shipping discount on any purchase of %x% and more!";
            $this->txt['DISCNT_ALMOST_QUALIFIES_FOR_SHIP_DISCOUNT'] = "Wait, add %x% more and your cart qualifies for a shipping discount!";
            $this->txt['DISCNT_ALMOST_QUALIFIES_FOR_SHIP_FREE'] = "<span style='color:#669933;font-weight:bold;'>Your cart qualifies for a Shipping discount!</span><br><br>Wait, add %x% more and your cart qualifies for free shipping!";
            $this->txt['DISCNT_QUALIFIES_FOR_SHIP_FREE'] = "<span style='color:#669933;font-weight:normal;'>Your cart qualifies for free shipping!</span>";    
            

            $this->txt['MSG_ORDERSUBMITTED'] = "<div><span class=h1> Your order has been submitted</span><br><span class=h2>Your order number is: %ORDERNUMBER%</span>".
                    "<br><span class=h2>A confirmation email containing all your order information has been sent to you at the following email address: %EMAIL%</span>".
                    "<br><span class=h2>If you do not receive a confirmation email within the next 15 minutes please verify your email filter settings and also try having a check in your junk email folder.</span>".
                    "<br><br><span class=h2>Thank you for shopping with Infinite-ts.com</span><br><br>".
                    "<span class='salutationSincere'>Sincerely,</span>".
                    "<span class='salutationSignature'>The Infinite-ts.com Team.</span></div>";
            $this->txt['MSG_PROBLEM_PROCESSING_ORDER'] = "There were problems processing your order. %MSG%";

			$this->txt['MSG_CART_ITM_SOLDOUT'] = "There are items added to your cart that are now Sold-out. The following items can no longer be added to your cart";
			
            $this->txt['BODYANDBATH'] = "Body &amp; Bath";
            $this->txt['FACECARE'] = "Face Care";
            $this->txt['ORALCARE'] = "Oral Care";
            $this->txt['BABYANDCHILD'] = "Baby &amp; Child";
            $this->txt['MOMTOBE'] = "Mom to be";
            $this->txt['NURSING'] = "Nursing";
            $this->txt['BABYSLINGS'] = "Baby Slings";
            $this->txt['FITNESS'] = "Fitness";
            $this->txt['GIFTSETS'] = "Gift Sets";
            $this->txt['GIFTCARDS'] = "Gift Cards";            
            $this->txt['SRCHRESULTS'] = "Search Results"; 
            $this->txt['SRCHRESULTS_FOR'] = "Search Results for"; 

            $this->txt['LBL_HOME_LBL'] = "HOME"; 
            $this->txt['LBL_LAST_VIEWED_LBL'] = "Last Viewed"; 
            $this->txt['LBL_SEE_ALL_LBL'] = "See All"; 

            $this->txt['SRCHPG__PRODUCTS_FOUND'] = "products found"; 
            $this->txt['SRCHPG__PAGE'] = "page"; 
            $this->txt['SRCHPG__OF'] = "of"; 
            $this->txt['SRCHPG__RECORDS'] = "records"; 
            $this->txt['SRCHPG__TO'] = "to"; 
            $this->txt['SRCHPG__VIEWDETAILS'] = "View Details"; 
            
            $this->txt['SRCHPG__PREVPG'] = "previous page"; 
            $this->txt['SRCHPG__NEXTPG'] = "next page"; 
            
            
            $this->txt['LBL_SEARCH_LBL'] = "search"; 
                                   
            $this->txt['SYSERR_MYACCNT_ERR_CREATING_ACCNT'] = "error creating account"; 
            
            $this->txt['BTN_GO'] = "GO";
            
        }
        else
        {            
            $this->txt['CLIENT_FULL_NAME'] = "fr: Full Name";
            $this->txt['EMAIL_ADDRESS'] = "fr: E-mail Address";
            $this->txt['REENTER_EMAIL_ADDRESS'] = "fr: Re-enter E-mail Address";
            $this->txt['EMAIL_INVALID'] = "fr: Sorry, the email address entered is not valid. Please enter a valid email address.";
            $this->txt['ACCOUNT_CREATE_CLIENT_FULL_NAME'] = "fr: Full Name:";
            $this->txt['ACCOUNT_CREATE_CLIENT_EMAIL'] = "fr: email:";
            $this->txt['ACCOUNT_CREATE_CLIENT_RENTER_EMAIL'] = "fr: re-enter email:";
            $this->txt['CLIENT_ACCOUNT_ALREADY_EXISTS'] = "fr: A Infinite-ts.com account already exists for the email address you entered.<br>If you have forgotten your password click here %lnkForgotPassword%";
            $this->txt['ACCOUNT_CREATE_EMAIL_REENTER_MISSING'] = "fr: Please re-enter your email address";
            $this->txt['ACCOUNT_CREATE_EMAILS_DONTMATCH'] = "fr: The emails entered do not match...please re-enter your email address";

            $this->txt['ADDR_SHIPPING_INFORMATION'] = "fr:Shipping Information";
            $this->txt['ADDR_PLEASE_ENTER'] = "fr:Please Enter your Shipping Address below and then click 'continue'";
            $this->txt['ADDR_ATTENTION_TO'] = "fr:Attention to";
            $this->txt['ADDR_ADDRESS_LINE_1'] = "fr:Address Line 1";
            $this->txt['ADDR_ADDRESS_LINE_2'] = "fr:Address Line 2";
            $this->txt['ADDR_OR_COMPANY_NAME'] = "fr:or company name";
            $this->txt['ADDR_STREET_ADDRESS_PO_BOX'] = "fr:Street address, P.O. box, company name, c/o";
            $this->txt['ADDR_OPTIONAL'] = "fr:optional";
            $this->txt['ADDR_APARTMENT_SUITE_ETC'] = "fr:Apartment, suite, unit, building, floor, etc.";
            $this->txt['ADDR_CITY'] = "fr:City";
            $this->txt['ADDR_PROVINCE'] = "fr:Province/Region";
            $this->txt['ADDR_IF_APPROPRIATE'] = "fr:if appropriate";
            $this->txt['ADDR_POSTAL_CODE'] = "fr:Postal Code / ZIP";
            $this->txt['ADDR_COUNTRY'] = "fr:Country";
            $this->txt['ADDR_TELEPHONE_NUMBER'] = "fr:Telephone Number";
            $this->txt['ADDR_USE_MY_SHIP_FOR_BILL'] = "fr:Use my shipping Address for my billing address (if not we'll ask you for it later)";
            $this->txt['ADDR_CHANGE_MY_SHIP'] = "fr:Change my shipping address";
            $this->txt['ADDR_USE_THIS_SHIP'] = "fr:Use this shipping address";
            $this->txt['ADDR_SELECT_A_PROVINCE'] = "fr:Select a Province";
            $this->txt['ADDR_ALBERTA'] = "fr:ALBERTA";
            $this->txt['ADDR_BRITISH_COLUMBIA'] = "fr:BRITISH COLUMBIA";
            $this->txt['ADDR_MANITOBA'] = "fr:MANITOBA";
            $this->txt['ADDR_NEWBRUNSWICK'] = "fr:NEWBRUNSWICK";
            $this->txt['ADDR_NEWFOUNDLAND_AND_LABRADOR'] = "fr:NEWFOUNDLAND AND LABRADOR";
            $this->txt['ADDR_NORTHWEST_TERRITORIES'] = "fr:NORTHWEST TERRITORIES";
            $this->txt['ADDR_NOVA_SCOTIA'] = "fr:NOVA SCOTIA";
            $this->txt['ADDR_NUNAVUT'] = "fr:NUNAVUT";
            $this->txt['ADDR_ONTARIO'] = "fr:ONTARIO";
            $this->txt['ADDR_PRINCE_EDWARD_ISLAND'] = "fr:PRINCE EDWARD ISLAND";
            $this->txt['ADDR_QUEBEC'] = "fr:QUEBEC";
            $this->txt['ADDR_SASKATCHEWAN'] = "fr:SASKATCHEWAN";
            $this->txt['ADDR_YUKON'] = "fr:YUKON";
            $this->txt['ADDR_BTN_CONTINUE'] = "fr:continue";


            
            $this->txt['PROMO_CODE_APPLIED'] = "fr: Congratulations, your promotional code qualifies you for great savings!";
            $this->txt['CART_UPDATED'] = "fr: Your Shopping Cart was updated.";
            $this->txt['CART_EMPTY'] = "fr: Your Shopping Cart is Empty.";
            $this->txt['PROMO_REMOVE_PROMO_CODE'] = "fr: remove promo code";
            $this->txt['PROMO_CODE_INVALID'] = "fr: There was a problem applying the promotional code entered.<br>Please make sure the promotion has not expired.";
            $this->txt['DELETE'] = "delete";
            $this->txt['PROMO_ITMS_DONT_QUALIFY'] = "fr: Sorry the items in your shopping cart do not qualify for this promotion <br> To see the items that do qualify click here";
            $this->txt['PROMO_VIEW_PRODUCTS_THAT_QUALIFY'] = "fr: view products that qualify for promotion code";
            $this->txt['TRAN_ERROR_INSUFFICIENT_GIFTCARD_FUNDS'] = "fr: Insufficient Gift Card funds available for this order <br> To bill part of or the entire order on your credit card, please enter your credit card info below.";
            
        }
    }
    
    public static function get($txtId)
    {
        $self = self::getInstance();        
        $txtId = strtoupper($txtId);
        //echo "text itms".count($self->txt);
        return isset($self->txt[$txtId]) ? $self->txt[$txtId] : "";       
    }
}

class LNK
{
    private $lnk;
    private static $instance;

    private static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new LNK();       
        } 
        return self::$instance;
    } 
    
    private function __construct()
    {
        $this->lnk = array();
        if (ShopSession::LG()==1)
        {
            $this->lnk['CART_VIEW_CART'] = ROOT_DIR_WEB."cart_ViewCart.php5?";
            $this->lnk['CHKOUT_STEP1'] = ROOT_DIR_WEB."chkOut_step1.php5?";
            $this->lnk['CHKOUT_STEP2'] = ROOT_DIR_WEB."chkOut_step2.php5?";
            $this->lnk['CHKOUT_STEP3'] = ROOT_DIR_WEB."chkOut_step3.php5?";
            $this->lnk['CHKOUT_STEP3B'] = ROOT_DIR_WEB."chkOut_step3b.php5?";
            $this->lnk['CHKOUT_STEP3C'] = ROOT_DIR_WEB."chkOut_step3c.php5?";
            $this->lnk['CHKOUT_STEP4'] = ROOT_DIR_WEB."chkOut_step4.php5?";
            $this->lnk['CHKOUT_STEP5'] = ROOT_DIR_WEB."chkOut_step5.php5?";
            $this->lnk['CHKOUT_STEP6'] = ROOT_DIR_WEB."chkOut_step6.php5?";
            $this->lnk['CLIENT_CREATE_ACCOUNT'] = ROOT_DIR_WEB."frm/client_createClient.php5?";
            $this->lnk['CART_VIEW_CART'] = ROOT_DIR_WEB."cart_ViewCart.php5?";
            $this->lnk['CART_UPDATE_CART'] = ROOT_DIR_WEB."cart_updateCart.php5?";
            $this->lnk['CART_REMOVE_ITM'] = ROOT_DIR_WEB."cart_removeFromCart.php5?";
            $this->lnk['CART_APPLY_PROMO'] = ROOT_DIR_WEB."cart_applyPromo.php5?";
            $this->lnk['CART_REMOVE_PROMO'] = ROOT_DIR_WEB."cart_removePromo.php5?";
            $this->lnk['PROMO_ITMS'] = ROOT_DIR_WEB."promotions/promoItems.php5?";
            $this->lnk['CLIENT_SUBMIT_LOGIN'] = ROOT_DIR_WEB."bl/frm/client/CLIENT_SubmitLogin.php5?";
            $this->lnk['CLIENT_SUBMIT_CREATE_ACCNT'] = ROOT_DIR_WEB."bl/frm/client/CLIENT_SubmitCreateClient.php5?";
            $this->lnk['CLIENT_SUBMIT_CREATE_ADDRESS'] = ROOT_DIR_WEB."bl/frm/client/CLIENT_ADDRESS_SubmitCreateClient.php5?";
            $this->lnk['SHIPPING_OPTION_SUBMIT'] = ROOT_DIR_WEB."bl/frm/client/SHIPPING_OPTION_Submit.php5?";
            $this->lnk['CREDIT_CARD_SUBMIT_CREATE'] = ROOT_DIR_WEB."bl/frm/client/SHOP_CREDIT_CARD_SubmitCreateClient.php5?";
            $this->lnk['ORDER_CONFIRMATION'] = ROOT_DIR_WEB."orderConfirmation.php5?";
            $this->lnk['HOME'] = "/";
            $this->lnk['PROD_IMG'] = "images/store/products/";
            
            $this->lnk['MYACCNT_SIGNIN'] = ROOT_WEB."myaccount/signin.php?";
            $this->lnk['MYACCNT_SIGNIN_SUBMIT'] = ROOT_WEB."myaccount/signin-submit.php?";
            $this->lnk['MYACCNT_CREATE_ACCNT'] = ROOT_WEB."myaccount/createAccnt.php?";
            $this->lnk['MYACCNT_CREATE_ACCNT_SUBMIT'] = ROOT_DIR_WEB."myaccount/createAccnt-submit.php?";
            $this->lnk['MYACCNT_CREATE_ACCNT_SUCCESSFUL'] = ROOT_WEB."myaccount/createAccnt-successful.php?";

            $this->lnk['MYACCNT'] = ROOT_WEB."myaccount/myaccount.php?";
            $this->lnk['MYACCNT_SUBMIT_LOGIN'] = ROOT_DIR_WEB."bl/frm/client/MYACCNT_SubmitLogin.php5?";

            $this->lnk['PURCHASSIST_HLP_CVD'] = ROOT_WEB."customerService/purchasing-assistance/help/helpCardSecurityCode.php5?";

            
            
            $this->lnk['PWD_ASSIST'] = ROOT_DIR_WEB."passwordassistance/recovery.php5?";
            $this->lnk['PWDASSIST_SUBMIT_RESET_REQUEST'] = ROOT_DIR_WEB."bl/frm/client/PWDASSIST_SubmitResetRequest.php5?";
            $this->lnk['PWDASSIST_SUBMIT_PWDRESET'] = ROOT_DIR_WEB."bl/frm/client/PWDASSIST_SubmitPasswordReset.php5?";
            $this->lnk['PWDASSIST_SUBMIT_NEW_PWD'] = ROOT_DIR_WEB."bl/frm/client/PWDASSIST_SubmitNewPWd.php5?";
            $this->lnk['PWDASSIST_RESET_PG'] = HOMELNK."passwordassistance/recoveryStep2.php5?";
            //$this->lnk['PWDASSIST_RESET_PG'] = ROOT_DIR_WEB."passwordassistance/recoveryStep2.php5?";//dev
            $this->lnk['PWDASSIST_RESET_COMPLETE'] = ROOT_DIR_WEB."passwordassistance/recoveryStep3.php5?";
            $this->lnk['PWDASSIST_RESET_EMAIL_SENT'] = ROOT_DIR_WEB."passwordassistance/recoveryStep1.php5?";

            $this->lnk['BODYANDBATH'] = "products/bodyandbath/";
            $this->lnk['FACECARE'] = "products/facecare/";
            $this->lnk['ORALCARE'] = "products/oralcare/";
            $this->lnk['BABYANDCHILD'] = "products/babyandchild/";
            $this->lnk['MOMTOBE'] = "products/momtobe/";
            $this->lnk['NURSING'] = "products/nursing/";
            $this->lnk['BABYSLINGS'] = "products/babyslings/";
            $this->lnk['FITNESS'] = "products/fitness/";
            $this->lnk['GIFTSETS'] = "products/giftsets/";
            $this->lnk['GIFTCARDS'] = "products/giftcards/";
            
            $this->lnk['SRCHRESULTS'] = "search/searchResults.php5?";
            
        }
        else
        {
            $this->lnk['CART_VIEW_CART'] = ROOT_DIR_WEB."cart_ViewCart.php5?";
            $this->lnk['CHKOUT_STEP1'] = ROOT_DIR_WEB."chkOut_step1.php5?";
            $this->lnk['CHKOUT_STEP2'] = ROOT_DIR_WEB."chkOut_step2.php5?";
            $this->lnk['CHKOUT_STEP3'] = ROOT_DIR_WEB."chkOut_step3.php5?";
            $this->lnk['CHKOUT_STEP4'] = ROOT_DIR_WEB."chkOut_step4.php5?";
            $this->lnk['CHKOUT_STEP5'] = ROOT_DIR_WEB."chkOut_step5.php5?";
            $this->lnk['CLIENT_CREATE_ACCOUNT'] = ROOT_DIR_WEB."frm/client_createClient.php5?";
            $this->lnk['CART_UPDATE_CART'] = ROOT_DIR_WEB."cart_updateCart.php5?";
            $this->lnk['CART_REMOVE_ITM'] = ROOT_DIR_WEB."cart_removeFromCart.php5?";
            $this->lnk['CART_APPLY_PROMO'] = ROOT_DIR_WEB."cart_applyPromo.php5?";
            $this->lnk['CART_REMOVE_PROMO'] = ROOT_DIR_WEB."cart_removePromo.php5?";
            $this->lnk['PROMO_ITMS'] = ROOT_DIR_WEB."promotions/promoItems.php5?";
            $this->lnk['HOME'] = "/";
        }       
    }  
    
    public static function get($lnkId, $addRefreshVar=true)
    {
        $self = self::getInstance();        
        $lnkId = strtoupper($lnkId);
        //echo "text itms".count($self->txt);
        $date = date("Ymdhis");
        $lnk = isset($self->lnk[$lnkId]) ? $self->lnk[$lnkId] : "";       
        $lnk =  $addRefreshVar ? $lnk."refresh=$date":$lnk;
        return $lnk; 
    }    
         
}

?>