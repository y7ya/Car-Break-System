<?php


require('../layouts/header.php');
require('../class/APP.php');
if (!isset($_SESSION['data']) || $_SESSION['data']['type'] != '2') header('Location: ' . APP_URL . 'login.php');
$page = 'orders';
$app = new APP();
if (isset($_POST['cancel'])) {
    $app->cancel_order($_POST['request_id']);
} else if (isset($_POST['done'])) {
    $app->finish_request($_POST['request_id'], $_SESSION['data']['id']);
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
        $requests = $app->get_sp_requests_by_ID($_SESSION['data']['id']);
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
                                    <?php foreach ($requests as $request) {
                                        $service_provider = null;
                                        if ($request['service_provider_id'] != null) $service_provider = $app->get_user_data_by_id($request['service_provider_id']);

                                    ?>
                                        <tr>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>#<?= $request['id'] ?></strong></td>
                                            <td><?= $app->get_service_name_by_id($request['service_id']) ?></td>
                                            <td><?= $request['address'] ?></td>
                                            <td><?= $service_provider['username'] ?? 'لم يحدد بعد' ?></td>
                                            <td><?= $service_provider['phonenumber'] ?? 'لم يحدد بعد' ?></td>
                                            <td><?= $request['price'] ?></td>
                                            <td><?= $app->status_format($request['status']); ?></td>
                                            <td><?= (new DateTime($request['created_at']))->format('h:i:s | Y-m-d') ?></td>
                                            <td>
                                                <?php if ($request['status'] != 4) { ?>
                                                    <div class="dropdown" style="position: static !important;">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <?php if ($request['status'] == 3) { ?>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                                    <input class="dropdown-item" type="submit" name="show_receipt" value='عرض الفاتورة'>
                                                                </form>
                                                                <!-- <a class="dropdown-item" href=""></a> -->
                                                            <?php } else { ?>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                                    <button class="dropdown-item btn btn-outline-primary" name="done" type="submit"><i class="bx bx-check-square"></i> تم</button>
                                                                </form>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                                    <button class="dropdown-item btn btn-outline-danger" name="cancel" type="submit"><i class="bx bx-x-circle"></i> الغاء</button>
                                                                </form>
                                                            <?php } ?>
                                                            <!-- <a class="dropdown-item" href=""></a> -->
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>



                <?php require('../layouts/footer.php'); ?>