<?php
/**
 * @desc   States
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class States
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }
    
    
    public function get_all_states()
    {
    	
		// check password is correct or incorrect
		$sql    = "SELECT * from states where deleted=0";
		$data = $this->conn->query($sql);
		if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $states = array();
            while($row     = $data->fetch_assoc()) {
                $states[] = $row;
            }

            $result["payload"]["states"] = $states;
		} else {
			
            $error["error"]   = true;
            $error["message"]   = "Search result not found";

            $result["status"] = $error;
            
            $states = array();
            $result["payload"]["states"] = $states;
		}
    		
    	return  $result;
    }

    public function get_state_by_id($id)
    {
        
        // check password is correct or incorrect
        $sql    = $sql    = "SELECT * from states where deleted=0 AND id=".$id;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $row     = $data->fetch_assoc();

            $result["payload"]["state"] = $row;
        } else {
            $error["error"]   = true;
            $error["message"]   = "Search result not found";
            
            $result["status"] = $error;
        }
            
        return  $result;
    }

    public function add_new_state($state_code, $state, $language) 
    {
        $sql = "INSERT INTO states (state_code, state, language) values('" . $state_code . "','" . $state . "','" . $language . "')";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $state = array (
                'id' => $id,
                'state_code' => $state_code,
                'state' => $state,
                'language' => $language
            );

            $result["payload"]["state"] = $state;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function edit_state($id, $state_code, $state, $language) 
    {
        $sql = "UPDATE states SET". 
                " state_code ='" . $state_code . "'" .  
                ", state ='" . $state . "'" . 
                ", language ='" . $language . "'" . 
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $state = array (
                'id' => $id,
                'state_code' => $state_code,
                'state' => $state,
                'language' => $language
            );

            $result["payload"]["state"] = $state;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function delete_state($id) 
    {
        $sql = "UPDATE states SET". 
                " deleted ='" . 1 . "'" .  
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $state = array (
                'id' => $id
            );

            $result["payload"]["state"] = $state;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            
            $result["status"] = $error;
        }

        return $result;
    }
}

?>
