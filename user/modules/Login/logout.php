<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: /bk_milktea/user/modules/homePage/homePage.php');
