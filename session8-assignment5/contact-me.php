<?php
require_once 'includes/core.php';
require_once 'includes/header.php';

if(!is_login()){
    header('Location:index.php');
}

echo "<h2>Contact Me</h2>";


require_once 'includes/footer.php';
