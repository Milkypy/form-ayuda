<?php
//destroy any session variables
session_start();
// remove all session variables
session_unset();
session_destroy();
//redirect to login page
header('Location: /acceso');