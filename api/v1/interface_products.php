<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//courses apis
$app->post('/getAllProducts', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Products.php';

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
        $obj = new Products();
        $result = $obj->getAllProducts();
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }

    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/getProductById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Products.php';

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
        $error["message"] = "Missing Product ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new Products();
        $result = $obj->getProductById($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }

    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/saveProduct', function(Request $request, Response $response) {
       
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Products.php';

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
    if (!isset($input["product_name"]) || empty($input["product_name"])) {
        $error["message"] = "Please provide a Product Name";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    if (!isset($input["model_no"]) || empty($input["model_no"])) {
        $error["message"] = "Please provide a Model Number";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }
    $staff = new StaffUsers();
    
    if ($staff->is_session_valid($input["session_key"]) == true) {
        
        $obj = new Products();
        $data = array(
            'product_name'=>$input['product_name'],
            'model_no'=>$input['model_no']
        );
        $result = $obj->save($data);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/editProduct', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Products.php';

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
        $error["message"] = "Missing Product ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["product_name"]) || empty($input["product_name"])) {
        $error["message"] = "Please provide a Product Name";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["model_no"]) || empty($input["model_no"])) {
        $error["message"] = "Please provide a model_no";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new Products();
        $data = array(
            'product_name'=>$input['product_name'],
            'model_no'=>$input['model_no']
        );
        $result = $courses->editProduct($data, $id);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/deleteProduct', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Products.php';

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
        $error["message"] = "Missing Product ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new Products();
        $result = $obj->deleteProduct($input["id"]);
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
