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
 
                
//error_reporting(0);
//error_log("D:/Websites/staging.TakeTheTime.ca/site/lib/its/comp/comp/ITS_ACCOUNT_MANAGER/__errLog/error_log.txt");

 class CONFIG 
{
    public static $ROOT = "lib/its/comp/ITS_ACCOUNT_MANAGER/";
    public static $WEB_ROOT = "/";//Web root with respect to the plugin
    public static $CART_ACTIVE = false;
    public static $dbugLogFileDir = "D:/Websites/staging.TakeTheTime.ca/site/lib/its/comp/ITS_ACCOUNT_MANAGER/__log/";
    public static $FTAX_NUM = "813775426RT0001";
    public static $PTAX_NUM = "1215150051TQ0001";

    public static $PHONENUM_CUSTOMER_SERVICE = "1-800-887-1527";
    public static $EMAIL_CUSTOMER_SERVICE = "customer-service@infinite-ts.com";
    public static $EMAIL_ORDERCONF_FROM_ADDRESS = "order-confirmation@infinite-ts.com";//lg
    public static $EMAIL_ORDERCONF_FROM_NAME = "Infinite TS Team";
    public static $EMAIL_ORDERCONF_REPLYTO_ADDRESS = "customer-service@infinite-ts.com";
    public static $EMAIL_ORDERCONF_REPLYTO_NAME = "Infinite-ts.com Customer Service";
    public static $EMAIL_ORDERCONF_SUBJECTLINE = "Your Order with Infinite-ts.com order#:%ORDERNUMBER%";


    public static $EMAIL_PWDASSIST_FROM_ADDRESS = "account-update@infinite-ts.com";//lg
    public static $EMAIL_PWDASSIST_FROM_NAME = "Infinite-ts.com Team";
    public static $EMAIL_PWDASSIST_REPLYTO_ADDRESS = "customer-service@infinite-ts.com";
    public static $EMAIL_PWDASSIST_REPLYTO_NAME = "Infinite-ts.com Customer Service";
    public static $EMAIL_PWDASSIST_SUBJECTLINE = "Infinite-ts.com Password Assistance";
    public static $EMAIL_PWDRESET_COMPLETE_SUBJECTLINE = "Revision to your Infinite-ts.com Account";
    
    public static $EMAIL_ADMIN_TO_ADDRESS = "ops@infinite-ts.com";//lg
    public static $EMAIL_ADMIN_TO_NAME = "Infinite-ts.com Admin";//lg

    public static $EMAIL_SYSADMIN_TO_ADDRESS = "sysadmin@infinite-ts.com";//lg
    public static $EMAIL_SYSADMIN_TO_NAME = "Infinite-ts.com Sys Admin";//lg

    public static $EMAIL_ADMIN_FROM_ADDRESS = "notifications@infinite-ts.com";//lg
    public static $EMAIL_ADMIN_FROM_NAME = "Infinite-ts.com Sys Admin";
    public static $EMAIL_ADMIN_REPLYTO_ADDRESS = "donotreply@infinite-ts.com";
    public static $EMAIL_ADMIN_REPLYTO_NAME = "";
    public static $EMAIL_ADMIN_ORDERCONF_SUBJECTLINE = "Order Submitted! (Infinite-ts.com) order#:%ORDERNUMBER%";
    public static $EMAIL_SYSADMIN_ORDER_ERR_SUBJECTLINE = "Error during order submittal (Infinite-ts.com) order#:%ORDERNUMBER%";

    private function __construct()
    {
        self::$ROOT = ITS_ROOT_DIR.self::$ROOT;
    }    
    public static function init()
    {
        new CONFIG();
    }
}
CONFIG::init();


class CONFIG_ADMINITS
{                      
    public static $DIR_COMP_IMGMNGR = "/__comp/imgManager/";
    public static $DIR_COMP_IMGMNGR_TMPLT = "/__comp/imgManager/_tmplt/";
    
    public static $DIR_SMTP = "/_smtp/";

    public static $DIR_UTIL = "/_util/";
    public static $DIR_UTIL_CODEGEN = "/_util/_codegen/";
    public static $DIR_UTIL_GUI = "/_util/gui/";
    public static $DIR_UTIL_BL = "/_util/BL/";
    public static $DIR_UTIL_DBDAL = "_util/DAL/DB/";
    public static $DIR_UTIL_HTTP = "/_util/HTTP/";
    public static $DIRINC_UTIL_HTTP = "/_util/HTTP/";
    public static $DIR_UTIL_FILE = "/_util/DAL/File/";
    public static $DIR_UTIL_PL_SYSOPS = "/_util/pl/_sysops/";
    public static $DIR_UTIL_PL_SYSOPS_BKP = "/_util/_bkp/pl/_sysops/";
    public static $DIR_UTIL_IMGRESIZER = "/_util/ImageResizer/";

