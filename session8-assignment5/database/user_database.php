<?php
require_once 'includes/core.php';
require_once 'database/database.php';

class User_Database{    
    
    public static function find_user($username,$password){
        $db_connection = Database::connect();
                
        $sql = 'SELECT * FROM `users` WHERE `username`="'.$username.'" AND `password`="'.md5($password).'"';
        $result = $db_connection->query($sql);
        $db_connection->close();        
        return $result->fetch_assoc();
    }

    public static function get_users(){                
        $db_connection = Database::connect();
        $sql_query = 'SELECT * FROM users';
        $result = $db_connection->query($sql_query);
        return $result->fetch_all(MYSQLI_ASSOC);         
    }

    function add_user($user){
        $db_connection = Database::connect();
        $sql = 'INSERT INTO Users (`name`, `age`, `username`,`role`, `email`, `password`, `image_path`) 
        VALUES ("'.$user->name.'",
         "'.$user->age.'", 
         "'.$user->username.'", 
         "'.$user->role.'", 
         "'.$user->email.'", 
         "'.md5($user->password).'", 
         "'.$user->image_path.'")';
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $db_connection->insert_id;
          set_message('success','New user added successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function update_path($id,$path){
        $db_connection = Database::connect();        

        $sql = 'UPDATE users SET                  
        `image_path` ="'.$path.'"
        WHERE `id`= '.$id;        
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $conn->insert_id;
          set_message('success','Updated successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function find_user_by_id($id){
        $db_connection = Database::connect();
        $sql_query = 'SELECT * FROM users Where `id`='.$id;        
        $result = $db_connection->query($sql_query);
        return $result->fetch_assoc();  
    }

    public static function find_user_password_by_id($id){
        $db_connection = Database::connect();
        $sql_query = 'SELECT id, password FROM users Where `id`='.$id;        
        $result = $db_connection->query($sql_query);
        if($data = $result->fetch_all(MYSQLI_ASSOC)){            
            $data = $data[0];
            $user = new User();            
            $user->id = $data['id'];
            $user->password = $data['password'];
            return $user;
        } 

        return $user;   
    }

    public static function reset_password($user){
        $db_connection = Database::connect();        

        $sql = 'UPDATE users SET 
        `password` = "'.md5($user->password).'"      
        WHERE `id`= '.$user->id;        
        
        if ($db_connection->query($sql) === TRUE) {          
          set_message('success','Password reset successfully.');
          return true;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }


    public static function edit_user($user){
        $db_connection = Database::connect();        
      
        $sql = 'UPDATE users SET 
        `name` = "'.$user->name.'",
        `age` = "'.$user->age.'", 
        `username` ="'.$user->username.'", 
        `role` ="'.$user->role.'", 
        `email` ="'.$user->email.'",         
        `image_path` ="'.$user->image_path.'"
        WHERE `id`= '.$user->id;        
        
        if ($db_connection->query($sql) === TRUE) {
          $last_id = $conn->insert_id;
          set_message('success','Updated successfully.');
          return $last_id;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }

    public static function delete_user($id){    
        if($id==1){
            set_message('error','Do not delete first record');
            return false;
        }
        $db_connection = Database::connect();        
        $sql = 'DELETE FROM users WHERE `id`= '.$id;
        if ($db_connection->query($sql) === TRUE) {          
          set_message('success','User deleted successfully.');
          return true;
        } else {
            set_message('error','Error: ' . $sql . '<br>' . $db_connection->error);
            return false;
        }
    }
}