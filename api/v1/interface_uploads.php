<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// File Upload Api
$app->post('/upload', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Uploads.php';
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
        $staff = new StaffUsers();
        if ($staff->is_session_valid($_REQUEST["session_key"]) == true) {
            $uploads = new Uploads();
            $fileNameWithPath = $base_url . $fileNameWithPath;
            $result = $uploads->upload($fileName, $ext, $fileNameWithPath);
        } else {
            $error['error'] = true;
            $error['session_expired'] = true;
            $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
            $result["status"] = $error;
        }
    } else {
        $error['error'] = true;
        $error['message'] = 'Sorry, there was an error uploading your file.';
        $result["status"] = $error;
    }
    return json_encode($result);
});

// Edit Image Upload Api
$app->post('/editImage', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Uploads.php';
    $base_url = 'https://api.rahulsias.com/v1/';
    
    $req = $request->getBody();
    
    
    $input = json_decode($req, true);
    
    return json_encode($input);
    
    if (!isset($_FILES['file']) or empty($_FILES['file'])) {
        $error["message"] = "Please upload file";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
        
    $nameAr = explode('_', $_FILES['file']['name']);
    $id = $nameAr[0];
    
    
    //create file name
    $fileName = rand(10000, 999999999999);
    // extrect file exention name
    $type = explode('/', $_FILES['file']['type']);
    $ext = $type[1];
    // Upload file
    $fileNameWithPath = 'uploads/images/' . $fileName . '.' . $ext;
    $res = move_uploaded_file($_FILES["file"]["tmp_name"], $fileNameWithPath);
    if ($res) {
        $staff = new StaffUsers();
        if ($staff->is_session_valid($_REQUEST["session_key"]) == true) {
            $uploads = new Uploads();
            $fileNameWithPath = $base_url . $fileNameWithPath;
            $result = $uploads->editImage($fileName, $ext, $fileNameWithPath, $id);
        } else {
            $error['error'] = true;
            $error['session_expired'] = true;
            $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
            $result["status"] = $error;
        }
    } else {
        $error['error'] = true;
        $error['message'] = 'Sorry, there was an error uploading your file.';
        $result["status"] = $error;
    }
    return json_encode($result);
});
?>
