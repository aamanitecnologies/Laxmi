<?php
/**
 * @desc   BatchCodes
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class BatchCodes
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }
    
    
    public function get_all_batch_codes()
    {
    	
		// check password is correct or incorrect
		$sql    = "SELECT * from batch_codes where deleted=0";
		$data = $this->conn->query($sql);
		if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $batch_codes = array();
            while($row     = $data->fetch_assoc()) {
                $batch_codes[] = $row;
            }

            $result["payload"]["batch_codes"] = $batch_codes;
		} else {
			
            $error["error"]   = true;
            $error["message"]   = "Search result not found";

            $result["status"] = $error;
            
            $batch_codes = array();
            $result["payload"]["batch_codes"] = $batch_codes;
		}
    		
    	return  $result;
    }

    public function get_batch_code_by_id($id)
    {
        
        // check password is correct or incorrect
        $sql    = $sql    = "SELECT * from batch_codes where deleted=0 AND id=".$id;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $row     = $data->fetch_assoc();

            $result["payload"]["batch_code"] = $row;
        } else {
            $error["error"]   = true;
            $error["message"]   = "Search result not found";
            
            $result["status"] = $error;
        }
            
        return  $result;
    }

    public function add_new_batch_code($batch_code, $batch_code_display, $batch_code_timing) 
    {
        $sql = "INSERT INTO batch_codes (batch_code, batch_code_display) values('" . $batch_code . "','" . $batch_code_display . "', '".$batch_code_timing."')";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $batch_code = array (
                'id' => $id,
                'batch_code' => $batch_code,
                'batch_code_display' => $batch_code_display,
              'batch_code_display' => $batch_code_timing
            );

            $result["payload"]["batch_code"] = $batch_code;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function edit_batch_code($id, $batch_code, $batch_code_display, $batch_code_timing) 
    {
        $sql = "UPDATE batch_codes SET". 
                " batch_code ='" . $batch_code . "'" .  
                ", batch_code_display ='" . $batch_code_display . "'" . 
          ", batch_code_timing ='" . $batch_code_timing . "'" . 
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;
            $batch_code = array (
                'id' => $id,
                'batch_code' => $batch_code,
                'batch_code_display' => $batch_code_display,
                'batch_code_display' => $batch_code_timing
            );

            $result["payload"]["batch_code"] = $batch_code;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function delete_batch_code($id) 
    {
        $sql = "UPDATE batch_codes SET". 
                " deleted ='" . 1 . "'" .  
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $batch_code = array (
                'id' => $id
            );

            $result["payload"]["batch_code"] = $batch_code;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            
            $result["status"] = $error;
        }

        return $result;
    }
}

?>
