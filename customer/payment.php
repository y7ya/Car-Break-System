<?php $auth = true;
$title = '| ' . 'الدفع';

require('../layouts/header.php');
require('../class/appDB.php');
if(!isset($_SESSION['data']) && $_SESSION['data'] != 1) header('Location: ' . APP_URL .'login.php');
if($_SERVER['REQUEST_METHOD'] !== "POST") header('Location: '. APP_URL.'customer/');
if(!isset($_POST['service_id'])) header('Location: '. APP_URL.'customer/');



$db = new appDB();
$service = $db->get_service_by_id($_POST['service_id']);
if(!$service)header('Location: '. APP_URL.'customer/');

if(isset($_POST['pay'])){
    var_dump($_SESSION['data']);

    $req = $db->newRequest($_SESSION['data']['id'],$service['id'],$_POST['address'],$service['price']);
    if($req)header('Location: '. APP_URL.'customer/orders.php');
}
?>


<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2"><?= $service['name'] ?></h4>
                    <p class="mb-4">السعر الإجمالي: <?= $service['price'] ?> ريال</p>
                    <form id="formAuthentication" class="mb-3" action="<?= APP_URL ?>customer/payment.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="username" name="address" value="" placeholder="ادخل العنوان" autofocus />
                            <input type="hidden" class="form-control" id="service_id" name="service_id" value="<?= $service['id'] ?>" autofocus />
                        </div>

                        <div class="divider">
                            <div class="divider-text">الدفع </div>
                        </div>
                        <div class="mb-3"></div>
                        <div class="my-3">
                            <label for="username" class="form-label">الإسم</label>
                            <input type="text" class="form-control" id="username" name="username" value="" placeholder="الاسم الذي على البطاقة" autofocus />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">رقم البطاقة</label>
                            <input type="text" class="form-control" id="username" name="username" value="" placeholder="رقم البطاقة" autofocus />
                        </div>
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="username" class="form-label">تاريخ الانتهاء</label>
                                <input type="text" class="form-control" id="username" name="username" value="" placeholder="24/04" autofocus />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="username" class="form-label">CCV</label>
                                <input type="text" class="form-control" id="username" name="username" value="" placeholder="***" autofocus />
                            </div>
                        </div>
                        <input class="btn btn-primary d-grid w-100" type="submit" name="pay" value="ادفع الآن">

                    </form>

                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>


<?php require('../layouts/footer.php'); ?>