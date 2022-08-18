<?php
require_once 'includes/header.php';
require_once 'classes/user.php';

?>

<!-- **** -->
<!--Display Users Page -->
<!-- **** -->
<?php if(isset($_GET['users'])){  
    $users = User::get_users();
?>
<h2>Users</h2>
<span class="error"><?php echo get_message('error');?></span><br/>
<a href="user_controller.php?register=true" class="btn-register btn">Register</a>
<div class="users">
    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Image Path</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($users as  $user):?>
            <tr>
                <td><?php echo $user->id;?></td>
                <td><?php echo $user->name;?></td>
                <td><?php echo $user->age;?></td>
                <td><?php echo $user->username;?></td>
                <td><?php echo $user->role;?></td>
                <td><?php echo $user->email;?></td>
                <td><?php 
                if(!empty($user->image_path)){
                    echo $user->image_path;
                    ?>
                    <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user_controller.php?delete_image=true&id=<?php echo $user->id;?>&path=<?php echo $user->image_path;?>" onclick="return confirm('Are you sure to delete?')">Delete File</a>
                <?php } ?>
            </td>
                <td><a style="background:green;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user_controller.php?edit=true&id=<?php echo $user->id;?>">Edit</a>
                <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user_controller.php?delete=true&id=<?php echo $user->id;?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
                <a style="background:blue;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user_controller.php?details=true&id=<?php echo $user->id;?>">Details</a></td>                
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<!-- **** -->
<!-- Display Register Page -->
<!-- **** -->
<?php }elseif(isset($_GET['register'])){  ?>

<h2>Register</h2>

<div id="register-div">
    <h3>User Registration Form</h3>
    <?php 
    $error[] = get_message('errors');
    $error = $error[0];
    $temp_user = get_message('temp_user');    
    ?>
    <form action="user_controller.php" method="post" id="register_form" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input class="user-input" type="text" name="name" id="name" placeholder="Name" 
        value="<?php echo isset($temp_user->name)?$temp_user->name:"";?>"/>
        <span class="error"><?php echo isset($error['name'])?$error['name']:"";?></span><br/>

        <label for="age">Age:</label>
        <input class="user-input" type="text" name="age" id="age" placeholder="Age"
        value="<?php echo isset($temp_user->age)?$temp_user->age:"";?>"/>
        <span class="error"><?php echo isset($error['age'])?$error['age']:"";?></span><br/>

        <label for="email">Email:</label>
        <input class="user-input" type="email" name="email" id="email" placeholder="Email"
        value="<?php echo isset($temp_user->email)?$temp_user->email:"";?>"/>
        <span class="error"><?php echo isset($error['email'])?$error['email']:"";?></span><br/>
        
        <label for="username">Username:</label>            
        <input class="user-input" type="text" name="username" placeholder="Username"
        value="<?php echo isset($temp_user->username)?$temp_user->username:"";?>"/>
        <span class="error"><?php echo isset($error['username'])?$error['username']:"";?></span><br/>
        
        


        <label for="role">Role:</label>
        <select class="user-select" name="role" id="role">
            <option disabled>User Role</option>
            <option value="Admin" <?php echo (isset($temp_user->role) && $temp_user->role=="Admin")? "selected":""; ?>>Admin</option>
            <option value="Author" <?php echo (isset($temp_user->role) && $temp_user->role=="Author")? "selected":""; ?>>Author</option>
            <option value="Editor" <?php echo (isset($temp_user->role) && $temp_user->role=="Editor")? "selected":""; ?>>Editor</option>            
        </select>        
        <span class="error"><?php echo isset($error['role'])?$error['role']:"";?></span><br/>
        
        <label for="password">Password:</label>            
        <input class="user-input" type="password" name="password" placeholder="Password"
        value="<?php echo isset($temp_user->password)?$temp_user->password:"";?>"/>
        <span class="error"><?php echo isset($error['password'])?$error['password']:"";?></span><br/>
        
        <label for="c_password">Confirm Password:</label>
        <input class="user-input" type="password" name="c_password" id="c_password" placeholder="Confirm your password"
        value="<?php echo isset($temp_user->c_password)?$temp_user->c_password:"";?>"/>
        <span class="error"><?php echo isset($error['c_password'])?$error['c_password']:"";?></span><br/>
        
        <label for="profile_image">Upload Your Photo</label>
        <input class="user-input" type="file" name="profile_image" id="profile_image" /><br/>

        <input type="submit" name="register_user" id="btn-register" value="Register"/>            
    </form>                
    <p class="error"><?php print_r(get_message('error'));?></p>
</div>

<!-- **** -->
<!-- User Registration Process -->
<!-- **** -->
<?php }elseif(isset($_POST['register_user'])){
    
    $user = new User();    
    $user->name = !empty(trim($_POST['name']))?trim($_POST['name']):null;
    $user->age = (int)$_POST['age'];
    $user->email = trim($_POST['email']);
    $user->username = !empty(trim($_POST['username']))?trim($_POST['username']):null;
    $user->role = $_POST['role'];
    $user->password = $_POST['password'];
    $c_password = $_POST['c_password'];

    $errors = null;
    if(empty($user->name)){
        $errors['name'] = 'Name field is required!';
    }
    if(empty($user->age)){
        $errors['age'] = 'Age field is required!';
    }
    if(empty($user->email)){
        $errors['email'] = 'Email field is required!';
    }
    if(empty($user->username)){
        $errors['username'] = 'Username field is required!';
    }
    if(empty($user->role)){
        $errors['role'] = 'Role field is required!';
    }
    if(empty($user->password)){
        $errors['password'] = 'Password field is required!';
    }
    if(empty($c_password)){
        $errors['c_password'] = 'Confirm Password field is required!';
    }elseif($user->password !==$c_password){
        $errors['c_password'] = 'Password and Confirm Password fields do not match!';
    }

    set_message('errors',$errors);
    if(empty($errors)){
        if(isset($_FILES['profile_image']['tmp_name']) && !empty($_FILES['profile_image']['tmp_name'])){
            $file = $_FILES['profile_image'];            
            $extension = substr($file['name'],strpos($file['name'],".")+1);
            $user->image_path = get_default_path().$user->username.".".$extension;
            if($user->save()){
                File_Handle::upload($file,$user->image_path);
            }
        }else{
            $user->save();
        }
        redirect('user_controller.php?users=true');
    }else{        
        $user->c_password = $c_password;
        set_message('temp_user',$user);
        redirect('user_controller.php?register=true');
    }
?>
<!-- **** -->
<!-- Edit User -->
<!-- **** -->
<?php
 }elseif(isset($_GET['edit'])){
    $id = (int)$_GET['id'];
    $user = User::find_user_by_id($id);
?>
<h2>Edit</h2>
<div id="register-div">
        <h3>User Edit Form</h3>
        <span class="error"><?php echo get_message('error');?></span><br/>
        <?php 
        $error[] = get_message('errors');
        $error = $error[0];
        ?>
        <form action="user_controller.php" method="post" id="register_form" enctype="multipart/form-data">
        <input class="user-input" type="hidden" name="id" id="id" value="<?php echo isset($user->id)?$user->id:"";?>"/>
            <label for="name">Name:</label>
            <input class="user-input" type="text" name="name" id="name" placeholder="Name" 
            value="<?php echo isset($user->name)?$user->name:"";?>"/>
            <span class="error"><?php echo isset($error['name'])?$error['name']:"";?></span><br/>

            <label for="age">Age:</label>
            <input class="user-input" type="text" name="age" id="age" placeholder="Age"
            value="<?php echo isset($user->age)?$user->age:"";?>"/>
            <span class="error"><?php echo isset($error['age'])?$error['age']:"";?></span><br/>

            <label for="email">Email:</label>
            <input class="user-input" type="email" name="email" id="email" placeholder="Email"
            value="<?php echo isset($user->email)?$user->email:"";?>"/>
            <span class="error"><?php echo isset($error['email'])?$error['email']:"";?></span><br/>
            
            <label for="username">Username:</label>            
            <input class="user-input" type="username" name="username" placeholder="Username"
            value="<?php echo isset($user->username)?$user->username:"";?>"/>
            <span class="error"><?php echo isset($error['username'])?$error['username']:"";?></span><br/>
            
            <label for="role">Role:</label>
        <select class="user-select" name="role" id="role">
            <option disabled>User Role</option>
            <option value="Admin" <?php echo (isset($user->role) && $user->role=="Admin")? "selected":""; ?>>Admin</option>
            <option value="Author" <?php echo (isset($user->role) && $user->role=="Author")? "selected":""; ?>>Author</option>
            <option value="Editor" <?php echo (isset($user->role) && $user->role=="Editor")? "selected":""; ?>>Editor</option>            
        </select>        
        <span class="error"><?php echo isset($error['role'])?$error['role']:"";?></span><br/>
            <label for="profile_image">Upload Your Photo</label>
            <input class="user-input" type="file" name="profile_image" id="profile_image" /><br/>
            <input type="submit" name="edit_user" id="btn-register" value="Edit"/>            
        </form>                
        <p class="error"><?php print_r(get_message('error'));?></p>
    </div>
<!-- **** -->
<!-- Edit Process -->
<!-- **** -->
<?php }elseif(isset($_POST['edit_user'])){  

    $id = (int)$_POST['id'];    
   $user = User::find_user_by_id($id);
    
    $user->name = !empty(trim($_POST['name']))?trim($_POST['name']):null;
    $user->age = (int)$_POST['age'];
    $user->email = trim($_POST['email']);
    $user->username = !empty(trim($_POST['username']))?trim($_POST['username']):null;
    $user->role = $_POST['role'];

    $errors = null;
    if(empty($user->name)){
        $errors['name'] = 'Name field is required!';
    }
    if(empty($user->age)){
        $errors['age'] = 'Age field is required!';
    }
    if(empty($user->email)){
        $errors['email'] = 'Email field is required!';
    }
    if(empty($user->username)){
        $errors['username'] = 'Username field is required!';
    }
    if(empty($user->role)){
        $errors['role'] = 'Role field is required!';
    }

    
    set_message('errors',$errors);
    if(empty($errors)){
        if(isset($_FILES['profile_image']['tmp_name']) && !empty($_FILES['profile_image']['tmp_name'])){            
            $user->upload_profile_image($_FILES['profile_image']);
        }
        $user->save();
        redirect('user_controller.php?users=true');
    }
    redirect("user_controller.php?edit=true&id={$id}");
?>

<!-- **** -->
<!-- Delete User Profile Image Process -->
<!-- **** -->
<?php
 }elseif(isset($_GET['delete_image'])){  
   
    $id = (int)$_GET['id'];
    $user = User::find_user_by_id($id);

    $path = $user->image_path;
    $user->image_path = '';
    $user->delete_image=true;//just temporary 

    if(file_exists($path)){
        if(unlink($path)){
            // $user->save();
        }   
    }
    $user->save();
    
    redirect('user_controller.php?users=true');
?>

<!-- **** -->
<!-- Delete User record -->
<!-- **** -->
<?php
 }elseif(isset($_GET['delete'])){  
     
    $id = (int)$_GET['id'];
    if($user = User::find_user_by_id($id)){   
        $user->delete();
    }else{
        set_message("error","User not found!");
    }
    redirect('user_controller.php?users=true');
?>

<!-- **** -->
<!-- Display User details page-->
<!-- **** -->
<?php
}elseif(isset($_GET['details'])){
    $id = (int)$_GET['id'];
    $user = User::find_user_by_id($id);
?>
    <h2>User Details</h2>
    <span class="error"><?php echo get_message('error');?></span><br/>
    <div class="profile">
        <div class="profile-img-div">
            <img class="profile-img" src="<?php 
            if(isset($user->image_path)  && !empty($user->image_path) && file_exists($user->image_path)){
                echo $user->image_path;
            }else{
                echo get_default_image();
            } 
            ?>" alt="Profile Picture"/>
        </div>
        <div>
            <p class="profile-id"><span>ID:</span><?php echo $user->id;?></p>
            <p class="profile-name"><span>Name:</span><?php echo $user->name;?></p>
            <p class="profile-age"><span>Age:</span><?php echo $user->age;?></p>
            <p class="profile-username"><span>Username:</span><?php echo $user->username;?></p>
            <p class="profile-email"><span>Email:</span><?php echo $user->email;?></p>
        </div>
    </div>

<!-- **** -->
<!-- Display User Profile Page -->
<!-- **** -->
<?php }elseif(isset($_GET['profile'])){
$auth_user = User::get_auth_user();
$user = User::find_user_by_id($auth_user->id);
?>
<h2>My Profile</h2>
<span class="error"><?php echo get_message('error');?></span><br/>
<div class="profile">
    <div class="profile-img-div">
        <img class="profile-img" src="<?php
        
        if(isset($user->image_path)  && !empty($user->image_path) && file_exists($user->image_path)){
            echo $user->image_path;
        }else{
            echo get_default_image();
        }         
        ?>" alt="Profile Picture"/>
        <form action="user_controller.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo $user->id;?>">            
            <input type="file" name="profile_image">
            <input class="btn" type="submit" name="upload_profile_image" value="Upload"/>
        </form>
    </div>
    <div>
        <p class="profile-id"><span>ID:</span><?php echo $user->id;?></p>
        <p class="profile-name"><span>Name:</span><?php echo $user->name;?></p>
        <p class="profile-age"><span>Age:</span><?php echo $user->age;?></p>
        <p class="profile-username"><span>Username:</span><?php echo $user->username;?></p>
        <p class="profile-email"><span>Email:</span><?php echo $user->email;?></p>
    </div>
</div>

<!-- **** -->
<!-- Display Password Reset Page -->
<!-- **** -->
<?php }elseif(isset($_GET['reset_password'])){  
    $error[] = get_message('errors');
    $error = $error[0]; 
?>
<div style="width:300px; box-shadow: 0 0 1px black; padding:15px;">
    <form action="user_controller.php" method="post" id="register_form">
        <label for="old_password">Current Password:</label>            
        <input class="user-input" type="password" name="old_password" placeholder="Current Password"/>
        <span class="error"><?php echo isset($error['old_password'])?$error['old_password']:"";?></span><br/>
        
        <label for="new_password">New Password:</label>            
        <input class="user-input" type="password" name="new_password" placeholder="New Password"/>
        <span class="error"><?php echo isset($error['new_password'])?$error['new_password']:"";?></span><br/>
        
        <label for="c_password">Confirm New Password:</label>
        <input class="user-input" type="password" name="c_password" id="c_password" placeholder="Confirm your new password"/>
        <span class="error"><?php echo isset($error['c_password'])?$error['c_password']:"";?></span><br/>
        
        <input class="btn" type="submit" name="submit_reset_password" id="btn-register" value="Reset"/>
    </form>
</div>
<!-- **** -->
<!-- Password reset process -->
<!-- **** -->
<?php }elseif(isset($_POST['submit_reset_password'])){ 

    $auth_user = User::get_auth_user();
    $user = User::find_user_password_by_id($auth_user->id);

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $c_password = $_POST['c_password'];
    $errors = array();

    if(empty($old_password)){
        $errors['old_password'] = 'Current Password field is required!';
    }elseif($user->password !==md5($old_password)){
        $errors['old_password'] = 'Current password is not valid.';
    }
    if(empty($new_password)){
        $errors['new_password'] = 'New Password field is required!';
    }
    if(empty($c_password)){
        $errors['c_password'] = 'Confirm Password field is required!';
    }elseif($new_password !==$c_password){
        $errors['c_password'] = 'Password and Confirm Password fields do not match!';
    }
    set_message('errors',$errors);
    if(empty($errors)){
        $user->password = $new_password;
        $user->save();
        redirect('login_controller.php?logout=true');
    }

    redirect('user_controller.php?reset_password=true');
?>

<!-- **** -->
<!-- Upload Profile Image Process -->
<!-- **** -->
<?php }elseif(isset($_POST['upload_profile_image'])){
        $id = (int)$_POST['user_id'];
        $user = User::find_user_by_id($id);
        if($user->upload_profile_image($_FILES['profile_image'])){
            $user->save();
        }
        redirect('user_controller.php?profile=true');
  } ?>
<?php
require_once 'includes/footer.php';
