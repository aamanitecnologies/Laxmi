<?php

require_once 'RahulsIAS_db.php';

class PgStudents {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Get all students
    public function getPgTransactions() {
        $fields = array(
          'gateway_students.*',
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields, (select batch_start_date from batches where gateway_students.batch_id = batches.id) as batch_start_date FROM gateway_students WHERE gateway_students.deleted = 0 "
          . "ORDER BY gateway_students.id DESC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["pgstudents"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["pgstudents"] = $result;
        }
        return $result;
    }

    
    // Get Batch Info by batch id
    public function getPgTransactionById($id) {
        $fields = array(
          'gateway_students.*'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields "
          . "FROM gateway_students "
          . "WHERE gateway_students.pg_tracking_id = $id ";
        $data = $this->conn->query($sql);
        if ($data->num_rows == 1) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["pgstudents"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $batches = array();
            $result["payload"]["pgstudents"] = $batches;
        }
        return $result;
    }
    
    // deletePgStudentsInfo
    public function deletePgTransactionById($data=array(),$id) {
        $sql = "UPDATE gateway_students SET deleted = 1 WHERE id = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $result["payload"]["pgstudents"] = 'Successfully Deleted';
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }


}

?>
