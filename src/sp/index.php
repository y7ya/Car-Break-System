<?php


require('../layouts/header.php');
require('../class/APP.php');
if (!isset($_SESSION['data']) || $_SESSION['data']['type'] != '2') header('Location: ' . APP_URL . 'login.php');
$page = 'main';

$app = new APP();

if (isset($_POST['accept'])) {
    $app->accept_request($_POST['request_id'], $_SESSION['data']['id']);
    header('Location: ' . APP_URL . 'sp/orders.php');
}
?>

<?php require('layouts/sidebar.php'); ?>
<!-- / Menu -->

<!-- Layout container -->
<div class="layout-page">

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <?php require('layouts/navbar.php'); ?>


        <?php
        $requests = $app->get_all_new_requests();
        $disable = $app->sp_has_active_request($_SESSION['data']['id']) ? 'disabled' : '';

        if (count($requests) !== 0) {
        ?>

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card">
                        <h5 class="card-header">طلباتي</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>الخدمة</th>
                                        <th>العنوان</th>
                                        <th>العميل</th>
                                        <th>رقم الجوال</th>
                                        <th>السعر</th>
                                        <th>حالة الطلب</th>
                                        <th>وقت الطلب</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php 
                                    
                                    foreach ($requests as $request) {
                                        $customer_id = null;
                                        if ($request['customer_id'] != null) $customer_id = $app->get_user_data_by_id($request['customer_id']);

                                    ?>
                                        <tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>#<?= $request['id'] ?></strong></td>
                                            <td><?= $app->get_service_name_by_id($request['service_id']) ?></td>
                                            <td><?= $request['address'] ?></td>
                                            <td><?= $customer_id['username'] ?? 'لم يحدد بعد' ?></td>
                                            <td><?= $customer_id['phonenumber'] ?? 'لم يحدد بعد' ?></td>
                                            <td><?= $request['price'] ?></td>
                                            <td><?= $app->status_format($request['status']); ?></td>
                                            <td><?= (new DateTime($request['created_at']))->format('h:i:s | Y-m-d') ?></td>
                                            <td>

                                                <div class="dropdown" style="position: static !important;">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                            <input class="dropdown-item" type="submit" name="accept" value='قبول' <?= $disable ?>>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>



                <?php require('../layouts/footer.php'); ?>