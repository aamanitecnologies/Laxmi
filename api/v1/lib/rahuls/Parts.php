<?php

/**
 * @desc   Login API
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Parts {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    public function getAllParts() {
        $sql = "SELECT * from parts where deleted=0";
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
                    'parts' => $rows
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

    public function getPartById($id) {
        $sql = "SELECT * from parts where deleted=0 AND id=" . $id;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["part"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
        }
        return $result;
    }

    public function savePart($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO parts ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $id['id'] = mysqli_insert_id($this->conn);
            $result = array(
                'status' => array(
                    'error' => '',
                    'message' => 'Successfully Saved'
                ),
                'payload' => array(
                    'part' => array_merge($id, $data)
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

    public function updatePart($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE parts SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $result = array(
                'status' => array(
                    'error' => false,
                    'message' => 'Successfully Updated'
                ),
                'payload' => array(
                    'part' => array_merge(array('id' => $id), $data)
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

    public function deletePart($id) {
        $sql = "UPDATE products SET" .
                " deleted ='" . 1 . "'" .
                " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $course = array(
                'id' => $id
            );

            $result["payload"]["part"] = $course;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

}

?>
