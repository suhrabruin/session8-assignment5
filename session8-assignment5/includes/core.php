<?php
 require_once 'classes/session.php';

 
//  function __autoload($className) {
//     $filename = $className . ".php";
//     if (is_readable($filename)) {
//         require $filename;
//     }
// }

function set_message($name,$message){
    Session::set_session($name,$message);
}

function get_message($name){
    $msg =  Session::get_session($name);
    Session::set_session($name,null);    
    return $msg;
}

function redirect($redirect_to){      
    header('Location: '.$redirect_to);
    exit;
}

function get_default_path(){
    return 'storage/images/';
}

function get_default_image(){
    return get_default_path().'profile-demo.png';
}


function is_empty($field,$field_name){
    $field_name = ucwords(str_replace('_', ' ', $field_name));    
    if(empty($field)){
        return "{$field_name} field is required!";
    }
    return null;
}