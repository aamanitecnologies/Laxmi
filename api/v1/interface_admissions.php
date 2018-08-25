<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Add New Admissions
$app->post('/add_new_admission', function(Request $request, Response $response) {
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
    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "Please provide First Name";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $data = array(
          'session_key' => $input['session_key'],
          'fname' => $input['fname'],
          'lname' => $input['lname'],
          'batch_id' => $input['batch_code'],
          'total_course_fee' => $input['course_fee'],
          'discount' => $input['discount'],
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
          'password' => $input['mobile'],
          'id_proof_id' => $input['id_proof_id'],
          'law_school' => $input['law_school'],
          'leave_entitlement' => $input['leave-entitlement'],
          'leave_from' => $input['leave_from'],
          'leave_to' => $input['leave_to'],
          'yop' => $input['yop'],
          'referred_by' => $input['referred_by'],
          'is_online_admission' => 0
        );        
        $admissions = new Admissions();
        $result = $admissions->add_new_admission($data);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Edit Profile
$app->post('/editProfile', function(Request $request, Response $response) {
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
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please Student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $id = $input['id'];
        $data = array(
          'fname' => $input['fname'],
          'lname' => $input['lname'],
          'dob' => $input['dob'],
          'fathers_name' => $input['fathers_name'],
          'fathers_occupation' => $input['fathers_occupation'],
          'phone' => $input['phone'],
          'email' => $input['email'],
          'mobile' => $input['mobile'],
          'local_address' => $input['local_address'],
          'permanant_address' => $input['permanant_address'],
          'law_school' => $input['law_school'],
          'yop' => $input['yop'],
          'referred_by' => $input['referred_by'],
          'discount' => $input['discount']
        );
        $admissions = new Admissions();
        $result = $admissions->editProfile($data, $id);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
}); 

$app->post('/updateStudentImage', function(Request $request, Response $response) {
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
        $error["message"] = "Please Student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $data = array(
          'photo_id' => $input['photo_id'],
          'id_proof_id' => $input['id_proof_id'],
        );
        $admissions = new Admissions();
        $result = $admissions->updateStudentImage($data, $input['student_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});


// Edit Profile
$app->post('/studentSeatConfirmed', function(Request $request, Response $response) {
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
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please Student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $id = $input['id'];
        $data = array(
          'seat_confirmed' => $input['seat_confirmed']
        );
        $admissions = new Admissions();
        $result = $admissions->editProfile($data, $id);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
//edit Student Batch
$app->post('/editStudentBatch', function(Request $request, Response $response) {
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
    if (!isset($input["batch_id"]) || empty($input["batch_id"])) {
        $error["message"] = "Missing batch id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Please Student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $id = $input['id'];
        $data = array(
          'batch_id' => $input['batch_id'],
        );
        $admissions = new Admissions();
        $result = $admissions->editProfile($data, $id);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get All Students
$app->post('/getAllStudents', function(Request $request, Response $response) {
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
        $result = $admissions->getAllStudents($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get All Students
$app->post('/getAllStudentsIdCardDetails', function(Request $request, Response $response) {
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
    if (!isset($input["batch_id"]) || empty($input["batch_id"])) {
        $error["message"] = "Missing batch id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getAllStudentsIdCardDetails($input["batch_id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get Searched Students
$app->post('/getSearchedStudents', function(Request $request, Response $response) {
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
    if (!isset($input["batch_id"]) || empty($input["batch_id"])) {
        $error["message"] = "Missing batch id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Missing course id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getSearchedStudents($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Student By Id
$app->post('/getStudentById', function(Request $request, Response $response) {
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
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing student id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getStudentByid($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

// Get All Students
$app->post('/getContactsByBatchId', function(Request $request, Response $response) {
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
    if (!isset($input["batch_id"]) || empty($input["batch_id"])) {
        $error["message"] = "Missing batch id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $admissions = new Admissions();
        $result = $admissions->getContactsByBatchId($input['batch_id']);
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
