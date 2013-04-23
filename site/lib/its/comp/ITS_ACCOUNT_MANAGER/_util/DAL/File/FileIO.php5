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
 
 
class FileIO
{
    public static function readFileContentsToVariable($filename)
    {
        $file = file_get_contents($filename);
        return $file;
    }
        
    public function backupFile($filename, $dir, $dirBkp)
    {
        if (file_exists($dir.$filename))
        {
            $date = DATEOBJ::getDate();
            ////$newFilename = $filename."_$date";
            ////$newFilename = str_ireplace(".","_$date.",$filename);
            $newFilename = preg_replace('#\.(?![^\.]+\.)#',"_$date.",$filename);   // uses a negative lookahead assertion to look for non-periods
            ////echo "file:$dir$filename bkpto:$dirBkp$newFilename";
            rename($dir.$filename, $dirBkp.$newFilename);
        }    
    }
                            
    public static function createFile($filename, $data, $dir, $dirBkp=null)
    {       
        if (isset($dirBkp)) FileIO::backupFile($filename, $dir, $dirBkp);  
        $fh = fopen($dir.$filename, 'w') or die("can't open file");
        fwrite($fh, $data);
        fclose($fh);
    }

    public static function writeToFile($filename, $data)
    {                                
        $fh = fopen($filename, 'w') or die("can't open file");
        fwrite($fh, $data);
        fclose($fh);
    }


    public static function appendToFile($filename, $data)
    {                                
        $fh = fopen($filename, 'a') or die("can't open file: $filename");
        fwrite($fh, $data);
        fclose($fh);
    }

    
    public static function copyFile($srcFile, $destFile)
    {
        return copy($srcFile, $destFile);
    }
    
    public static function renameFile($oldname, $newname)
    {
        return rename($oldname, $newname);
    }
    
    public static function deleteFile($filename)
    {
        unlink($filename);        
    } 

    public static function createDir($dir, $permissions=null, $recursive=false)
    {       
        
        $permissions = !isset($permissions) ? '0777' : $permissions;
        $rs = @mkdir( $dir, $permissions, $recursive);
        return $rs;
    }

    public static function chkFileExists($filename)
    {
        return file_exists($filename);
    }
    
    public function getErrMsgs()
    {
        return null;
    }
    
    public static function utilCountFiles($dir)
    {
        // create an array to hold directory list
        $files = array();

        // create a handler for the directory
        $handler = opendir($dir);

        // keep going until all files in directory have been read
        while ($file = readdir($handler)) 
        {
            // if $file isn't this directory or its parent, 
            // add it to the results array
            if ($file != '.' && $file != '..')
                $files[] = $file;
        }

        // tidy up: close the handler
        closedir($handler);
        $cnt = 0;
        foreach($files as $file)
        {
            $cnt++;
        }
        return $cnt;        
    }

    public static function utilGetFileNames($dir, $includeDirs=true)
    {
        // create an array to hold directory list
        $files = array();

        // create a handler for the directory
        $handler = opendir($dir);

        // keep going until all files in directory have been read
        while ($file = readdir($handler)) 
        {
            // if $file isn't this directory or its parent, 
            // add it to the results array
            $yesno = is_dir($file) ? "yes" : "no";
            $ext = FILEIO::utilGetFileExtension($file);             
            DBUG::OUT("is dir: $yesno  file:$file  ext:$ext");
            if (!isset($ext) || $ext=="")
                $isDir = true;
            else
                $isDir = false;                    
            if ($file != '.' && $file != '..' && ($includeDirs || !$isDir))
                $files[] = $file;
        }

        // tidy up: close the handler
        closedir($handler);
        return $files;
    }    

