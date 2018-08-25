<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Get All Debit Notes
$app->post('/getDebitNotes', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Debitnotes.php';
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
        $debitnotes = new Debitnotes();
        $result = $debitnotes->getDebitNotes($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get Debit Notes by debit id
$app->post('/getDebitNotesById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Debitnotes.php';
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
    if (!isset($input["debit_id"]) || empty($input["debit_id"])) {
        $error["message"] = "Missing debit id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $debitnotes = new Debitnotes();
        $result = $debitnotes->getDebitNotesById($input['debit_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Save Debit Notes
$app->post('/saveDebitNotes', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Debitnotes.php';
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
          'remarks' => $input['remarks']
          );
        $debitnotes = new Debitnotes();
        $result = $debitnotes->saveDebitNotes($data);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Update Debit Notes
$app->post('/updateDebitNotes', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Debitnotes.php';
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
        $error["message"] = "Missing Refund ID";
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
        $debitnotes = new Debitnotes();
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
          'remarks'=>$input['remarks'],
          );
        $result = $debitnotes->updateDebitNotes($data, $id);
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
