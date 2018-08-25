<?php
/**
 * @desc   Login API
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class StaffUsers
{
    
    protected $conn;

    protected $STATUS_LOGGED_OUT = 0;
    protected $STATUS_LOGGED_IN = 1;
    protected $STATUS_DISABLED = 2;
    
    public function __construct()
    {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }
    
    
    public function staff_login($email, $password)
    {
    	//0 - nothing , 1 - not verified , 2- verified
    	// check email exist or not exist in database
    	$sql    = "SELECT * from staff_users where email ='" . $email . "'";
    	$data = $this->conn->query($sql);
    	if ($data->num_rows == 1) {

            $row = $data->fetch_assoc();

            $match = password_verify($password, $row["password"]);
    		// check password is correct or incorrect
    		if ($match == TRUE) {
    			
                $session_key = $this->generate_session_key();
                $user_id = $row['id'];

                $sql    = "UPDATE staff_users SET session_key ='" . $session_key . "' where id=".$user_id;
                if ($this->conn->query($sql) === TRUE) {
                    $error["error"]   = false;

                    $payload["session_key"] = $session_key;
                    $payload["user_id"] = $user_id;

                    $result["status"] = $error;
                    $result["payload"]["session"] = $payload;

                } else {
                    $error["error"]   = true;
                    $error["message"] = 'Unable to login';

                    $result["status"] = $error;
                }
				return  $result;
    
    		} else {
    			
                $error["message"] = "Invalid username or password";
                $error["error"]   = true;
                
                $result["status"] = $error;

                return  $result;
    		}
    		
    	}
        else {	
            $error["message"] = "User " . $email . " does not exists";
            $error["error"]   = true;
            
            $result["status"] = $error;
    		
    		return  $result;
    	}
    }

    public function staff_logout($session_key) {
        $sql    = "SELECT * from staff_users where session_key ='" . $session_key . "'";
        $data = $this->conn->query($sql);
        if ($data->num_rows == 1) {
            $row     = $data->fetch_assoc();
            $user_id = $row['id'];
            $session_key = '';

            $sql    = "UPDATE staff_users SET session_key ='" . $session_key . "' where id=".$user_id;
            if ($this->conn->query($sql) === TRUE) {
                $error["error"]   = false;
                $result["status"] = $error;
            } else {
                $error["error"]   = true;
                $error["message"] = 'Error: ' . mysqli_error($this->conn);

                $result["status"] = $error;
            }

            return $result;
        }

        else {
            $error["message"] = "Invalid session. Can not logout.";
            $error["error"]   = true;
            
            $result["status"] = $error;
            
            return  $result;            
        }
    }

    public function is_session_valid($session_key) {
        $sql    = "SELECT * from staff_users where session_key ='" . $session_key . "'";
        $data = $this->conn->query($sql);
        if ($data->num_rows == 1) {
            return true;
        }
        return false;
    }

    protected function generate_session_key() {
        
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        }
        else {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
            return  $uuid;
        }
    }

    public function get_all_staff_users() {
        // check password is correct or incorrect
        $sql    = "SELECT * from staff_users where deleted=0";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $staff_users = array();
            while($row = $data->fetch_assoc()) {
                unset($row['password']);

                if(isset($row["session_key"]) && !empty($row["session_key"])) {
                    $row["status"] =  $this->STATUS_LOGGED_IN;
                } else {
                    $row["status"] =  $this->STATUS_LOGGED_OUT;
                }
                unset($row['session_key']);

                if($row["disabled"] == 1) {
                    $row["status"] =  $this->STATUS_DISABLED;   
                }

                $staff_users[] = $row;
            }

            $result["payload"]["staff_users"] = $staff_users;
        } else {
            
            $error["error"]   = true;
            $error["message"]   = "Search result not found";

            $result["status"] = $error;
            
            $staff_users = array();
            $result["payload"]["states"] = $staff_users;
        }
            
        return  $result;
    }

    public function add_new_staff_user($fname, $lname, $email, $password, $phone) 
    {
        $sql = "INSERT INTO staff_users (fname,lname,email,password,phone) values('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','" . $phone . "')";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $staff_user = array (
                'id' => $id,
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'phone' => $phone
            );

            $result["payload"]["staff_user"] = $staff_user;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function edit_staff_user($id, $fname, $lname, $email, $phone) 
    {
        if($id == "5678") {
            $error["error"] = true;
            $error["message"] = "Can not edit details of Super Admin";

            $result["status"] = $error;

            return $result;
        }

        $sql = "UPDATE staff_users SET". 
                " fname ='" . $fname . "'" .  
                ", lname ='" . $lname . "'" . 
                ", email ='" . $email . "'" . 
                ", phone ='" . $phone . "'" . 
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $staff_user = array (
                'id' => $id,
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'phone' => $phone
            );

            $result["payload"]["staff_user"] = $staff_user;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }


    public function get_staff_user_by_id($id)
    {
        
        // check password is correct or incorrect
        $sql    = "SELECT * from staff_users where deleted=0 AND id=".$id;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $row     = $data->fetch_assoc();
            unset($row['password']);

            if(isset($row["session_key"]) && !empty($row["session_key"])) {
                $row["status"] =  $this->STATUS_LOGGED_IN;
            } else {
                $row["status"] =  $this->STATUS_LOGGED_OUT;
            }
            unset($row['session_key']);

            if($row["disabled"] == 1) {
                $row["status"] =  $this->STATUS_DISABLED;   
            }

            $result["payload"]["staff_user"] = $row;
        } else {
            
            $error["error"]   = true;
            $error["message"]   = "Search result not found";

            $result["status"] = $error;
        }
            
        return  $result;
    }

    public function delete_staff_user($id) 
    {
        if($id == "5678") {
            $error["error"] = true;
            $error["message"] = "Can not detele admin user";

            $result["status"] = $error;

            return $result;
        }

        $sql = "UPDATE staff_users SET". 
                " deleted ='" . 1 . "'" .  
                " where id=".$id;
        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $staff_user = array (
                'id' => $id
            );

            $result["payload"]["staff_user"] = $staff_user;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function staff_user_reset_password($id, $password) 
    {
        if($id == "5678") {
            $error["error"] = true;
            $error["message"] = "Can not reset password of Super Admin";

            $result["status"] = $error;

            return $result;
        }

        $sql = "UPDATE staff_users SET". 
                " password ='" . $password . "'" .  
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $staff_user = array (
                'id' => $id
            );

            $result["payload"]["staff_user"] = $staff_user;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }


}

?>