    public static function utilGetDirs($dir)
    {
        // create an array to hold directory list
        $files = array();

        // create a handler for the directory
        $handler = opendir($dir);

        // keep going until all files in directory have been read
        while ($file = readdir($handler)) 
        {
            // if $file isn't this directory or its parent, 
            // add it to the results array
            $yesno = is_dir($file) ? "yes" : "no";
            $ext = FILEIO::utilGetFileExtension($file);             
            DBUG::OUT("is dir: $yesno  file:$file  ext:$ext");
            if (!isset($ext) || $ext=="")
                $isDir = true;
            else
                $isDir = false;                    
            if ($isDir && $file != '.' && $file != '..' && $file != '_bkp')
                $files[] = $file;
        }

        // tidy up: close the handler
        closedir($handler);
        return $files;
    }   
    
    public static function utilGetFileExtension($filename)
    {
        preg_match("/\.([^\.]+)$/", $filename, $matches);    

        return $matches[1];        
    }
    
    public static function utilIsJPEG($filename)
    {
        return FileIO::utilGetFileExtension($filename)==FILE_EXTENSION::$jpeg;
    }
    
    public static function utilIsGIF($filename)
    {
        return FileIO::utilGetFileExtension($filename)==FILE_EXTENSION::$gif;
    }
    
    public static function utilIsPNG($filename)
    {
        return FileIO::utilGetFileExtension($filename)==FILE_EXTENSION::$png;
    }
      
    public static function utilSlash()
    {
        $path = dirname( __FILE__ );
        $slash = '/'; 
        (stristr( $path, $slash )) ? '/' : $slash = '\\';
        return $slash;    
    }
    
    public static function getCurrentDir()
    {
        return dirname( __FILE__ );
    }
    
}

class FILE_EXTENSION
{
    public static $jpeg = "jpg";
    public static $gif = "gif";
    public static $png = "png";
}

class DATEOBJ
{
    public static function getDate()
    {
        return   $sysDate = date('Ymd_His');  
    }
}

class FILENAME
{
    public static function frmSubmitCreateClient($id)
    {
        return strtoupper($id)."_SubmitCreateClient.php5";
    }    

    public static function frmEdit($id)
    {
        return strtoupper($id)."_FrmEdit.php5";
    }           

    public static function frmEditValidator($id)
    {
        return strtoupper($id)."_FrmValidatorEdit.php5";
    }           
    
    public static function frmEditClient($id)
    {
        return strtoupper($id)."_FrmEditClient.php5";
    }

    public static function frmSubmitEditClient($id)
    {
        return strtoupper($id)."_FrmSubmitEditClient.php5";
    }  
      
    public static function frmSubmitEdit($id)
    {
        return strtoupper($id)."_FrmSubmitEdit.php5";
    }    

    public static function wdgtCatTreeClient($id)
    {
        return strtoupper($id)."_CatTreeClient.php5";
    }   
    
    public static function viewPanelTmplt($id)
    {
        return "tmplt_".strtoupper($id)."_viewPanel.html";
    }
    public static function searchPanelTmplt($id)
    {
        return "tmplt_".strtoupper($id)."_searchPanel.html";
    }

    public static function gridSearch($id)
    {
        return strtoupper($id)."_GridSearch.php5";
    }

    public static function gridClass($id)
    {
        return strtoupper($id)."_Grid.php5";
    }

    public static function gridClassFct($id)
    {
        return strtoupper($id)."_GridFct.php5";
    }

    public static function gridClassClient($id)
    {
        return strtoupper($id)."_GridSearch.php5";
    }

    public static function compImgManagerAdminTmplt()
    {
        return "tmplt_imageManagerAdmin.html";
    }

    public static function jsWdgtCatTree($id)
    {
        $id_lower = strtolower($id);
        return "ecomm.admin.wdgt.cattree.$id_lower.js";
    }

    public static function jsTbSubTab($id)
    {
        $id_up = strtoupper($id);
        return "ecomm.admin.mainScrn.gns.tb$id_up.subtb.js";
    }

    public static function tbFrmSubTab($id)
    {  
        $id_up = strtoupper($id);
        return "tmplt_frm_$id_up"."_tbSubTabs.html";
    }


}

//echo DATEOBJ::getDate();

?>