<?php

/**
 * @desc   BatchCodes
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Admissions {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Add New Admission
    public function add_new_admission($data = array()) {
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

    // Get all students
    public function getAllStudents($cond = array()) {
        $fields = array(
            'students.fname',
            'students.lname',
            'students.id',
            'students.created_at',
            'courses.course_code',
            'batch_codes.batch_code',
            'students.phone',
            'students.mobile',
            'batches.batch_start_date',
            'fathers_name'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM students "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id where students.created_at >= '" . $cond['startDate'] . "' and students.created_at <= '" . $cond['endDate'] . "'"
                . "ORDER BY students.id DESC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $row['fname'] = ucwords(strtolower(trim($row['fname'])));
                $row['fathers_name'] = ucwords(strtolower(trim($row['fathers_name'])));
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

    // Get all students
    public function getAllStudentsIdCardDetails($batch_id = 0) {
        $fields = array(
            'students.id',
            'students.fname',
            'students.created_at',
            'courses.course_code',
            'batch_codes.batch_code',
            'batches.batch_start_date',
            'students.local_address',
            'students.local_address',
            'students.permanant_address',
            'uploads.file_url',
            'courses.name AS course_name'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM students "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
                . "INNER JOIN uploads ON students.photo_id = uploads.id "
                . "WHERE batches.id = $batch_id ";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $row['fname'] = ucwords(strtolower(trim($row['fname'])));
                $result["payload"]["cards"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["cards"] = $result;
        }
        return $result;
    }

    // Get all students by course id and batch id
    public function getSearchedStudents($cond = array()) {
        $fields = array(
            'students.fname',
            'students.lname',
            'students.fathers_name',
            'students.id',
            'students.created_at',
            'courses.course_code',
            'batch_codes.batch_code',
            'students.phone'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM students "
                . "INNER JOIN uploads ON students.photo_id = uploads.id "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
                . "WHERE batches.batch_code_id = '" . $cond['batch_id'] . "' "
                . "AND batches.course_id = '" . $cond['course_id'] . "' and students.created_at >= '" . $cond['startDate'] . "' and students.created_at <= '" . $cond['endDate'] . "'";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $row['fname'] = ucwords(strtolower(trim($row['fname'])));
                $row['fathers_name'] = ucwords(strtolower(trim($row['fathers_name'])));
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

    // Get all students
    public function getStudentByid($id) {
        $fields = array(
            'students.id',
            'students.total_course_fee',
            'students.discount',
            'students.fname',
            'students.lname',
            'students.fathers_name',
            'students.dob',
            'students.leave_from',
            'students.leave_to',
            'students.fathers_occupation',
            'students.phone',
            'students.email',
            'students.mobile',
            'students.local_address',
            'students.permanant_address',
            'students.law_school',
            'students.yop',
            'students.referred_by',
            'students.batch_id',
            'students.seat_confirmed',
            'students.created_at',
            'batch_codes.batch_code',
            'batches.batch_code_id',
            'batches.course_id',
            "CONCAT(DAY(batches.batch_start_date),' ',MONTHNAME(batches.batch_start_date),' ',YEAR(batches.batch_start_date)) as batch_start_date",
            'courses.name AS course_name',
            'courses.course_code',
            '(SELECT SUM(invoices.payment_amount) FROM invoices WHERE invoices.student_id = students.id) AS total_fee_paid',
            '(SELECT uploads.file_url FROM uploads WHERE uploads.id = students.photo_id) AS photo_url',
            '(SELECT uploads.file_url FROM uploads WHERE uploads.id = students.id_proof_id) AS id_proof_url',
            '(SELECT uploads.id FROM uploads WHERE uploads.id = students.photo_id) AS photo_id',
            '(SELECT uploads.id FROM uploads WHERE uploads.id = students.id_proof_id) AS id_proof_id'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM students "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
                . "WHERE students.id = '$id'";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $row = $data->fetch_assoc();
            $row['fname'] = ucwords(strtolower(trim($row['fname'])));
            $row['fathers_name'] = ucwords(strtolower(trim($row['fathers_name'])));
            $error["error"] = false;
            $result["status"] = $error;
            $result["payload"]["student"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["student"] = $result;
        }
        return $result;
    }

    // Pay Fee
    public function payFee($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO invoices ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $id = mysqli_insert_id($this->conn);
            $data['id'] = $id;
            $data['created_at'] = date('dS F Y');
            $data['payment_mode_id'] = ($data['payment_mode_id'] == 1) ? 'Cash' : ($data['payment_mode_id'] == 2) ? 'Check' : 'DD';
            $result["payload"]["invoice"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Get All Invoices
    public function getAllInvoices($cond = array()) {
        $fields = array(
            'invoices.id',
            'invoices.created_at',
            'students.id AS registration_no',
            'students.fname',
            'students.phone',
            'students.mobile',
            'students.created_at AS student_created_at',
            'courses.course_code'
        );
        $fields_old = array(
            'invoices_old.id',
            'invoices_old.created_at',
            'students.id AS registration_no',
            'students.fname',
            'students.phone',
            'students.mobile',
            'students.created_at AS student_created_at',
            'courses.course_code'
        );
        $fields = implode(', ', $fields);
        $fields_old = implode(', ', $fields_old);
        $sql = "select id, created_at, registration_no, fname, phone, mobile, student_created_at, course_code from ((select invoices.id, invoices.created_at, students.id AS registration_no, students.fname, students.phone, students.mobile, students.created_at AS student_created_at, courses.course_code from invoices inner join students on invoices.student_id = students.id inner join batches on students.batch_id = batches.id inner join courses on batches.course_id = courses.id) union (select invoices_old.id, invoices_old.created_at, students.id AS registration_no, students.fname, students.phone, students.mobile, students.created_at AS student_created_at, courses.course_code from invoices_old inner join students on invoices_old.student_id = students.id inner join batches on students.batch_id = batches.id inner join courses on batches.course_id = courses.id)) AS ord where ord.created_at >= '" . $cond['startDate'] . "' and ord.created_at <= '" . $cond['endDate'] . "' order by ord.created_at DESC";
        //return $sql;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["invoices"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["invoices"] = $result;
        }
        return $result;
    }

    // Get invoices by student id
    public function getInvoicesByStudentId($student_id) {
        $fields = array(
            'invoices.id',
            'invoices.payment_amount',
            'invoices.created_at',
            'invoices.payment_mode_id',
            'invoices.student_id'
        );
        $fields = implode(', ', $fields);
        $fields_old = array(
            'invoices_old.id',
            'invoices_old.payment_amount',
            'invoices_old.created_at',
            'invoices_old.payment_mode_id',
            'invoices_old.student_id'
        );
        $fields_old = implode(', ', $fields_old);
        $sql = "SELECT inv.id, inv.payment_amount, inv.created_at, inv.payment_mode_id, inv.student_id, students.created_at as student_created_at FROM ((SELECT $fields FROM invoices) UNION (SELECT $fields_old FROM invoices_old)) AS inv inner join students on inv.student_id = students.id WHERE inv.student_id = '$student_id'";
        //return $sql;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["invoices"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["invoices"] = $result;
        }
        return $result;
    }

    // Get Invoice Detail by Invoice Id
    public function getInvoiceById($invoice_id) {
        $fields = array(
            'invoices_p.*',
            "(select sum(payment_amount) from  ((select invoices.payment_amount, invoices.student_id, invoices.created_at from invoices) union all (select invoices_old.payment_amount, invoices_old.student_id, invoices_old.created_at from invoices_old)) AS inv where inv.student_id = invoices_p.student_id and inv.created_at <= invoices_p.created_at) AS total_fee_paid",
            'invoices_p.next_due_date',
            'students.discount',
            'students.id AS student_id',
            'students.fname',
            'students.lname',
            'students.fathers_name',
            'students.local_address',
            'students.permanant_address',
            'students.phone',
            'students.mobile',
            'students.email',
            'students.is_online_admission',
            'students.total_course_fee',
            'students.created_at AS student_created_at',
            'batch_codes.batch_code',
            'batch_codes.batch_code_timing',
            'batches.batch_start_date',
            'courses.name AS course_name',
            'courses.course_fee',
            'courses.course_code',
            'courses.duration',
            'courses.duration_code',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.photo_id) AS photo_url',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.signature_id) AS signature_url',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.id_proof_id) AS id_proof_url'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields  FROM invoices as invoices_p "
                . "INNER JOIN students ON invoices_p.student_id = students.id "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "WHERE invoices_p.id = '$invoice_id'";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["invoice"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["invoice"] = $result;
        }
        return $result;
    }

// Get Invoice Detail by Invoice Id

    public function getOldInvoiceById($invoice_id) {
        $fields = array(
            'invoices_old_p.*',
            "(select sum(payment_amount) from  ((select invoices.payment_amount, invoices.student_id, invoices.created_at from invoices) union all (select invoices_old.payment_amount, invoices_old.student_id, invoices_old.created_at from invoices_old)) AS inv where inv.student_id = invoices_old_p.student_id and inv.created_at <= invoices_old_p.created_at) AS total_fee_paid",
            "(select count(*) from  ((select invoices.payment_amount, invoices.student_id, invoices.created_at from invoices) union all (select invoices_old.payment_amount, invoices_old.student_id, invoices_old.created_at from invoices_old)) AS inv where inv.student_id = invoices_old_p.student_id and inv.created_at <= invoices_old_p.created_at) AS installment",
            'students.id AS student_id',
            'students.fname',
            'students.lname',
            'students.fathers_name',
            'students.local_address',
            'students.permanant_address',
            'students.phone',
            'students.mobile',
            'students.email',
            'students.is_online_admission',
            'batch_codes.batch_code',
            'batch_codes.batch_code_timing',
            'batches.batch_start_date',
            'courses.name AS course_name',
            'students.total_course_fee',
            'courses.course_code',
            'courses.duration',
            'courses.duration_code',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.photo_id) AS photo_url',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.signature_id) AS signature_url',
            '(SELECT file_url FROM uploads WHERE uploads.id = students.id_proof_id) AS id_proof_url'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields  FROM invoices_old as invoices_old_p "
                . "INNER JOIN students ON invoices_old_p.student_id = students.id "
                . "INNER JOIN batches ON students.batch_id = batches.id "
                . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
                . "INNER JOIN courses ON batches.course_id = courses.id "
                . "WHERE invoices_old_p.id = '$invoice_id'";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            $row = $data->fetch_assoc();
            $result["payload"]["invoice"] = $row;
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["invoice"] = $result;
        }
        return $result;
    }

    // Edit Profile
    public function editProfile($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE students SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;
            $data['id'] = $id;
            $result["payload"]["student"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Edit Profile
    public function updateStudentImage($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE students SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;
            $data['id'] = $id;
            $result["payload"]["student"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Get all students contacts
    public function getContactsByBatchId($batch_id) {
        $sql = "SELECT * FROM old_students WHERE batch_id = $batch_id ORDER BY mobile ASC";
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

}

?>
