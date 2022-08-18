<?php

require_once 'session.php';
// require_once 'includes/core.php';
require_once(realpath(dirname(__FILE__) . '/../includes/core.php'));
require_once(realpath(dirname(__FILE__) . '/../database/user_database.php'));
require_once(realpath(dirname(__FILE__) . '/file_handle.php'));

// require_once 'database/user_database.php';
// require_once 'classes/file_handle.php';

class User{

    public static function is_login(){
        return Session::isset('login');
    }
    public static function login($username,$password){
        if($found_user = User_Database::find_user($username,$password)){
            $found_user = self::fill_user_object($found_user);
            Session::set_session('auth_user',$found_user);
            Session::set_session('login',true);
            return true;
        }else{
            set_message('error','Invalid Username or Password');            
            return false;
        }
    }

    public static function logout(){        
        Session::destroy_session('login');
        redirect('index.php');
    }
    public static function get_auth_user(){
        return Session::get_session('auth_user');
    }

    public function upload_profile_image($file){        
        $old_path = $this->image_path;        
        $this->image_path = '';

        if(isset($file['tmp_name']) && !empty($file['tmp_name'])){            
            $extension = substr($file['name'],strpos($file['name'],".")+1);
            $this->image_path = get_default_path().$this->username.".".$extension;
            File_Handle::delete($old_path);
            if(!File_Handle::upload($file,$this->image_path)){
                $this->image_path = '';
            }
            return true;
        }else{
            set_message('error','unable to upload file (upload_profile_image)');
            return false;
        }
    }

    public function save(){        
        
        if(!isset($this->id)){
            return User_Database::add_user($this);
        }elseif(isset($this->password) && isset($this->id)){
            User_Database::reset_password($this);
        }elseif($this->delete_image  && isset($this->id)){
            User_Database::update_path($this->id,null);
        }else{
            
            return User_Database::edit_user($this);
        }
    }

    public function delete(){
        $profile_image = $this->image_path;
        if(User_Database::delete_user($this->id)){
            return File_Handle::delete($profile_image);
        }
    }

    public static function get_users(){
        if($items =  User_Database::get_users()){
            $users = array();
            foreach($items as $data){
                $user = self::fill_user_object($data);            
                array_push($users,$user);
            }    
            return $users;
        }else{
            return null;
        }

    }

    public static function find_user_by_id($id){
        if($found_user = User_Database::find_user_by_id($id)){
            return self::fill_user_object($found_user);            
        }else{
            set_message('error','Invalid request!');            
            return false;
        }
    }
    public static function find_user_password_by_id($id){        
        return User_Database::find_user_password_by_id($id);
    }

    private static function fill_user_object($data){
        $user = new User();
            $user->id= $data['id'];
            $user->name = $data['name'];
            $user->age = $data['age'];
            $user->username = $data['username'];
            $user->email = $data['email'];        
            $user->role = $data['role'];        
            $user->image_path = $data['image_path'];
            return $user;
    }
}