    public static $DIR_UTIL_PL_WDGT_TREE = "/_util/pl/_wdgt/tree/";

    public static $DIR_TMPLT = "/_tmplt/";
    public static $DIR_TMPLT_BKP = "/_bkp/_tmplt/";

    public static $DIR_TMPLT_WEBPG = "D:/Websites/staging.TakeTheTime.ca/__tmplt/webpg/";
    public static $DIR_TMPLT_WEBPG_BKP = "D:/Websites/staging.TakeTheTime.ca/_bkp/__tmplt/webpg/";

    public static $DIR_TMPLT_WDGT = "D:/Websites/staging.TakeTheTime.ca/__tmplt/wdgt/";
    public static $DIR_TMPLT_WDGT_BKP = "D:/Websites/staging.TakeTheTime.ca/_bkp/__tmplt/wdgt/";

    public static $DIR_DBDAL = "/dal/db/";
    public static $DIR_DBDAL_BKP = "/_bkp/dal/db/";

    public static $DIR_BL = "/bl/";
    public static $DIR_BL_BKP = "/_bkp/bl/";

    public static $DIR_BL_SYSOPS = "/bl/_sysops/";
    public static $DIR_BL_SYSOPS_BKP = "/_bkp/bl/_sysops/";

    public static $DIR_PL = "/pl/";
    public static $DIR_PL_BKP = "/_bkp/pl/";

    public static $INCLUDE_DIR_UTIL_PL_GRID = "/pl/grid/";    
    public static $INCLUDE_DIR_UTIL_PL_GRID_BKP = "/_bkp/util/pl/grid/";  

    public static $INCLUDE_DIR_UTIL_PL_GRID_CLIENT = "/pl/grid/client/";    
    public static $INCLUDE_DIR_UTIL_PL_GRID_CLIENT_BKP = "/_bkp/util/pl/grid/client/";  
    
    public static $DIR_PL_SYSOPS = "/pl/_sysops/";
    public static $DIR_PL_SYSOPS_BKP = "/_bkp/pl/_sysops/";

    public static $DIR_PL_SYSOPS_CLIENT = "/pl/_sysops/client/";
    public static $DIR_PL_SYSOPS_CLIENT_BKP = "/_bkp/pl/_sysops/client/";
    
    
    public static $DIR_PL_VIEWPANEL = "/pl/viewPanel/";
    public static $DIR_PL_VIEWPANEL_BKP = "/_bkp/pl/viewPanel/";

    public static $DIR_TMPLT_VIEWPANEL = "/_tmplt/viewPanel/";
    public static $DIR_TMPLT_VIEWPANEL_BKP = "/_bkp/_tmplt/viewPanel/";

    public static $DIR_TMPLT_FRM_TABS = "/_tmplt/frm/tabs/";
    public static $DIR_TMPLT_FRM_TABS_BKP = "/_bkp/_tmplt/frm/tabs/";    

    public static $CODEGEN_DIR_TMPLT_VIEWPANEL = "/_tmplt/viewPanel/";
    public static $CODEGEN_DIR_TMPLT_VIEWPANEL_BKP = "/_bkp/_tmplt/viewPanel/";

    public static $DIR_PL_SEARCHPANEL = "/pl/searchPanel/";
    public static $DIR_PL_SEARCHPANEL_BKP = "/_bkp/pl/searchPanel/";
       
    public static $DIR_TMPLT_SEARCHPANEL = "/_tmplt/searchPanel/";
    public static $DIR_TMPLT_SEARCHPANEL_BKP = "/_bkp/_tmplt/searchPanel/";

    public static $CODEGEN_DIR_TMPLT_SEARCHPANEL = "/_tmplt/searchPanel/";
    public static $CODEGEN_DIR_TMPLT_SEARCHPANEL_BKP = "/_bkp/_tmplt/searchPanel/";

        
    public static $DIR_CACHE = "/_cache/";
    
    public static $DIR_CACHE_FRM = "/_cache/_frm/";    
    public static $DIR_CACHE_FRM_BKP = "/_bkp/_cache/_frm/";        
    
    public static $DIR_CACHE_TMPLT = "/_cache/_tmplt/";    
    public static $DIR_CACHE_TMPLT_BKP = "/_bkp/_cache/_tmplt/";

    public static $CODEGEN_DIR_GUIE = "/gui/guie/";    
    public static $CODEGEN_DIR_GUIE_BKP = "/_bkp/gui/guie/";    

