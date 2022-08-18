<?php
require_once 'includes/core.php';
class File_Handle{
    public static function upload($file,$path){
        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_temp_name = $file['tmp_name'];
        $file_error = $file['error'];
        $file_size = $file['size'];
     
         if($file_type!='image/jpeg' && $file_type!='image/jpg' && $file_type!='image/png'){        
             set_message("error","ONLY JPEG/PNG Images are allowed");
             return false;
         }else{           
             return move_uploaded_file($file_temp_name,$path);
         }
    }

    public static function delete($path){

        if($path == get_default_path()){
            // set_message("error","Do not delete default image");
            // return false;
        }else{            
            if(file_exists($path)){
                return unlink($path);
            }else{
                // set_message("error","File not found!");
                return false;
            }
        }
        
    }

    //// These two method might be used for loggin purpose

    // public static function write_file($file_name,$data){
    //     if($fp = fopen($file_name, "w")){
    //         fwrite($fp, $data);
    //         fclose($fp); 
    //     }else{
    //         set_message('error','Unable to open file!');        
    //         return;
    //     }     
    // }

    // public static function read_file($file_name){
    //     $data = null;
    //     if($fp = fopen($file_name, "r")){
    //         $data = fread($fp,filesize($file_name));
    //         fclose($fp);
    //     }        
    //     return $data;
    // }
}