<?php

/**
 * @desc  Uploads
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Uploads {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    public function upload($file_name, $file_type, $file_url) {
        $sql = "INSERT INTO uploads (file_name,file_type,file_url) values('" . $file_name . "','" . $file_type . "','" . $file_url . "')";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $upload = array(
              'id' => $id,
              'file_name' => $file_name,
              'file_type' => $file_type,
              'file_url' => $file_url
            );

            $result["payload"]["upload"] = $upload;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }
    
    public function editImage($file_name, $file_type, $file_url, $id) {
        $sql = "UPDATE uploads SET file_name = '$file_name', file_type = '$file_type', file_url = '$file_url' WHERE id = $id";
        
        return $sql;
        
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error; 
            $data['id'] = $id;
            $result["payload"]["editImage"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

}

?>
