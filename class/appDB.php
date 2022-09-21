<?php

class appDB
{

    public $conn;

    function __construct()
    {
        try {
            $this->conn = new mysqli(DB_CREDS['host'], DB_CREDS['username'], DB_CREDS['password'], DB_CREDS['dbname'], DB_CREDS['port']);
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

    // public function get_all_request_by_ID($id)
    public function get_customer_requests_by_ID($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM requests where customer_id=? ORDER BY status");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function get_sp_requests_by_ID($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM requests where service_provider_id=? ORDER BY status");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function get_all_new_requests()
    {
        $stmt = $this->conn->prepare("SELECT * FROM requests where status=1 ORDER BY created_at");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }


    public function accept_request($id, $sp_id)
    {
        $stmt = $this->conn->prepare("UPDATE requests SET status=2,service_provider_id=? WHERE id=?");
        $stmt->bind_param('ii', $sp_id, $id);
        return $stmt->execute();
    }


    public function finish_request($req_id, $sp_id)
    {
        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare("UPDATE requests SET status=3 WHERE id=?");
            $stmt->bind_param('i', $req_id);
            $stmt->execute();


            $stmt = $this->conn->prepare("UPDATE users SET balance=balance+? WHERE id=?");
            $price = doubleval($this->get_request_price_by_id($req_id));
            $stmt->bind_param('ii', $price, $sp_id);
            $stmt->execute();

            $this->conn->commit();
        } catch (\mysqli_sql_exception $exception) {
            $this->conn->rollback();
            throw $exception;
        }
    }



    public function get_user_balance($id)
    {
        $stmt = $this->conn->prepare("SELECT balance FROM users where id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_column();
        $value = $data ?? false;
        return $value;
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

    public function get_request_price_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT price FROM requests where id=?");
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
            return '<span class="badge bg-info me-1">جديد</span>';
        } else if ($status == 2) {
            return '<span class="badge bg-primary me-1">تم قبول الطلب</span>';
        } else if ($status == 3) {
            return '<span class="badge bg-success me-1">تم الانتهاء من الطلب</span>';
        } else if ($status == 4) {
            return '<span class="badge bg-danger me-1">ملغي</span>';
        }
    }

    public function cancel_order($id)
    {
        $stmt = $this->conn->prepare("UPDATE requests SET status=4 WHERE id=?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function customer_has_active_request($id){
        $stmt = $this->conn->prepare("SELECT * FROM requests where customer_id=? and (status=1 OR status=2)");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->num_rows ?? false;
        return $value;
    }

    public function sp_has_active_request($id){
        $stmt = $this->conn->prepare("SELECT * FROM requests where service_provider_id=? and (status=1 OR status=2)");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->num_rows ?? false;
        return $value;
    }
}
