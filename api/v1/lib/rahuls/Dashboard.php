<?php

require_once 'RahulsIAS_db.php';

class Dashboard {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    private function getTotalStudentsForDashboard($cond=array()){
      $sql = "SELECT COUNT(*) AS total_students FROM students WHERE students.created_at >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."'";
      $data = $this->conn->query($sql);
      $data = $data->fetch_object();
      return $data->total_students;

    }

    private function getConfirmedStudentsForDashboard($cond=array()){
      $sql = "SELECT COUNT(*) AS admissions FROM students WHERE students.created_at >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."' and seat_confirmed = 1";
      $data = $this->conn->query($sql);
      $data = $data->fetch_object();
      return $data->admissions;

    }

    private function getTotalCollectionsForDashboard($cond=array()){
      $sql = "select sum(inv.payment_amount) as collections from (select payment_amount, created_at from invoices union all select payment_amount, created_at from invoices_old) as inv WHERE inv.created_at >= '".$cond['startDate']."' and inv.created_at <= '".$cond['endDate']."'";
      $data = $this->conn->query($sql);
      $data = $data->fetch_object();
      return $data->collections;

    }

    private function getRefundsCollectionsForDashboard($cond=array()){
      $sql = "select sum(payment_amount) as refunds from debit_notes where debit_notes.created_at >= '".$cond['startDate']."' and debit_notes.created_at <= '".$cond['endDate']."'";
      $data = $this->conn->query($sql);
      $data = $data->fetch_object();
      return $data->refunds;

    }


    // Get Dashboard Status
    public function getDashboardStatus($cond=array()) {

      $total_students = $this->getTotalStudentsForDashboard($cond);
      $admissions = $this->getConfirmedStudentsForDashboard($cond);
      $collections = $this->getTotalCollectionsForDashboard($cond);
      $refunds = $this->getRefundsCollectionsForDashboard($cond);
      $data->total_students = $total_students;
      $data->admissions = $admissions;
      $data->collections = $collections;
      $data->refunds = $refunds;

      $result = array(
          'status' => array(
            'error' => false
          ),
          'payload' => array(
            'dashboard_status' => $data
          )
        );
        return $result;
    }
    
    // Get Recent Admissions
    public function getRecentAdmissions($cond=array()) {
        $fields = array(
          'students.fname',
          'students.lname',
          'students.id',
          'students.created_at',
          'courses.course_code',
          'batch_codes.batch_code',
          'batches.batch_start_date',
          'students.phone'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM students "
          . "INNER JOIN uploads ON students.photo_id = uploads.id "
          . "INNER JOIN batches ON students.batch_id = batches.id "
          . "INNER JOIN courses ON batches.course_id = courses.id "
          . "INNER JOIN batch_codes ON batches.batch_code_id = batch_codes.id "
          . "WHERE students.seat_confirmed = 1 and students.created_at >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."' "
          . "ORDER BY students.created_at DESC LIMIT 10";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["admissions"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["admissions"] = $result;
        }
        return $result;
    }
    // Get Recent Invoices
    public function getRecentInvoices($cond=array()) {
        $fields = array(
          'invoices.id',
          'invoices.created_at',
          'students.id AS registration_no',
          'students.fname',
          'students.lname',
          'students.phone',
          'students.created_at AS student_created_at',
          'courses.course_code'
        );
        $fields = implode(', ', $fields);
        $sql = "SELECT $fields FROM invoices "
          . "INNER JOIN students ON invoices.student_id = students.id "
          . "INNER JOIN batches ON students.batch_id = batches.id "
          . "INNER JOIN courses ON batches.course_id = courses.id where invoices.created_at >= '".$cond['startDate']."' and invoices.created_at <= '".$cond['endDate']."' "
          . "ORDER BY invoices.created_at DESC LIMIT 10";
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

}

?>
