<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'lib/rahuls/StaffUsers.php';
require_once 'lib/rahuls/Dashboard.php';

//Get Dashboard Status
$app->post('/getDashboardStatus', function(Request $request, Response $response) {
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
        $obj = new Dashboard();
        $result = $obj->getDashboardStatus($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Recent Admissions
$app->post('/getRecentAdmissions', function(Request $request, Response $response) {
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
        $obj = new Dashboard();
        $result = $obj->getRecentAdmissions($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
// Get Recent Invoices
$app->post('/getRecentInvoices', function(Request $request, Response $response) {
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

        $obj = new Dashboard();
        $result = $obj->getRecentInvoices($input);
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
