<?php $auth = true;
$title = '| ' . 'تسجيل الدخول';
require('layouts/header.php');
require('class/auth.php');
require('class/validator.php');

$auth = new auth();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = $auth->login($_POST);
    foreach ($_POST as $key => $value) {
        $_SESSION['form']['login'][$key] = $_POST[$key];
    }

    if($login){
        header('Location: ' . APP_URL);
    }

} else {
    $_SESSION['form']['login']['username'] = "";
    $_SESSION['form']['login']['password'] = "";
}

?>

<body>
    <!-- Content -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="container-xxl">
                <div class="authentication-wrapper authentication-basic container-p-y">
                    <div class="authentication-inner">
                        <!-- Register -->
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mb-2">دايم في الخدمة 👋</h4>
                                <p class="mb-4">سجل دخول عشان تقدر تستخدم خدماتنا</p>
                                <?php if (isset($auth->errors()['general']) && count($auth->errors()['general']) > 0) { ?>
                                    <div class="alert alert-danger" role="alert"><?= $auth->errors()['general'][0] ?></div>
                                <?php } ?>
                                <form id="formAuthentication" class="mb-3" action="<?= APP_URL ?>login.php" method="POST">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">إسم المستخدم</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= $_SESSION['form']['login']['username'] ?>" placeholder="ادخل إسم المستخدم" autofocus />
                                        <?php if (isset($auth->errors()['username']) && count($auth->errors()['username']) > 0) { ?>
                                            <label for="username" class="form-label error"><?= $auth->errors()['username'][0] ?></label>
                                        <?php unset($_SESSION['form']['login']['username']);
                                        } ?>
                                    </div>
                                    <div class="mb-3 form-password-toggle">
                                        <label class="form-label" for="password">كلمة المرور</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="***********" aria-describedby="password" value="<?= $_SESSION['form']['login']['password'] ?>" />
                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        </div>
                                        <?php if (isset($auth->errors()['password']) && count($auth->errors()['password']) > 0) { ?>
                                            <label for="password" class="form-label error"><?= $auth->errors()['password'][0] ?></label>
                                        <?php unset($_SESSION['form']['login']['password']);
                                        } ?>

                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary d-grid w-100" type="submit">تسجيل الدخول</button>
                                    </div>
                                </form>

                                <p class="text-center">
                                    <span>ليس لديك حساب؟</span>
                                    <a href="<?= APP_URL ?>register.php">
                                        <span>تسجيل</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Register -->
                    </div>
                </div>
            </div>

            <?php require('layouts/footer.php'); ?>