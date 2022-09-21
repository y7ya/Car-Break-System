<?php $auth = true;
$title = '| ' . 'تسجيل';

require('layouts/header.php');
require('class/auth.php');
require('class/validator.php');

$auth = new auth();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = $auth->register($_POST);
    foreach ($_POST as $key => $value) {
        $_SESSION['form']['register'][$key] = $_POST[$key];
    }
    if($user){
        header('Location: ' . APP_URL);
    }

}else{
    $_SESSION['form']['register']['username'] = "";
    $_SESSION['form']['register']['phonenumber'] = "";
    $_SESSION['form']['register']['password'] = "";
    $_SESSION['form']['register']['confirm_password'] = "";
    $_SESSION['form']['register']['accType'] = 1;
}
?>


<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">دايم موجودين 👌</h4>
                    <p class="mb-4">نساعدك وين ما تكون</p>
                    <?php if(isset($auth->errors()['general']) && count($auth->errors()['general']) > 0){ ?>
                        <div class="alert alert-danger" role="alert"><?= $auth->errors()['general'][0] ?></div>
                    <?php } ?>
                    <form id="formAuthentication" class="mb-3" action="<?= APP_URL ?>register.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">إسم المستخدم</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $_SESSION['form']['register']['username'] ?>" placeholder="ادخل إسم المستخدم" autofocus />
                            <?php if(isset($auth->errors()['username']) && count($auth->errors()['username']) > 0) { ?>
                            <label for="username" class="form-label error"><?= $auth->errors()['username'][0] ?></label>
                            <?php unset($_SESSION['form']['register']['username']); } ?>
                        </div>
                        <div class="mb-3">
                            <label for="tel_number" class="col-md-2 col-form-label">رقم الجوال</label>
                            <input class="form-control" name="phonenumber" type="tel" placeholder="0555555555" dir="rtl" id="tel_number" value="<?= $_SESSION['form']['register']['phonenumber'] ?>" />
                            <?php if(isset($auth->errors()['phonenumber']) && count($auth->errors()['phonenumber']) > 0) { ?>
                            <label for="phonenumber" class="form-label error"><?= $auth->errors()['phonenumber'][0] ?></label>
                            <?php unset($_SESSION['form']['register']['phonenumber']); } ?>
                            
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="***********" aria-describedby="password" value="<?= $_SESSION['form']['register']['password'] ?>" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <?php if(isset($auth->errors()['password']) && count($auth->errors()['password']) > 0) { ?>
                            <label for="password" class="form-label error"><?= $auth->errors()['password'][0] ?></label>
                            <?php unset($_SESSION['form']['register']['password']); } ?>
                            
                        </div>
                        
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="confirm_password">تأكيد كلمة المرور</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="***********" aria-describedby="password" value="<?= $_SESSION['form']['register']['confirm_password'] ?>" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <?php if(isset($auth->errors()['confirm_password']) && count($auth->errors()['confirm_password']) > 0) { ?>
                            <label for="confirm_password" class="form-label error"><?= $auth->errors()['confirm_password'][0] ?></label>
                            <?php unset($_SESSION['form']['register']['confirm_password']); } ?>
                            
                        </div>
                        <div class="">
                            <label class="d-block form-label">نوع الحساب</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accType" id="inlineRadio1" value="1" <?php if($_SESSION['form']['register']['accType'] == 1) echo 'checked'; ?>>
                                <label class="form-check-label" for="inlineRadio1">مستخدم</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accType" id="inlineRadio2" value="2" <?php if($_SESSION['form']['register']['accType'] == 2) echo 'checked'; ?>>
                                <label class="form-check-label" for="inlineRadio2">مساعد</label>
                            </div>
                        </div>
                        <?php if(isset($auth->errors()['accType']) && count($auth->errors()['accType']) > 0) { ?>
                            <lalbe class="form-label error"><?= $auth->errors()['accType'][0] ?></label>
                            <?php unset($_SESSION['form']['register']['accType']); } ?>



                        <div class="mb-3"></div>
                        <button class="btn btn-primary d-grid w-100">تسجيل</button>
                    </form>

                    <p class="text-center">
                        <span>لديك حساب بالفعل؟</span>
                        <a href="<?= APP_URL?>login.php">
                            <span>تسجيل الدخول</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>


<?php require('layouts/footer.php'); ?>