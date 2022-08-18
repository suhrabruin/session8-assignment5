<?php
require_once 'classes/user.php';
require_once 'classes/authentication.php';

require_once 'includes/header.php';
Authentication::is_auth();
echo "<h2>Dashboard</h2>";
require_once 'includes/footer.php';