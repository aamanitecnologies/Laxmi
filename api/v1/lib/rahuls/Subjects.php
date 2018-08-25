<?php
/**
 * @desc   Subjects
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Subjects
{
    
    protected $conn;
    
    public function __construct()
    {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }
    
    
    public function get_all_subjects()
    {
    	
		// check password is correct or incorrect
		$sql    = "select subjects.id, subjects.course_id, courses.name as course_name, subjects.name, subjects.description, subjects.deleted, subjects.created_at, subjects.updated_at from subjects inner join courses where subjects.course_id=courses.id AND subjects.deleted=0";
		$data = $this->conn->query($sql);
		if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $subjects = array();
            while($row     = $data->fetch_assoc()) {
                $subjects[] = $row;
            }

            $result["payload"]["subjects"] = $subjects;
		} else {
			
            $error["error"]   = true;
            $error["message"]   = "Search result not found";

            $result["status"] = $error;
            
            $subjects = array();
            $result["payload"]["subjects"] = $subjects;
		}
    		
    	return  $result;
    }

    public function get_subject_by_id($id)
    {
        
        // check password is correct or incorrect
        $sql    = "select subjects.id, subjects.course_id, courses.name as course_name, subjects.name, subjects.description, subjects.deleted, subjects.created_at, subjects.updated_at from subjects inner join courses where subjects.course_id=courses.id AND subjects.deleted=0 AND subjects.id=".$id ;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            
            $error["error"]   = false;                
            $result["status"] = $error;

            $row     = $data->fetch_assoc();

            $result["payload"]["subject"] = $row;
        } else {
            $error["error"]   = true;
            $error["message"]   = "Search result not found";
            
            $result["status"] = $error;
        }
            
        return  $result;
    }

    public function add_new_subject($course_id, $name, $description) 
    {
        $sql = "INSERT INTO subjects (course_id, name, description) values('" . $course_id . "','" . $name . "','" . $description . "')";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $subject = array (
                'id' => $id,
                'course_id' => $course_id,
                'name' => $name,
                'description' => $description
            );

            $result["payload"]["subject"] = $subject;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function edit_subject($id, $course_id, $name, $description) 
    {
        $sql = "UPDATE subjects SET". 
                " course_id ='" . $course_id . "'" .  
                ", name ='" . $name . "'" . 
                ", description ='" . $description . "'" . 
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $subject = array (
                'id' => $id,
                'course_id' => $course_id,
                'name' => $name,
                'description' => $description
            );

            $result["payload"]["subject"] = $subject;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function delete_subject($id) 
    {
        $sql = "UPDATE subjects SET". 
                " deleted ='" . 1 . "'" .  
                " where id=".$id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"]   = false;
            $result["status"] = $error;

            $subject = array (
                'id' => $id
            );

            $result["payload"]["subject"] = $subject;
        } else {
            $error["error"]   = true;
            $error["message"] = $this->conn->error;
            
            $result["status"] = $error;
        }

        return $result;
    }
}

?>
