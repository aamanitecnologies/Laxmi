<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//batch_codes apis
$app->post('/get_all_batch_codes', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/BatchCodes.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $batch_codes = new BatchCodes();
        $result = $batch_codes->get_all_batch_codes();
    }

    else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    
    header('Content-Type: application/json');
    return json_encode($result);
    
});
$app->post('/get_batch_code_by_id', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/BatchCodes.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing Batch Code ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $batch_codes = new BatchCodes();
        $result = $batch_codes->get_batch_code_by_id($input["id"]);
    }

    else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    
    header('Content-Type: application/json');
    return json_encode($result);
    
});
$app->post('/add_new_batch_code', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/BatchCodes.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code"]) || empty($input["batch_code"])) {
        $error["message"] = "Please provide a batch code";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code_display"]) || empty($input["batch_code_display"])) {
        $error["message"] = "Please provide a batch code display";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $batch_codes = new BatchCodes();
        $result = $batch_codes->add_new_batch_code($input["batch_code"], $input["batch_code_display"],$input["batch_code_timing"]);
    }

    else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }    
    header('Content-Type: application/json');
    return json_encode($result);
    
});
$app->post('/edit_batch_code', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/BatchCodes.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing State ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code"]) || empty($input["batch_code"])) {
        $error["message"] = "Please provide a batch code";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code_display"]) || empty($input["batch_code_display"])) {
        $error["message"] = "Please provide a batch code display";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $batch_codes = new BatchCodes();
        $result = $batch_codes->edit_batch_code($input["id"], $input["batch_code"], $input["batch_code_display"], $input["batch_code_timing"]);
    }

    else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }    
    header('Content-Type: application/json');
    return json_encode($result);
    
});
$app->post('/delete_batch_code', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/BatchCodes.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["session_key"]) || empty($input["session_key"])) {
        $error["message"] = "Missing Session Key";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["id"]) || empty($input["id"])) {
        $error["message"] = "Missing Batch Code ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
    
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $batch_codes = new BatchCodes();
        $result = $batch_codes->delete_batch_code($input["id"]);
    }

    else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }    
    header('Content-Type: application/json');
    return json_encode($result);
    
});

?>