    public static $CODEGEN_DIR_GUI = "/gui/";    
    public static $CODEGEN_DIR_GUI_BKP = "/_bkp/gui/";        

    public static $CODEGEN_DIR_UTIL_SYSOPS = "/util/_codegen/_sysops/";    
    public static $CODEGEN_DIR_UTIL_SYSOPS_BKP = "/_bkp/util/_codegen/_sysops/";  

    public static $CODEGEN_DIR_UTIL_CODEGEN = "/util/_codegen/";    
    public static $CODEGEN_DIR_UTIL_CODEGEN_BKP = "/_bkp/util/_codegen/";  

    public static $CODEGEN_DIR_BL = "/bl/";    
    public static $CODEGEN_DIR_BL_BKP = "/_bkp/bl/";        

    public static $CODEGEN_DIR_BL_FRM = "/bl/frm/";    
    public static $CODEGEN_DIR_BL_FRM_BKP = "/_bkp/bl/frm/";        

    public static $CODEGEN_DIR_PL_FRM_WDGT_CATTREE = "/pl/_frm/_wdgt/catTree/";    
    public static $CODEGEN_DIR_PL_FRM_WDGT_CATTREE_BKP = "/_bkp/pl/_frm/_wdgt/catTree/";            
    
    public static $CODEGEN_DIR_BL_FRM_CLIENT = "/bl/frm/client/";    
    public static $CODEGEN_DIR_BL_FRM_CLIENT_BKP = "/_bkp/bl/frm/client/";        
    
    public static $CODEGEN_DIR_SYOPS = "/bl/_sysops/";    
    public static $CODEGEN_DIR_SYOPS_BKP = "/_bkp/bl/_sysops/";    

    public static $CODEGEN_DIR_PL = "/pl/";    
    public static $CODEGEN_DIR_PL_BKP = "/_bkp/pl/";        

    public static $CODEGEN_DIR_PL_FRM = "/pl/_frm/";    
    public static $CODEGEN_DIR_PL_FRM_BKP = "/_bkp/pl/_frm/";        
                                                                                                    
    public static $CODEGEN_DIR_JS_ADMIN_MAINSCRN = "/_js/MainScrn/";
    public static $CODEGEN_DIR_JS_ADMIN_MAINSCRN_BKP = "/_bkp/_js/MainScrn/";

    public static $CODEGEN_DIR_JS_ADMIN_SYSOPS = "/_js/_sysops/";
    public static $CODEGEN_DIR_JS_ADMIN_SYSOPS_BKP = "/bkp/_js/_sysops/";

    public static $CODEGEN_DIR_JS_ADMIN_WDGT_CAT_TREE = "/_js/_wdgt/catTree/";  
    public static $CODEGEN_DIR_JS_ADMIN_WDGT_CAT_TREE_BKP = "/bkp/_js/_wdgt/catTree/";  
    
    public static $CODEGEN_DIR_UTIL_PL_GRID = "/pl/grid/";    
    public static $CODEGEN_DIR_UTIL_PL_GRID_BKP = "/_bkp/util/pl/grid/";  

    public static $CODEGEN_DIR_UTIL_PL_GRID_CLIENT = "/pl/grid/client/";    
    public static $CODEGEN_DIR_UTIL_PL_GRID_CLIENT_BKP = "/_bkp/util/pl/grid/client/";  
    
    public static $DIR_GUIE_INCLUDES = "/gui/_includes/";    
    public static $DIR_GUIE_INCLUDES_BKP = "/_bkp/gui/_includes/";    

    /** WEB REFERENCES 
    public static $DIRWEB_FRM_WDGT_CATTREE = "/adminITS/pl/_frm/_wdgt/catTree/";    
    public static $DIRWEB_JS_ADMIN_WDGT_CAT_TREE = "/adminITS/_js/_wdgt/catTree/";  
    public static $DIRWEB_FRM_VIEWPANEL = "/adminITS/pl/viewPanel/";
    public static $DIRWEB_CSS = "/adminITS/css/";
    **/

    // Holds the singleton instance
    private static $instance = null;
 
    private function __construct()
    {                 
      $class_vars = get_class_vars(get_class($this));
      foreach ($class_vars as $name => $value) {
           if ($name != "ROOT")
            self::$$name =  CONFIG::$ROOT.self::$$name;
      }          
    }       
    public static function GetInstance()
    {
        // If the instance is null, make one
        if(!self::$instance)
        {
            self::$instance = new CONFIG_ADMINITS();
        }
 
        return self::$instance;
    }  
 
}
CONFIG_ADMINITS::GetInstance();  
?>