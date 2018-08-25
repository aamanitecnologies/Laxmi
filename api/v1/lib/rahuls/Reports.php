<?php

/**
 * @desc   BatchCodes
 *         
 *
 * @author Staff
 */
require_once 'RahulsIAS_db.php';

class Reports {

    protected $conn;

    public function __construct() {
        $connection = new RahulsIAS_db();
        return $this->conn = $connection->getDB();
    }

    // Get all students
    public function getBalanceReport($cond=array()) {
        $fields = array(
          'students.fname',
          'students.id',
          'students.total_course_fee',
          '(select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id) as paid',
          'students.discount',
          "(students.total_course_fee - (students.discount + (select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id))) AS balance",
          'students.created_at',
          'batches.batch_start_date',
          'batch_codes.batch_code'
        );
        $fields = implode(', ', $fields);
        $sql = " select $fields from students "
          . "inner join batches on students.batch_id = batches.id "
          . "inner join batch_codes on batches.batch_code_id = batch_codes.id "
          . "where students.total_course_fee > ((select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id) + students.discount) and students.seat_confirmed = 1 and students.created_at >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."'";
        
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["balanceReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["balanceReport"] = $result;
        }
        return $result;
    }

    // Get all students by course id and batch id
    public function getBalanceReportByBatchId($search = array()) {
        $fields = array(
          'students.fname',
          'students.id',
          'students.total_course_fee',
          '(select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id) as paid',
          "(students.total_course_fee - (students.discount + (select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id))) AS balance",
          'students.discount',
          'students.created_at',
          'batches.batch_start_date',
          'batch_codes.batch_code',
          'students.batch_id'
        );
        $fields = implode(', ', $fields);
        $sql = " select $fields from students "
          . "inner join batches on students.batch_id = batches.id "
          . "inner join batch_codes on batches.batch_code_id = batch_codes.id "
          . "where students.total_course_fee != ((select sum(payment_amount) from ((select invoices.id, invoices.student_id, invoices.payment_amount from invoices) union all (select invoices_old.id, invoices_old.student_id, invoices_old.payment_amount from invoices_old)) AS inv where inv.student_id = students.id) + students.discount) "
          . "and students.seat_confirmed = 1 and students.batch_id = " . $search['batch_id'];
        //return $sql;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["balanceReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["balanceReport"] = $result;
        }
        return $result;
    }

    // Get Admission Report
    public function getAdmissionReport($cond=array()) {
        $fields = array(
          'inv.id',
          'students.created_at',
          'inv.student_id',
          'students.fname',
          'students.mobile',
          "batch_codes.batch_code",
          'batches.batch_start_date',
          'inv.payment_mode_id'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields from ("
          . "(select invoices.id,invoices.created_at, invoices.student_id, invoices.payment_mode_id, payment_type_id from invoices) "
          . "union all "
          . "(select invoices_old.id,invoices_old.created_at, invoices_old.student_id, invoices_old.payment_mode_id, payment_type_id from invoices_old)"
          . ") as inv "
          . "inner join students on inv.student_id = students.id "
          . "inner join batches on students.batch_id = batches.id "
          . "inner join batch_codes on batches.batch_code_id = batch_codes.id and students.created_at >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."' and inv.payment_type_id = 1";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["admissionReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["admissionReport"] = $result;
        }
        return $result;
    }
    
    // Get Admission Report By Date Range
    public function getAdmissionReportByDateRange($requests=array()) {
        if($requests['batch_id']){
            $con = "and students.batch_id = ".$requests['batch_id'];
        }
        
        $fields = array(
          "students.id", 
          "students.created_at", 
          "students.fname", 
          'students.mobile',
          "batch_codes.batch_code", 
          "batches.batch_start_date", 
          "inv.payment_mode_id", 
          "inv.payment_type_id"
        );
        $fields = implode(', ', $fields);
                
        $sql = "select $fields from students "
          . "inner join batches on students.batch_id = batches.id inner "
          . "join batch_codes on batches.batch_code_id = batch_codes.id "
          . "inner join ((select invoices.id,invoices.created_at, invoices.student_id, invoices.payment_mode_id, invoices.payment_type_id from invoices) "
          . "union all "
          . "(select invoices_old.id,invoices_old.created_at, invoices_old.student_id, invoices_old.payment_mode_id, payment_type_id from invoices_old)) as inv on students.id = inv.student_id "
          . "where inv.payment_type_id = 1 and students.created_at >= '".$requests['admissionFrom']."' and inv.created_at <= '".$requests['admissionTo']."' $con";
        //return $sql;
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["admissionReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["admissionReport"] = $result;
        }
        return $result;
    }
    
    // Get Admission Report
    public function getPaymentReport($cond=array()) {
        $fields = array(
          'inv.id',
          'inv.created_at',
          'inv.student_id',
          'inv.payment_amount',
          'students.fname',
          'students.created_at as student_created_at',
          "batch_codes.batch_code",
          'batches.batch_start_date',
          'inv.payment_mode_id'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields from ("
          . "(select invoices.id,invoices.created_at, invoices.student_id, invoices.payment_mode_id, invoices.payment_amount from invoices) "
          . "union all "
          . "(select invoices_old.id,invoices_old.created_at, invoices_old.student_id, invoices_old.payment_mode_id, invoices_old.payment_amount from invoices_old)"
          . ") as inv "
          . "inner join students on inv.student_id = students.id "
          . "inner join batches on students.batch_id = batches.id "
          . "inner join batch_codes on batches.batch_code_id = batch_codes.id and inv.created_at >= '".$cond['startDate']."' and inv.created_at <= '".$cond['endDate']."' limit 10";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["paymentReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["paymentReport"] = $result;
        }
        return $result;
    }
    
    // Get Admission Report By Date Range
    public function getPaymentReportByDateRange($requests=array()) {
      $cond = '';
      if(!empty($requests['payment_mode_id'])){
        $cond = "and payment_mode_id = '".$requests['payment_mode_id']."'";
      }
        $fields = array(
          'inv.id',
          'inv.created_at',
          'inv.student_id',
          'inv.payment_amount',
          'students.fname',
            'students.created_at as student_created_at',
          "batch_codes.batch_code",
          'batches.batch_start_date',
          'inv.payment_mode_id'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields from ("
          . "(select invoices.id,invoices.created_at, invoices.student_id, invoices.payment_mode_id, invoices.payment_amount from invoices) "
          . "union all "
          . "(select invoices_old.id,invoices_old.created_at, invoices_old.student_id, invoices_old.payment_mode_id, invoices_old.payment_amount from invoices_old)"
          . ") as inv "
          . "inner join students on inv.student_id = students.id "
          . "inner join batches on students.batch_id = batches.id "
          . "inner join batch_codes on batches.batch_code_id = batch_codes.id "
          . "where inv.created_at >= '".$requests['invoiceFrom']."' and inv.created_at <= '".$requests['invoiceTo']."' $cond";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["paymentReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["paymentReport"] = $result;
        }
        return $result;
    }   
    
    // Get Discount Report
    public function getDiscountReport($cond=array()) {
        $fields = array(
          'students.id',
          'students.fname',
          'students.discount',
          'students.referred_by',
          'students.created_at'
        );
        $fields = implode(', ', $fields);
        $sql = "select $fields from students "
          . "where students.discount > 0 and students.created >= '".$cond['startDate']."' and students.created_at <= '".$cond['endDate']."'";
        $data = $this->conn->query($sql);
        if ($data->num_rows > 0) {
            $error["error"] = false;
            $result["status"] = $error;
            while ($row = $data->fetch_assoc()) {
                $result["payload"]["discountReport"][] = $row;
            }
        } else {
            $error["error"] = true;
            $error["message"] = "Search result not found";
            $result["status"] = $error;
            $result["payload"]["discountReport"] = $result;
        }
        return $result;
    }

}

?>
