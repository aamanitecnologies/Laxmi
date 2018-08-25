<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Edit Profile
$app->post('/deletePgTransactionById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/PgStudents.php';
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
        $error["message"] = "Please give pg id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $id = $input['id'];
        $data = array(
          'deleted' => 1,
        );
        $obj = new PgStudents();
        $result = $obj->deletePgTransactionById($data, $id);
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
$app->post('/getPgTransactions', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/PgStudents.php';
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
        $obj = new PgStudents();
        $result = $obj->getPgTransactions();
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Search PG
$app->post('/getPgTransactionById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/PgStudents.php';
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
    if (!isset($input["pg_tracking_id"]) || empty($input["pg_tracking_id"])) {
        $error["message"] = "Missing pg_tracking_id";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new PgStudents();
        $result = $obj->getPgTransactionById($input['pg_tracking_id']);
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
