<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//courses apis
$app->post('/getAllParts', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Parts.php';

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
        $obj = new Parts();
        $result = $obj->getAllParts();
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }

    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/getPartById', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Parts.php';

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
        $error["message"] = "Missing Part ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new parts();
        $result = $obj->getPartById($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }

    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/savePart', function(Request $request, Response $response) {

    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Parts.php';

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
    if (!isset($input["part_name"]) || empty($input["part_name"])) {
        $error["message"] = "Please provide a Part Name";
        $error["error"] = true;
        $result["status"] = $error;
        header('Content-Type: application/json');
        return json_encode($result);
    }



    $staff = new StaffUsers();

    if ($staff->is_session_valid($input["session_key"]) == true) {
        $data = array(
            'part_name' => $input['part_name'],
            'qty' => $input['qty']
        );
        $obj = new Parts();
        $result = $obj->savePart($data);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/updatePart', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Parts.php';

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

    if (!isset($input["part_name"]) || empty($input["part_name"])) {
        $error["message"] = "Please provide a Part Name";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $obj = new Parts();
        $data = array(
            'part_name' => $input['part_name'],
            'qty' => $input['qty']
        );
        $result = $obj->updatePart($data, $input['id']);
    } else {
        return json_encode('sadf');
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});
$app->post('/deletePart', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Parts.php';

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
        $obj = new Parts();
        $result = $obj->deletePart($input["id"]);
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
