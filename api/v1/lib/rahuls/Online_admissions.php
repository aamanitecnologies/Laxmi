<?php

require_once 'RahulsIAS_db.php';

class Online_admissions {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Get all students
    public function getOnlineOpenBatches() {
        $fields = array(
          'batches.id AS batch_id',
          'batch_codes.batch_code',
          'courses.course_code',
          'courses.name as course_name',
          'batches.batch_start_date',
          'batches.total_seats',
          'batches.max_online_seats',
          '(batches.max_online_seats - ((SELECT COUNT(*) FROM students WHERE students.seat_confirmed = 1 AND students.batch_id = batches.id AND students.is_online_admission = 1) + (SELECT COUNT(*) FROM gateway_students WHERE gateway_students.batch_id = batches.id AND gateway_students.deleted = 0))) AS online_available_seats',
          "(SELECT COUNT(*) FROM gateway_students WHERE gateway_students.batch_id = batches.id AND gateway_students.deleted = 0 AND gateway_students.pg_order_status = 'In Progress') AS waiting_seats",
          'courses.course_fee',
          'concat(courses.duration, " ",courses.duration_code) AS duration',
          'batches.min_admission_fee',
          'batch_codes.batch_code_timing',
          'admissions_show',
          'take_online_admissions'
        );
        $fields = implode(', ', $fields);
//        $sql = "select $fields FROM batches "
//          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
//          . "INNER JOIN courses ON batches.course_id = courses.id "
//          . "WHERE batches.admissions_open = 1 "
//          . "AND batches.take_online_admissions = 1 "
//          . "ORDER BY batches.batch_start_date ASC";
        $sql = "select $fields FROM batches "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE batches.admissions_show = 1 "
          . "ORDER BY batches.batch_start_date ASC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["open_batches"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["open_batches"] = $result;
        }
        return $result;
    }

    // Get all students
    public function getOnlineTop3OpenBatches() {
        $fields = array(
          'batches.id AS batch_id',
          'batch_codes.batch_code',
          'courses.course_code',
          'courses.name as course_name',
          'batches.batch_start_date',
          'batches.total_seats',
          'batches.max_online_seats',
          '(batches.max_online_seats - (SELECT COUNT(*) FROM students WHERE seat_confirmed = 1 AND is_online_admission = 1 AND batch_id = batches.id)) AS online_available_seats',
          'courses.course_fee',
          'concat(courses.duration, " ",courses.duration_code) AS duration',
          'batches.min_admission_fee'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields FROM batches "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE batches.admissions_open = 1 "
          . "AND batches.take_online_admissions = 1 "
          . "AND (batches.max_online_seats - (SELECT COUNT(*) FROM students WHERE seat_confirmed = 1 AND is_online_admission = 1 AND batch_id = batches.id)) > 0 "
          . "ORDER BY batches.batch_start_date DESC LIMIT 3";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["open_batches"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["open_batches"] = $result;
        }
        return $result;
    }

    // Get Batch Info by batch id
    public function getBatchInfoByBatchId($id) {
        $fields = array(
          'batches.id',
          'batches.course_id as course_id',
          'batches.min_admission_fee',
          'courses.name as course',
          'courses.course_fee',
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
            $result["payload"]["batch_info"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $batches = array();
            $result["payload"]["batches"] = $batches;
        }
        return $result;
    }

    // Get Batch Info by batch id
    public function transactionReceipt($student_id) {
        $fields = array(
          'students.id',
          'invoices.payment_amount',
          'invoices.pg_tracking_id',
          'students.fname',
          'students.fathers_name',
          'students.created_at',
          'batch_codes.batch_code',
          'batches.batch_start_date',
          'students.phone',
          'students.mobile',
          'students.email',
          'invoices.pg_trans_date',
          'invoices.pg_order_status'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields "
          . "FROM students INNER JOIN invoices ON students.id = invoices.student_id "
          . "INNER JOIN batches ON students.batch_id = batches.id "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "WHERE students.id = $student_id ";
        $data = $this->conn->query($sql);
        if ($data->num_rows == 1) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["transactionReceipt"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
        }
        return $result;
    }

    // Check Online Admission Available
    public function isOnlineAdmissionAvailable() {
        $fields = array(
          'count(*) AS available_seats',
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields FROM batches "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE batches.admissions_open = 1 "
          . "AND batches.take_online_admissions = 1 "
          . "AND (batches.max_online_seats - ((SELECT COUNT(*) FROM students WHERE students.seat_confirmed = 1 AND students.batch_id = batches.id) + (SELECT COUNT(*) FROM gateway_students WHERE gateway_students.batch_id = batches.id AND gateway_students.deleted = 0))) > 0";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["online_seats_available"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["online_seats_available"] = $result;
        }
        return $result;
    }

    // Check Online Admission Available
    public function isOnlineAdmissionAvailableByBatchId($batch_id = 0) {
        $fields = array(
          '(batches.max_online_seats - ((SELECT COUNT(*) FROM students WHERE students.seat_confirmed = 1 AND students.batch_id = batches.id AND students.is_online_admission = 1) + (SELECT COUNT(*) FROM gateway_students WHERE gateway_students.batch_id = batches.id AND gateway_students.deleted = 0))) AS available_seats',
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields FROM batches "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE batches.admissions_open = 1 "
          . "AND batches.take_online_admissions = 1 "
          . "AND batches.id = $batch_id "
          . "AND (batches.max_online_seats - ((SELECT COUNT(*) FROM students WHERE students.seat_confirmed = 1 AND students.batch_id = batches.id AND students.is_online_admission = 1) + (SELECT COUNT(*) FROM gateway_students WHERE gateway_students.batch_id = batches.id AND gateway_students.deleted = 0))) > 0";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["online_seats_available"] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["online_seats_available"] = $result;
        }
        return $result;
    }

    // Add New Online Admission
    public function saveOnlineAdmissionFormInPgTable($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO gateway_students ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $id = mysqli_insert_id($this->conn);
            $admission = $data;
            $admission['id'] = $id;
            $result["payload"]["admission"] = $admission;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Add New Online Admission
    public function saveInStudentTable($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO students ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $id = mysqli_insert_id($this->conn);
            $admission = $data;
            $admission['id'] = $id;
            $result["payload"]["admission"] = $admission;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Edit Profile
    public function updatePGStudents($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE gateway_students SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;
            $data['id'] = $id;
            $result["payload"]["pg_update_admission"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Get all students
    public function getPGStudentByid($id) {
        $fields = array(
          'gateway_students.*', 'batches.batch_start_date'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM gateway_students "
          . "INNER JOIN batches ON gateway_students.batch_id = batches.id "
          . "WHERE gateway_students.id = '$id'";
        //return $sql;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $result["payload"]["student"] = $data->fetch_assoc();
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["student"] = $result;
        }
        return $result;
    }

    public function getMissingInvoiceId() {
        $id = 3532;
        $sql = "select id from invoices order by id asc";
        $data = $this->conn->query($sql);
        $c = 1;
        while ($row = $data->fetch_assoc()) {
            if ($row['id'] != $c) {
                $id = $c;
            }
            $c++;
        }
        return $id;
    }

    // Pay Fee
    public function saveInvoice($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);

//        $id = $this->getMissingInvoiceId();
//        if ($id) {
//            $keys[] = 'id';
//            $values[] = $id;
//        }

        $sql = "INSERT INTO invoices ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $id = mysqli_insert_id($this->conn);
            $data['id'] = $id;
            $data['created_at'] = date('dS F Y');
            $data['payment_mode_id'] = ($data['payment_mode_id'] == 1) ? 'Cash' : ($data['payment_mode_id'] == 2) ? 'Cheque' : 'DD';
            $result["payload"]["invoice"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // deletePgStudentsInfo
    public function deletePgStudentsInfo($id) {
        $sql = "UPDATE gateway_students SET deleted = 1 WHERE id = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $result["payload"]["gateway_students"] = 'Successfully Deleted';
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

}

?>
