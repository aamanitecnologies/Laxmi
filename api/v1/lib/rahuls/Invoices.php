<?php

/**
 * @desc   BatchCodes
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Invoices {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Edit Invoice
    public function editPayFee($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE invoices SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;
            $data['id'] = $id;
            $result["payload"]["invoice"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Get bank detail By ifsc code
    public function getBankDetail($ifsc_code) {
        $sql = "SELECT * FROM bank_detail WHERE ifsc_code LIKE  '%$ifsc_code%' LIMIT 10";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["bank_details"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["bank_details"] = $result;
        }
        return $result;
    }

}

?>
