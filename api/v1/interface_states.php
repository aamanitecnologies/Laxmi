<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//states apis
$app->post('/get_all_states', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/States.php';
    
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
        $states = new States();
        $result = $states->get_all_states();
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
$app->post('/get_state_by_id', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/States.php';
    
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

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $states = new States();
        $result = $states->get_state_by_id($input["id"]);
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
$app->post('/add_new_state', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/States.php';
    
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

    if (!isset($input["state_code"]) || empty($input["state_code"])) {
        $error["message"] = "Please provide a state code";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["state"]) || empty($input["state"])) {
        $error["message"] = "Please provide a state name";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    if (!isset($input["language"]) || empty($input["language"])) {
        $error["message"] = "Please provide a preferred language";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } 
    
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $states = new States();
        $result = $states->add_new_state($input["state_code"], $input["state"], $input["language"]);
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
$app->post('/edit_state', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/States.php';
    
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

    if (!isset($input["state_code"]) || empty($input["state_code"])) {
        $error["message"] = "Please provide a state code";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["state"]) || empty($input["state"])) {
        $error["message"] = "Please provide a state name";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    if (!isset($input["language"]) || empty($input["language"])) {
        $error["message"] = "Please provide a preferred language";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } 

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $states = new States();
        $result = $states->edit_state($input["id"], $input["state_code"], $input["state"], $input["language"]);
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
$app->post('/delete_state', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/States.php';
    
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
    
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $states = new States();
        $result = $states->delete_state($input["id"]);
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
