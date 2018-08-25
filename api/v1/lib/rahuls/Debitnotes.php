<?php

/**
 * @desc   BatchCodes
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Debitnotes {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Get All Debit Notes
    public function getDebitNotes($cond=array()) {
        $fields = array(
          'debit_notes.id',
          'debit_notes.created_at',
          'students.id AS registration_no',
          'students.fname',
          'students.lname',
          'students.phone',
          'students.created_at AS student_created_at',
          'courses.course_code'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM debit_notes "
          . "INNER JOIN students ON debit_notes.student_id = students.id "
          . "INNER JOIN batches ON students.batch_id = batches.id "
          . "INNER JOIN courses ON batches.course_id = courses.id where debit_notes.created_at >= '".$cond['startDate']."' and debit_notes.created_at <= '".$cond['endDate']."' "
          . "ORDER BY debit_notes.created_at DESC";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["debit_notes"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["debit_notes"] = $result;
        }
        return $result;
    }

    // Get Invoice Detail by Invoice Id
    public function getDebitNotesById($debit_id) {
        $fields = array(
          'debit_notes.*',
          'students.id AS student_id',
          'students.fname',
          'students.lname',
          'students.fathers_name',
          'students.local_address',
          'students.permanant_address',
          'students.phone',
          'students.mobile',
          'students.email',
          'students.created_at AS student_created_at',
          'batch_codes.batch_code',
          'batches.batch_start_date',
          'courses.name AS course_name',
          'courses.course_fee',
          'courses.duration',
          'courses.duration_code',
          '(SELECT file_url FROM uploads WHERE uploads.id = students.photo_id) AS photo_url',
          '(SELECT file_url FROM uploads WHERE uploads.id = students.signature_id) AS signature_url',
          '(SELECT file_url FROM uploads WHERE uploads.id = students.id_proof_id) AS id_proof_url',
          '(SELECT SUM(payment_amount) FROM invoices WHERE student_id = students.id) AS total_fee_paid'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields  FROM debit_notes "
          . "INNER JOIN students ON debit_notes.student_id = students.id "
          . "INNER JOIN batches ON students.batch_id = batches.id "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "WHERE debit_notes.id = '$debit_id'";
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

    // Save Debit Notes
    public function saveDebitNotes($data = array()) {
        foreach ($data as $key => $val) {
            $keys [] = "`$key`";
            $values[] = "'$val'";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $sql = "INSERT INTO debit_notes ($keys) values($values)";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
            $id = mysqli_insert_id($this->conn);
            $data['id'] = $id;
            $data['created_at'] = date('dS F Y');
            $data['payment_mode_id'] = ($data['payment_mode_id'] == 1) ? 'Cash' : ($data['payment_mode_id'] == 2) ? 'Check' : 'DD';
            $result["payload"]["debitnote"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

    // Edit Invoice
    public function updateDebitNotes($data = array(), $id = 0) {
        $updates = '';
        foreach ($data as $key => $val) {
            $updates[] = "`$key` = '$val'";
        }
        $updates = implode(', ', $updates);
        $sql = "UPDATE debit_notes SET $updates WHERE `id` = $id";
        if ($this->conn->query($sql) === TRUE) {
            $error["error"] = false;
            $result["status"] = $error;
            $data['id'] = $id;
            $result["payload"]["invoice"] = $data;
        } else {
            $error["error"] = true;
            $error["message"] = $this->conn->error;
            $result["status"] = $error;
        }
        return $result;
    }

}

?>
