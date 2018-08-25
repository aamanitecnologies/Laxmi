<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'lib/rahuls/Online_admissions.php';
require_once 'lib/rahuls/Uploads.php';

// Get Online Open Batches
$app->post('/getOnlineOpenBatches', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    $obj = new Online_admissions();
    $result = $obj->getOnlineOpenBatches();
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Online Open Batches
$app->post('/transactionReceipt', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please provide a student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $obj = new Online_admissions();
    $result = $obj->transactionReceipt($input["id"]);
    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/getOnlineTop3OpenBatches', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    $obj = new Online_admissions();
    $result = $obj->getOnlineTop3OpenBatches();
    header('Content-Type: application/json');
    return json_encode($result);
});
// Check Batches is open or not
$app->post('/isOnlineAdmissionAvailable', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    $obj = new Online_admissions();
    $result = $obj->isOnlineAdmissionAvailable();
    header('Content-Type: application/json');
    return json_encode($result);
});
// Check Batches is open or not
$app->post('/isOnlineAdmissionAvailableByBatchId', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["batch_id"]) || empty($input["batch_id"])) {
        $error["message"] = "Please provide a batch_id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $obj = new Online_admissions();
    $result = $obj->isOnlineAdmissionAvailableByBatchId($input['batch_id']);
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Batch Info By Batch ID
$app->post('/getBatchInfoByBatchId', function(Request $request, Response $response) {

    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $obj = new Online_admissions();
    $result = $obj->getBatchInfoByBatchId($input["id"]);
    header('Content-Type: application/json');
    return json_encode($result);
});
// Add New Online Admissions
$app->post('/saveOnlineAdmissionForm', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "Please provide First Name";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $data = array(
      'fname' => $input['fname'],
      'lname' => $input['fname'],
      'batch_id' => $input['batch_id'],
      'total_course_fee' => 197500,
      'dob' => $input['dob'],
      'fathers_name' => $input['fathers_name'],
      'fathers_occupation' => $input['fathers_occupation'],
      'phone' => $input['phone'],
      'email' => $input['email'],
      'mobile' => $input['mobile'],
      'local_address' => $input['local_address'],
      'permanant_address' => $input['permanant_address'],
      'photo_id' => $input['photo_id'],
      'signature_id' => 0,
      'password' => $input['mobile'],
      'id_proof_id' => $input['id_proof_id'],
      'law_school' => $input['law_school'],
      'leave_entitlement' => $input['leave-entitlement'],
      'leave_from' => $input['leave_from'],
      'leave_to' => $input['leave_to'],
      'yop' => $input['yop'],
      'referred_by' => $input['referred_by'],
      'is_online_admission' => 1,
      'pg_order_status' => $input['pg_order_status']
    );
    //return json_encode($data);die();
    $obj = new Online_admissions();
    $result = $obj->saveOnlineAdmissionFormInPgTable($data);
    header('Content-Type: application/json');
    return json_encode($result);
});
// Add New Online Admissions in saveInStudentTable
$app->post('/saveInStudentTable', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "Please provide First Name";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $data = array(
      'fname' => $input['fname'],
      'lname' => $input['lname'],
      'batch_id' => $input['batch_id'],
      'total_course_fee' => $input['total_course_fee'],
      'dob' => $input['dob'],
      'fathers_name' => $input['fathers_name'],
      'fathers_occupation' => $input['fathers_occupation'],
      'phone' => $input['phone'],
      'email' => $input['email'],
      'mobile' => $input['mobile'],
      'local_address' => $input['local_address'],
      'permanant_address' => $input['permanant_address'],
      'photo_id' => $input['photo_id'],
      'signature_id' => $input['signature_id'],
      'password' => $input['password'],
      'id_proof_id' => $input['id_proof_id'],
      'law_school' => $input['law_school'],
      'leave_entitlement' => $input['leave_entitlement'],
      'leave_from' => $input['leave_from'],
      'leave_to' => $input['leave_to'],
      'yop' => $input['yop'],
      'referred_by' => $input['referred_by'],
      'is_online_admission' => $input['is_online_admission'],
      'seat_confirmed' => 1
    );
    //return json_encode($data);die();
    $obj = new Online_admissions();
    $result = $obj->saveInStudentTable($data);
    header('Content-Type: application/json');
    return json_encode($result);
});

// Update Online Admissions
$app->post('/updatePGStudents', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please provide id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $data = array(
      'pg_tracking_id' => $input['pg_tracking_id'],
      'pg_bank_ref_no' => $input['pg_bank_ref_no'],
      'pg_order_status' => $input['pg_order_status'],
      'pg_failure_message' => $input['pg_failure_message'],
      'pg_payment_mode' => $input['pg_payment_mode'],
      'pg_card_name' => $input['pg_card_name'],
      'pg_status_code' => $input['pg_status_code'],
      'pg_status_message' => $input['pg_status_message'],
      'pg_trans_date' => $input['pg_trans_date'],
      'pg_amount' => $input['pg_amount'],
      'pg_mer_amount' => $input['pg_mer_amount'],
      'pg_http_referer' => $input['pg_http_referer'],
    );
    $obj = new Online_admissions();
    $result = $obj->updatePGStudents($data, $input['id']);
    header('Content-Type: application/json');
    return json_encode($result);
});

