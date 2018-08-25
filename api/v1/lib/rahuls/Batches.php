<?php

/**
 * @desc   Login API
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Batches {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Get all students by batch id
    public function getStudentsByBatchId($batch_id = 0) {
        $fields = array(
          'students.id',
          'students.fname',
          'students.lname',
          'students.phone',
          'students.mobile',
          'students.email',
          'students.created_at',
          'courses.course_code',
          'batch_codes.batch_code',
          'batches.batch_start_date'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM batches "
          . "INNER JOIN students ON batches.id = students.batch_id "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE students.seat_confirmed = 1 "
          . "AND batches.id = $batch_id;";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["students"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["students"] = $result;
        }
        return $result;
    }

    // Get all students by batch id
    public function getRefundedStudentListByBatchId($batch_id = 0) {
        $fields = array(
          'students.id',
          'students.fname',
          'students.lname',
          'students.phone',
          'batch_codes.batch_code',
          'batches.batch_start_date',
          'students.created_at',
          'courses.course_code'
              
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM batches "
          . "INNER JOIN students ON batches.id = students.batch_id "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE students.seat_confirmed = 2 "
          . "AND batches.id = $batch_id;";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["refunded"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["refunded"] = $result;
        }
        return $result;
    }

    public function get_all_batches($cond=array()) {
        // check password is correct or incorrect
        $sql = "select "
          . "(SELECT COUNT(*) FROM students where seat_confirmed = 1 AND students.batch_id = batches.id) AS total_admissions, "
          . "batches.id, "
          . "batches.min_admission_fee, "
          . "courses.name as course, "
          . "batch_codes.batch_code as batch_code, "
          . "CONCAT(DAY(batches.batch_start_date),' ',MONTHNAME(batches.batch_start_date),' ',YEAR(batches.batch_start_date)) as batch_start_date, "
          . "batches.total_seats, "
          . "batches.max_online_seats, "
          . "batches.take_online_admissions, "
          . "batches.admissions_open "
          . "from batches "
          . "inner join batch_codes, courses "
          . "where batches.batch_code_id=batch_codes.id AND batches.course_id=courses.id and batches.batch_start_date >= '".$cond['startDate']."' and batches.batch_start_date <= '".$cond['endDate']."' "
          . "order by batches.batch_start_date DESC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {

            $error["error"] = false;
            $result["status"] = $error;

            $batches = array();
            while ($row = $data->fetch_assoc()) {
                $batches[] = $row;
            }

            $result["payload"]["batches"] = $batches;
        } else {

            $error["error"] = true;
            $error["message"] = "Search result not found";

            $result["status"] = $error;

            $batches = array();
            $result["payload"]["batches"] = $batches;
        }

        return $result;
    }

    public function get_admission_open_batches() {
        $fields = array(
          'batches.id',
          'courses.name as course',
          'batch_codes.batch_code as batch_code',
          'batch_start_date',
          'batches.total_seats',
          'batches.max_online_seats',
          'batches.take_online_admissions',
          'batches.admissions_open',
          'courses.course_fee'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields from batches inner join batch_codes on batches.batch_code_id = batch_codes.id inner join courses on batches.course_id = courses.id and batches.admissions_open = 1";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $batches = array();
            while ($row = $data->fetch_assoc()) {
                $batches[] = $row;
            }
            $result["payload"]["batches"] = $batches;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $batches = array();
            $result["payload"]["batches"] = $batches;
        }
        return $result;
    }

    public function get_batch_by_id($id) {
        $fields = array(
          'batches.id',
          'batches.course_id as course_id',
          'batches.min_admission_fee',
          'courses.name as course',
          'batches.batch_code_id as batch_code_id',
          'batch_codes.batch_code as batch_code',
          'batches.batch_start_date',
          'batches.total_seats',
          'batches.max_online_seats',
          "(SELECT count(*) FROM students WHERE students.seat_confirmed = 1 AND batch_id = $id ) AS total_students",
          "(SELECT count(*) FROM students WHERE students.seat_confirmed = 2 AND batch_id = $id ) AS total_refunds",
          'batches.take_online_admissions',
          'batches.admissions_open'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields "
          . "FROM batches INNER JOIN batch_codes, courses "
          . "WHERE batches.batch_code_id=batch_codes.id "
          . "AND batches.course_id=courses.id "
          . "AND batches.id=" . $id;
        $data = $this->conn->query($sql);
        if ($data->num_rows == 1) {

            $error["error"] = false;
            $result["status"] = $error;

            $row = $data->fetch_assoc();
            $result["payload"]["batch"] = $row;

            //get students in this batch
            $sql = "select * from students where batch_id=" . $id;
            $data = $this->conn->query($sql);
            if ($data->num_rows > 0) {
                $students = array();
                while ($row = $data->fetch_assoc()) {
                    $students[] = $row;
                }
                $result["payload"]["students"] = $students;
            } else {
                $students = array();
                $result["payload"]["students"] = $students;
            }
        } else {

            $error["error"] = true;
            $error["message"] = "Search result not found";

            $result["status"] = $error;

            $batches = array();
            $result["payload"]["batches"] = $batches;
        }

        return $result;
    }

    public function add_new_batch($batch_code_id, $batch_start_date, $course_id, $total_seats, $max_online_seats, $min_admission_fee, $take_online_admissions, $admissions_open, $min_admission_fee, $admissions_show) {
        $sql = "INSERT INTO batches (batch_code_id,batch_start_date,course_id,total_seats,max_online_seats,take_online_admissions,
        admissions_open, min_admission_fee, admissions_show) values('" . $batch_code_id . "',from_unixtime('" . $batch_start_date . "'),'" . $course_id . "','" . $total_seats . "','" . $max_online_seats . "','" . $take_online_admissions . "','" . $admissions_open . "', '".$min_admission_fee."', '".$admissions_show."')";

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;


            $id = mysqli_insert_id($this->conn);

            $batch = array(
              'id' => $id
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;

            $result["status"] = $error;
        }

        return $result;
    }

    public function edit_batch($id, $batch_code_id, $batch_start_date, $course_id, $total_seats, $max_online_seats, $min_admission_fee) {
        $sql = "UPDATE batches SET" .
          " batch_code_id ='" . $batch_code_id . "'" .
          ", batch_start_date = '" . $batch_start_date . "'" .
          ", course_id ='" . $course_id . "'" .
          ", total_seats ='" . $total_seats . "'" .
          ", max_online_seats ='" . $max_online_seats . "'" .
          ", min_admission_fee ='" . $min_admission_fee . "'" .
          " where id=" . $id;
                
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id,
              'batch_code_id'=>$batch_code_id,
              'batch_start_date'=>$batch_start_date,
              'course_id'=>$course_id,
              'total_seats'=>$total_seats,
              'max_online_seats'=>$max_online_seats,
              'min_admission_fee'=>$min_admission_fee
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function delete_batch($id) {
        $sql = "UPDATE batches SET" .
          " deleted ='" . 1 . "'" .
          " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function batch_admission_open($id) {
        $sql = "UPDATE batches SET" .
          " admissions_open ='" . 1 . "'" .
          " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id,
              'admissions_open' => "1"
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function batch_admission_close($id) {
        $sql = "UPDATE batches SET" .
          " admissions_open ='" . 0 . "'" .
          " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id,
              'admissions_open' => "0"
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function batch_online_admission_open($id) {
        $sql = "UPDATE batches SET" .
          " take_online_admissions ='" . 1 . "'" .
          " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id,
              'take_online_admissions' => "1"
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function batch_online_admission_close($id) {
        $sql = "UPDATE batches SET" .
          " take_online_admissions ='" . 0 . "'" .
          " where id=" . $id;

        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;

            $batch = array(
              'id' => $id,
              'take_online_admissions' => "0"
            );

            $result["payload"]["batch"] = $batch;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }

    public function search_batches($course_id, $batch_code_id, $admissions_open, $take_online_admissions) {
        // check password is correct or incorrect
        $sql = "select batches.id, batches.course_id as course_id, courses.name as course, batches.batch_code_id as batch_code_id, batch_codes.batch_code as batch_code, CONCAT(DAY(batches.batch_start_date),'th ',MONTHNAME(batches.batch_start_date),' ',YEAR(batches.batch_start_date)) as batch_start_date, batches.total_seats, batches.max_online_seats, batches.take_online_admissions, batches.admissions_open from batches inner join batch_codes, courses where batches.batch_code_id=batch_codes.id AND batches.course_id=courses.id AND batches.course_id=" . $course_id . " AND batches.batch_code_id=" . $batch_code_id . " AND batches.admissions_open=" . $admissions_open . " AND batches.take_online_admissions=" . $take_online_admissions;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {

            $error["error"] = false;
            $result["status"] = $error;

            $batches = array();
            while ($row = $data->fetch_assoc()) {
                $batches[] = $row;
            }

            $result["payload"]["batches"] = $batches;
        } else if ($data->num_rows == 0) {
            $error["error"] = false;
            $result["status"] = $error;

            $batches = array();

            $result["payload"]["batches"] = $batches;
        } else {

            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }

        return $result;
    }
    
    
    public function getOldBatches() {
        // check password is correct or incorrect
        $sql = "select * from old_batches order by batch_name ASC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {

            $error["error"] = false;
            $result["status"] = $error;

            $batches = array();
            while ($row = $data->fetch_assoc()) {
                $batches[] = $row;
            }

            $result["payload"]["batches"] = $batches;
        } else {

            $error["error"] = true;
            $error["message"] = "Search result not found";

            $result["status"] = $error;

            $batches = array();
            $result["payload"]["batches"] = $batches;
        }

        return $result;
    }

}

?>
