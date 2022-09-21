<?php


require('layouts/header.php');

if (!isset($_SESSION['data'])) header('Location: ' . APP_URL . 'login.php');

if ($_SESSION['data']['type'] == 1) {
    header('Location: ' . APP_URL . 'customer/');
} else if ($_SESSION['data']['type'] == 2) {    
    header('Location: ' . APP_URL . 'sp/');
}
?>
          

<?php require('layouts/footer.php'); ?>