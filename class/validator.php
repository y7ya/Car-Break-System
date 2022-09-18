<?php
class validator{
    public $item;  // Item could be إسم المستخدم
    public $value; // value ahmed
    
    public $errors = [];


    function __construct($item,$value)
    {
        $this->item = $item;
        $this->value = $value;
    }

    function minLength(int $min){
        (strlen($this->value) >= $min)?:$this->addError("$min هو الحد الأدنى ل$this->item");
    }
    
    function maxLength(int $max){
        (strlen($this->value) <= $max)?:$this->addError("$max هو الحد الإقصى ل$this->item");
    }
    
    function length(int $len){
        (strlen($this->value) == $len)?:$this->addError("يجب ان يتكون $this->item من $len خانات");
    }
    
    function enLettersNumbersOnly(){
        (preg_match('/^[A-Za-z][A-Za-z0-9]*$/', $this->value))?:$this->addError("يجب ان يبدأ $this->item بحرف ويتكون من حروف انجليزية و ارقام فقط");
    }

    function startWith($prefix){
        (str_starts_with($this->value,$prefix))?:$this->addError("$this->item يجب ان يبدأ ب$prefix");
        return (str_starts_with($this->value,$prefix));
    }

    function isNumric(){
        (is_numeric($this->value))?:$this->addError("$this->item يجب ان يتكون من ارقام فقط");
    }
    
    function isBetween($min,$max){
        ($this->value >= $min && $this->value <= $max)?:$this->addError("يجب ان يكون $this->item بين $min و $max");
    }

    function match($password){
        ($this->value === $password)?:$this->addError("كلمة المرور غير متطابقة");
    }

    function unique($db){
        $stmt = $db->conn->prepare("SELECT username FROM users where username=?");
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows > 0) $this->addError("$this->item مستخدم مسبقًا");
    }

    function checkUsername($db){
        $stmt = $db->conn->prepare("SELECT * FROM users where username=?");
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        $result = $stmt->get_result();  
        if(($data = $result->fetch_assoc()) > 0){
            return $data;
        }else{
            return false;
        }
    }

    function addError(String $error){
        array_push($this->errors,$error);
    }

    function errors(){
        // var_dump($this->errors());
        return $this->errors;
    }

    function hasErrors(){
        return ($this->errors() !== []);
    }

    function value()
    {
        return $this->value;
    }

}
