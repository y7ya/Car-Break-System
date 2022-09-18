<?php

    require(dirname(__FILE__) . '/../config/config.php');
    session_start();
?>
<!DOCTYPE html>

<html lang="ar" class="light-style layout-menu-fixed" dir="rtl" data-theme="theme-default" data-assets-path="<?= APP_URL ?>/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= APP_NAME . ' ' . ($title ?? null) ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= APP_URL ?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet"> 

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/libs/apex-charts/apex-charts.css" />


    <?php if(isset($auth) && $auth){ ?>
        <link rel="stylesheet" href="<?= APP_URL ?>/assets/vendor/css/pages/page-auth.css" />
    <?php } ?>
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= APP_URL ?>/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= APP_URL ?>/assets/js/config.js"></script>
</head>

<body>
        <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->