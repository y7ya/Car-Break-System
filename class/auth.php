<?php

require('appDB.php');

class auth
{

    public $db;

    public $errors = [
        'general' => [],
        'username' => [],
        'password' => [],
        'confirm_password' => [],
        'phonenumber' => [],
        'accType' => [],
    ];

    function __construct()
    {
        $this->db = new appDB();
    }

    public function register($data)
    {
        if (isset($data['username'], $data['phonenumber'], $data['password'], $data['accType'])) {
            foreach ($data as $key => $value) {
                if (empty($data[$key])) {
                    array_push($this->errors[$key], "لا يجب ان يكون الحقل فارغ");
                }
            }

            if ($this->hasErrors()) return false;

            $username = new validator('اسم المستخدم', $data['username']);
            $username->minLength(3);
            $username->maxLength(30);
            $username->enLettersNumbersOnly();
            $username->unique($this->db);
            $this->addError('username', $username->errors());


            $password = new validator('كلمة المرور', $data['password']);
            $password->minLength(6);
            $this->addError('password', $password->errors());

            $password = password_hash($data['password'], PASSWORD_DEFAULT);


            $confirm_password = new validator('تأكيد كلمة المرور', $_POST['confirm_password']);
            $confirm_password->match($data['password']);
            $this->addError('confirm_password', $confirm_password->errors());

            $phonenumber = new validator('رقم الجوال', $data['phonenumber']);
            $phonenumber->isNumric();
            $phonenumber->startWith('05');
            $phonenumber->length(10);
            $this->addError('phonenumber', $phonenumber->errors());

            $accType = new validator('نوع الحساب', $data['accType']);
            $accType->isNumric();
            $accType->isBetween(1, 2);
            if ($accType->hasErrors()) {
                $this->addError('general', ["حدث خطأ غير متوقع"]);
            }

            if (!$this->hasErrors()) {
                $stmt = $this->db->new_user($username->value(), $password, $phonenumber->value(), $accType->value());
                if ($stmt) {
                    $_SESSION['data'] = ['id'=>$stmt,'username' => $username->value(), 'phonenumber' => $phonenumber->value(),'type' => $accType->value()];
                    return true;
                }
            }
        } else {
            array_push($this->errors['general'], 'الرجاء التأكد من ملئ جميع الحقول');
        }

        return false;
    }

    public function login($data)
    {
        if (isset($data['username'], $data['password'])) {
            foreach ($data as $key => $value) {
                if (empty($data[$key])) {
                    array_push($this->errors[$key], "لا يجب ان يكون الحقل فارغ");
                }
            }

            if ($this->hasErrors()) return false;

            $username = new validator('اسم المستخدم', $data['username']);
            $exist = $username->checkUsername($this->db);
            $this->addError('username', $username->errors());

            if(!$exist){
                $this->addError('general', ['اسم المستخدم او كلمة المرور غير صحيحه']);
                return false;
            }
            
            $password = new validator('كلمة المرور', $data['password']);
            $this->addError('password', $password->errors());
            
            if(password_verify($data['password'],$exist['password'])){
                $_SESSION['data'] = ['id'=>$exist['id'],'username' => $exist['username'], 'phonenumber' => $exist['phonenumber'], 'type'=>$exist['type'],'balance',$exist['balance']];
                return true;
        }else{
                $this->addError('general', ['اسم المستخدم او كلمة المرور غير صحيحه']);
            }




        } else {
            array_push($this->errors['general'], 'الرجاء التأكد من ملئ جميع الحقول');
        }
    }

    public function addError($type, $errors)
    {
        foreach ($errors as $error) {
            array_push($this->errors[$type], $error);
        }
        // array_push($this->errors[$type],$error);
    }

    public function hasErrors()
    {
        foreach ($this->errors as $key => $value) {
            if (count($this->errors[$key]) > 0)
                return true;
        }
        return false;
    }

    public function errors()
    {
        return $this->errors;
    }
}
