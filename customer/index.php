<?php

require('../layouts/header.php');
require('../class/appDB.php');

if (!isset($_SESSION['data']) || $_SESSION['data']['type'] != '1') header('Location: ' . APP_URL . 'login.php');
$page = 'main';
?>
<?php require('layouts/sidebar.php'); ?>
<!-- / Menu -->

<!-- Layout container -->
<div class="layout-page">

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <?php require('layouts/navbar.php'); ?>

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <?php
                $test = new appDB();
                $data = $test->get_all_services();
                $disable = $test->customer_has_active_request($_SESSION['data']['id']) ? 'disabled' : '';

                foreach ($data as $d) {
                ?>

                    <div class="col-md-4 col-lg-3 mb-3">
                        <div class="card">
                            <img class="card-img-top h-100" src="<?= $d['iamge'] ?? 'https://via.placeholder.com/500x200' ?>" alt="">
                            <div class="card-body">
                                <div class="row">
                                    <label class="card-title col-8 h5 bald"><?= $d['name'] ?></label>
                                    <label class="card-title col-4 h6"><?= $d['price'] ?> ر.س</label>
                                </div>
                                <form action="<?= APP_URL ?>customer/payment.php" method="post">
                                    <input type="hidden" name="service_id" value="<?= $d['id'] ?>">
                                    <div data-bs-toggle="tooltip" <?= $disable ? 'data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="لديك طلب بالفعل"':''; ?> >
                                        <button class="btn btn-outline-primary w-100 <?= $disable ?>" >طلب</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>






                <?php require('../layouts/footer.php'); ?>