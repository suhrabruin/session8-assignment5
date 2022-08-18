<?php
// require_once 'database/user_database.php';
require_once 'user.php';

class Authentication{
    public static function authenticate($username,$password){               
        return User::login($username,$password);        
    }

    public static function is_auth(){
        if(!User::is_login()){
            redirect('index.php');
        }
    }
    
}