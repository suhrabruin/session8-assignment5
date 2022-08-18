<?php
require_once 'classes/authentication.php';
require_once 'includes/header.php';
Authentication::is_auth();
echo "<h2>Posts</h2>";
require_once 'includes/footer.php';