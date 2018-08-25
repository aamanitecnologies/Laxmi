<?php

/**
 * @desc   Login API
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Products {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    public function getAllProducts() {
        $sql = "SELECT * from products where deleted=0";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $rows = array();
            while ($row = $data->fetch_assoc()) {
                array_push($rows, $row);
            }
            $results = array(
                'status' => array(
                    'error' => false,
                    'message' => 'success'
                ),
                'payload' => array(
                    'machine' => $rows
                )
            );
        } else {
            $results = array(
                'status' => array(
                    'error' => true,
                    'message' => $this->conn->error
                ),
            );
        }
        return $results;
    }

    public function getProductById($id) {
        $sql = "SELECT * from products where deleted=0 AND id=" . $id;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["machine"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
        }
        return $result;
    }

    public function save($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO products ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $id['id'] = mysqli_insert_id($this->conn);
            $result = array(
                'status' => array(
                    'error' => false,
                    'message' => 'Successfully Saved'
                ),
                'payload' => array(
                    'machine' => array_merge($id, $data)
                )
            );
        } else {
            $result = array(
                'status' => array(
                    'error' => true,
                    'message' => $this->conn->error
                )
            );
        }
        return $result;
    }

    public function editProduct($data = array(), $id=0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE products SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $result = array(
                'status' => array(
                    'error' => false,
                    'message' => 'Successfully Updated'
                ),
                'payload' => array(
                    'machine' => array_merge(array('id'=>$id), $data)
                )
            );
        } else {
            $result = array(
                'status' => array(
                    'error' => true,
                    'message' => $this->conn->error
                )
            );
        }
        return $result;
    }

    public function deleteProduct($id) {
        $sql = "UPDATE products SET" .
                " deleted ='" . 1 . "'" .
                " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $course = array(
                'id' => $id
            );

            $result["payload"]["machine"] = $course;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

}

?>
