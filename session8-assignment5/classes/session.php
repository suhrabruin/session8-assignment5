<?php

session_start();

class Session{
    public static function set_session($name,$value){
        $_SESSION[$name] = $value;        
    }

    public static function get_session($name){
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    public static function destroy_session($name){
        $_SESSION[$name] = false;
        session_destroy();
    }

    public static function isset($name){        
        return isset($_SESSION[$name]);
    }
}