// Update Online Admissions
$app->post('/updateAdmissionOrderDetail', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["student_reg_id"]) || empty($input["student_reg_id"])) {
        $error["message"] = "Please provide id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $data = array(
      'fname' => $input['fname'],
      'lname' => $input['fname'],
      'batch_id' => $input['batch_id'],
      'total_course_fee' => 197500,
      'dob' => $input['dob'],
      'fathers_name' => $input['fathers_name'],
      'fathers_occupation' => $input['fathers_occupation'],
      'phone' => $input['phone'],
      'email' => $input['email'],
      'mobile' => $input['mobile'],
      'local_address' => $input['local_address'],
      'permanant_address' => $input['permanant_address'],
      'photo_id' => $input['photo_id'],
      'signature_id' => 0,
      'password' => $input['mobile'],
      'id_proof_id' => $input['id_proof_id'],
      'law_school' => $input['law_school'],
      'leave_entitlement' => $input['leave-entitlement'],
      'leave_from' => $input['leave_from'],
      'leave_to' => $input['leave_to'],
      'yop' => $input['yop'],
      'referred_by' => $input['referred_by'],
      'is_online_admission' => 1,
      'pg_order_status' => $input['pg_order_status']
    );
    $obj = new Online_admissions();
    $result = $obj->updatePGStudents($data, $input['student_reg_id']);
    header('Content-Type: application/json');
    return json_encode($result);
});

//upload file
$app->post('/onlineUpload', function(Request $request, Response $response) {
    $base_url = 'https://api.rahulsias.com/v1/';
    if (!isset($_FILES['file']) or empty($_FILES['file'])) {
        $error["message"] = "Please upload file";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    //create file name
    $fileName = rand(10000, 999999999999);
    // extrect file exention name
    $type = explode('/', $_FILES['file']['type']);
    $ext = $type[1];
    // Upload file
    $fileNameWithPath = 'uploads/images/' . $fileName . '.' . $ext;
    $res = move_uploaded_file($_FILES["file"]["tmp_name"], $fileNameWithPath);
    if ($res) {
        $uploads = new Uploads();
        $fileNameWithPath = $base_url . $fileNameWithPath;
        $result = $uploads->upload($fileName, $ext, $fileNameWithPath);
    } else {
        $error['error'] = true;
        $error['message'] = 'Sorry, there was an error uploading your file.';
        $result["status"] = $error;
    }
    return json_encode($result);
});
//Upload Signature
$app->post('/uploadSignature', function(Request $request, Response $response) {
    $base_url = 'https://api.rahulsias.com/v1/';
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["base64"]) || empty($input["base64"])) {
        $error["message"] = "Signature is empty";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }

    $data = base64_decode($input["base64"]);
    $fileName = 'sign-' . rand(10000, 999999999999) . '.png';
    $fileNameWithPath = 'uploads/images/' . $fileName;
    file_put_contents($fileNameWithPath, $data);
    $uploads = new Uploads();
    $fileNameWithPath = $base_url . $fileNameWithPath;
    $result = $uploads->upload($fileName, 'png', $fileNameWithPath);
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get Student By Id
$app->post('/getPGStudentByid', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $admissions = new Online_admissions();
    $result = $admissions->getPGStudentById($input["id"]);

    header('Content-Type: application/json');
    return json_encode($result);
});

// Pay Fee
$app->post('/saveInvoice', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
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
    $data = array(
      'student_id' => $input['student_id'],
      'payment_type_id' => $input['payment_type_id'],
      'payment_mode_id' => $input['payment_mode_id'],
      'payment_amount' => $input['payment_amount'],
      'payment_bank_name' => $input['payment_bank_name'],
      'payment_bank_ifsc' => $input['payment_bank_ifsc'],
      'payment_bank_ref_number' => $input['payment_bank_ref_number'],
      'payment_bank_branch_name' => $input['payment_bank_branch_name'],
      'pg_tracking_id' => $input['pg_tracking_id'],
      'pg_bank_ref_no' => $input['pg_bank_ref_no'],
      'pg_order_status' => $input['pg_order_status'],
      'pg_failure_message' => $input['pg_failure_message'],
      'pg_payment_mode' => $input['pg_payment_mode'],
      'pg_card_name' => $input['pg_card_name'],
      'pg_trans_date' => $input['pg_trans_date']
    );
    $admissions = new Online_admissions();
    $result = $admissions->saveInvoice($data);
    header('Content-Type: application/json');
    return json_encode($result);
});

// deletePgStudentsInfo
$app->post('/deletePgStudentsInfo', function(Request $request, Response $response) {
    $req = $request->getBody();
    $input = json_decode($req, true);
    $result = array();
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please provide ID";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $admissions = new Online_admissions();
    $result = $admissions->deletePgStudentsInfo($input["id"]);
    header('Content-Type: application/json');
    return json_encode($result);
});
?>
