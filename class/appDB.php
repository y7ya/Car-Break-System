<?php

class appDB
{

    public $conn;

    function __construct()
    {
        try {
            $this->conn = new mysqli(DB_CREDS['host'], DB_CREDS['username'], DB_CREDS['password'], DB_CREDS['dbname'],DB_CREDS['port']);
        } catch (Exception $e) {
            die("Can't connect to DB");
        }
    }

    public function new_user($username, $password, $phonenumber, $type)
    {
        $statment = $this->conn->prepare("INSERT INTO users (username,phonenumber,password,type) VALUES (?,?,?,?)");
        $statment->bind_param('ssss', $username, $phonenumber, $password, $type);
        if ($statment->execute()) return $statment->insert_id;
        $statment->close();
    }

    public function get_all_services()
    {
        $stmt = $this->conn->prepare('SELECT * FROM services');
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function get_service_by_id(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM services where id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $value = $data ?? false;
        return $value;
    }

    public function newRequest($customerID, $serviceID, $address, $price)
    {
        $stmt = $this->conn->prepare("INSERT INTO requests (customer_id,service_id,address,price) VALUES (?,?,?,?)");
        $stmt->bind_param('iiss', $customerID, $serviceID, $address, $price);
        if ($stmt->execute()) return true;
    }

    public function get_all_request_by_ID($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM requests where customer_id=? ORDER BY status");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function get_service_name_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT name FROM services where id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_column();
        $value = $data ?? false;
        return $value;
    }

    public function get_user_data_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users where id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $value = $data ?? false;
        return $value;
    }

    public function status_format($status)
    {
        if ($status == 1) {
            return '<span class="badge bg-label-primary me-1">جديد</span>';
        } else if ($status == 2) {
            return '<span class="badge bg-label-primary me-1">تم قبول الطلب</span>';
        } else if ($status == 3) {
            return '<span class="badge bg-label-primary me-1">تم</span>';
        } else if ($status == 4) {
            return '<span class="badge bg-label-danger me-1">ملغي</span>';
        }
    }

    public function cancel_order($id){
        $stmt = $this->conn->prepare("UPDATE requests SET status=4 WHERE id=?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

}
