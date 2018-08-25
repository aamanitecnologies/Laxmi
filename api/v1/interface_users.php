<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/staff_login', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/phpmailer/PHPMailerAutoload.php';
    
    $req   = $request->getBody();
    $input = json_decode($req, true);
    
    $result = array();
    
    if (!isset($input["email"]) || empty($input["email"])) {
        $error["message"] = "Missing Email id.";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
    
    if (!isset($input["password"]) || empty($input["password"])) {
        $error["message"] = "Missing password.";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } 
    
    $staff = new StaffUsers();
    $result = $staff->staff_login($input["email"], $input["password"]);

    header('Content-Type: application/json');
    return json_encode($result);
	
});

$app->post('/staff_logout', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
    $result = $staff->staff_logout($input["session_key"]);

    header('Content-Type: application/json');
    return json_encode($result);
    
});

$app->post('/get_all_staff_users', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
	    $result = $staff->get_all_staff_users();
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

$app->post('/add_new_staff_user', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
        
    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "First name can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "last name can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["email"]) || empty($input["email"])) {
        $error["message"] = "First name can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["password"]) || empty($input["password"])) {
        $error["message"] = "Password can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        $pwd = password_hash($input["password"], PASSWORD_DEFAULT);
        if($pwd === FALSE) {
            $error["message"] = "Error: Could not hash password. Check hash function.";
            $error["error"]   = true;
            
            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);            
        }

        $input["password"] = $pwd;
    }

    if (!isset($input["phone"]) || empty($input["phone"])) {
        $error["message"] = "Please provide a valid mobile number";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $result = $staff->add_new_staff_user($input["fname"], $input["lname"], $input["email"], $input["password"], $input["phone"]);
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

$app->post('/get_staff_user_by_id', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
        $error["message"] = "Missing Staff User ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $result = $staff->get_staff_user_by_id($input["id"]);
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

$app->post('/edit_staff_user', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
        $error["message"] = "Missing Staff User ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    if (!isset($input["fname"]) || empty($input["fname"])) {
        $error["message"] = "First name can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["lname"]) || empty($input["lname"])) {
        $error["message"] = "Last name can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["email"]) || empty($input["email"])) {
        $error["message"] = "Email can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["phone"]) || empty($input["phone"])) {
        $error["message"] = "Please provide a valid mobile number";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $result = $staff->edit_staff_user($input["id"], $input["fname"], $input["lname"], $input["email"], $input["phone"]);
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

$app->post('/delete_staff_user', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
        $error["message"] = "Missing Staff User ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $result = $staff->delete_staff_user($input["id"]);
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

$app->post('/staff_user_reset_password', function(Request $request, Response $response)
{
    require_once 'lib/rahuls/StaffUsers.php';
    
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
        $error["message"] = "Missing Staff User ID";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["password"]) || empty($input["password"])) {
        $error["message"] = "Password can not be empty";
        $error["error"]   = true;
        
        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        $pwd = password_hash($input["password"], PASSWORD_DEFAULT);
        if($pwd === FALSE) {
            $error["message"] = "Error: Could not hash password. Check hash function.";
            $error["error"]   = true;
            
            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);            
        }

        $input["password"] = $pwd;
    }

    $staff = new StaffUsers();
    if($staff->is_session_valid($input["session_key"]) == true) {
        $result = $staff->staff_user_reset_password($input["id"], $input["password"]);
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
