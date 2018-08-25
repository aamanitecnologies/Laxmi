<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Pay Fee
$app->post('/payFee', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Admissions.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["student_id"]) || empty($input["student_id"])) {
        $error["message"] = "Please provide Registration No";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["payment_amount"]) || empty($input["payment_amount"])) {
        $error["message"] = "Please provide Amount";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $data = array(
          'student_id' => $input['student_id'],
          'payment_type_id' => $input['payment_type_id'],
          'payment_mode_id' => $input['payment_mode_id'],
          'payment_amount' => $input['payment_amount'],
          'payment_bank_name' => $input['payment_bank_name'],
          'payment_bank_ifsc' => $input['payment_bank_ifsc'],
          'payment_bank_ref_number' => $input['payment_bank_ref_number'],
          'payment_bank_branch_name' => $input['payment_bank_branch_name'],
          'next_due_date' => $input['next_due_date']
        );
        $admissions = new Admissions();
        $result = $admissions->payFee($data);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Invoices By Student Registration Number
$app->post('/getInvoicesByStudentId', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Admissions.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["student_id"]) || empty($input["student_id"])) {
        $error["message"] = "Missing student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getInvoicesByStudentId($input['student_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get Invoices by invoice id
$app->post('/getInvoiceById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Admissions.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["invoice_id"]) || empty($input["invoice_id"])) {
        $error["message"] = "Missing Invoice id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getInvoiceById($input['invoice_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get Invoices by invoice id
$app->post('/getOldInvoiceById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Admissions.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["invoice_id"]) || empty($input["invoice_id"])) {
        $error["message"] = "Missing Invoice id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getOldInvoiceById($input['invoice_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get All Invoices
$app->post('/getAllInvoices', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Admissions.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getAllInvoices($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Edit Pay Fee
$app->post('/editPayFee', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Invoices.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing Invoice ID";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["student_id"]) || empty($input["student_id"])) {
        $error["message"] = "Missing Student ID";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["payment_amount"]) || empty($input["payment_amount"])) {
        $error["message"] = "Missing Amount";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $invoices = new Invoices();
        $id = $input['id'];
        $data = array(
          'student_id' => $input['student_id'],
          'payment_type_id' => $input['payment_type_id'],          
          'payment_amount' => $input['payment_amount'],
          'payment_mode_id' => $input['payment_mode_id'],
          'payment_bank_ref_number' => $input['payment_bank_ref_number'],
          'payment_bank_ifsc' => $input['payment_bank_ifsc'],
          'payment_bank_name' => $input['payment_bank_name'],
          'payment_bank_branch_name' => $input['payment_bank_branch_name'],
          'next_due_date' => $input['next_due_date']          
        );
        $result = $invoices->editPayFee($data, $id);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Search Ifsc codes
$app->post('/getBankDetail', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Invoices.php';
    $req = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["ifsc_code"]) || empty($input["ifsc_code"])) {
        $error["message"] = "Missing IFSC Code";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $invoices = new Invoices();
        $result = $invoices->getBankDetail($input["ifsc_code"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
?>
