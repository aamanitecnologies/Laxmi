<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//subjects apis
$app->post('/get_all_subjects', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Subjects.php';
    
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
        $subjects = new Subjects();
        $result = $subjects->get_all_subjects();
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
$app->post('/get_subject_by_id', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Subjects.php';
    
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
        $error["message"] = "Missing Subject ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $subjects = new Subjects();
        $result = $subjects->get_subject_by_id($input["id"]);
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
$app->post('/add_new_subject', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Subjects.php';
    
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

    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Please provide a course id";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["name"]) || empty($input["name"])) {
        $error["message"] = "Please provide a subject name";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    if (!isset($input["description"]) || empty($input["description"])) {
        $error["message"] = "Please provide a subjct description";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } 
    
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $subjects = new Subjects();
        $result = $subjects->add_new_subject($input["course_id"], $input["name"], $input["description"]);
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
$app->post('/edit_subject', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Subjects.php';
    
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
        $error["message"] = "Missing Subject ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Please provide a course id";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["name"]) || empty($input["name"])) {
        $error["message"] = "Please provide a subject name";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    if (!isset($input["description"]) || empty($input["description"])) {
        $error["message"] = "Please provide a subject description";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } 

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $subjects = new Subjects();
        $result = $subjects->edit_subject($input["id"], $input["course_id"], $input["name"], $input["description"]);
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
$app->post('/delete_subject', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Subjects.php';
    
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
        $error["message"] = "Missing Subject ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
    
    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $subjects = new Subjects();
        $result = $subjects->delete_subject($input["id"]);
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
