<?php

require('config/config.php');

session_start();
session_unset();
session_destroy();
header('Location: ' . APP_URL);
?>