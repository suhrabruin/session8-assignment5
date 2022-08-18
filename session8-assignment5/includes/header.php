<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php 
require_once(realpath(dirname(__FILE__) . '/../config.php'));
require_once SITE_ROOT.'/classes/authentication.php';

$auth = $_SESSION['auth_user'];


Authentication::is_auth();
   
  ?>
    <div class="main-wrapper">
        <div class="header-menu">
            <ul>
                <li class="btn-home"><a href="<?php echo ROOT_URL;?>/dashboard.php">Home</a></li>
                <li class="btn-post"><a href="<?php echo ROOT_URL;?>/post_controller.php">Posts</a></li>
                <li class="btn-user"><a href="<?php echo ROOT_URL;?>/user_controller.php?users=true">Users</a></li>                
                <li class="btn-profile"><a href="<?php echo ROOT_URL;?>/user_controller.php?profile=true">Profile</a></li>
                <li class="btn-reset-password"><a href="<?php echo ROOT_URL;?>/user_controller.php?reset_password=true">Reset Password</a></li>
                <li class="btn-logout"><a href="<?php echo ROOT_URL;?>/login_controller.php?logout=true">Logout</a></li>
            </ul>
        </div>
          <?php if($_SESSION['login']){ ?>
            <p style="text-align:right;"><span >Dear <em><?php echo ucwords($auth->name);?></em> please logout once done!</span></p>
          <?php } ?>        
        <div class="content-wrapper">
        <h1 style="text-align:center;">Session 8 - Assignment 5</h1>
        <p class="success"><?php echo get_message('success');?></p>
        <p class="error"><?php echo get_message('error');?></p>
