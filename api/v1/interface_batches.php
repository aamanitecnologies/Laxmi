<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Get All Students by batch id
$app->post('/getStudentsByBatchId', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';
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
        $batches = new Batches();
        $result = $batches->getStudentsByBatchId($input['batch_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});// Get All Refunded Students by batch id
$app->post('/getRefundedStudentListByBatchId', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';
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
        $batches = new Batches();
        $result = $batches->getRefundedStudentListByBatchId($input['batch_id']);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';
        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

//batches apis
$app->post('/add_new_batch', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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

    if (!isset($input["batch_code_id"]) || empty($input["batch_code_id"])) {
        $error["message"] = "Please provide a batch code id";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_start_date"]) || empty($input["batch_start_date"])) {
        $error["message"] = "Please provide a start date";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Please provide a course id";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["total_seats"]) || empty($input["total_seats"])) {
        $error["message"] = "Please provide total seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        if ($input["total_seats"] <= 0) {
            $error["message"] = "Please provide a valid value of total seats.";
            $error["error"] = true;

            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);
        }
    }

    if (!isset($input["max_online_seats"]) || empty($input["max_online_seats"])) {
        $error["message"] = "Please provide maximum online seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        if ($input["max_online_seats"] < 0) {
            $error["message"] = "Please provide a valid value of maximum online seats.";
            $error["error"] = true;

            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);
        }
    }

    if ((isset($input["take_online_admissions"]) && $input["take_online_admissions"] === "0") || !empty($input["take_online_admissions"])) {
        if ($input["take_online_admissions"] > 0) {
            $input["take_online_admissions"] = 1;
        }
    } else {
        $error["message"] = "Please provide online admissions flag";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if ((isset($input["admissions_open"]) && $input["admissions_open"] === "0") || !empty($input["admissions_open"])) {
        if ($input["admissions_open"] > 0) {
            $input["admissions_open"] = 1;
        }
    } else {
        $error["message"] = "Please provide admissions open flag";
        $error["error"] = true;
        $error["value"] = $input["admissions_open"];

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if ($input["max_online_seats"] > $input["total_seats"]) {
        $error["message"] = "Total seats can not be less than maximum online seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->add_new_batch($input["batch_code_id"], $input["batch_start_date"], $input["course_id"], $input["total_seats"], $input["max_online_seats"], $input["batch_code_id"], $input["take_online_admissions"], $input["admissions_open"], $input["min_admission_fee"], $input["admissions_show"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/get_all_batches', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $batches = new Batches();
        $result = $batches->get_all_batches($input);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/get_admission_open_batches', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $batches = new Batches();
        $result = $batches->get_admission_open_batches();
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/get_batch_by_id', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->get_batch_by_id($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/edit_batch', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code_id"]) || empty($input["batch_code_id"])) {
        $error["message"] = "Please provide a batch code id";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_start_date"]) || empty($input["batch_start_date"])) {
        $error["message"] = "Please provide a start date";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Please provide a course id";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["total_seats"]) || empty($input["total_seats"])) {
        $error["message"] = "Please provide total seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        if ($input["total_seats"] <= 0) {
            $error["message"] = "Please provide a valid value of total seats.";
            $error["error"] = true;

            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);
        }
    }

    if (!isset($input["max_online_seats"]) || empty($input["max_online_seats"])) {
        $error["message"] = "Please provide maximum online seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    } else {
        if ($input["max_online_seats"] < 0) {
            $error["message"] = "Please provide a valid value of maximum online seats.";
            $error["error"] = true;

            $result["status"] = $error;

            header('Content-Type: application/json');
            return json_encode($result);
        }
    }

    if ($input["max_online_seats"] > $input["total_seats"]) {
        $error["message"] = "Total seats can not be less than maximum online seats";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->edit_batch($input["id"], $input["batch_code_id"], $input["batch_start_date"], $input["course_id"], $input["total_seats"], $input["max_online_seats"], $input["min_admission_fee"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/delete_batch', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->delete_batch($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/batch_admission_open', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->batch_admission_open($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/batch_admission_close', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->batch_admission_close($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/batch_online_admission_open', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->batch_online_admission_open($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/batch_online_admission_close', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $error["message"] = "Missing Batch ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->batch_online_admission_close($input["id"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});

$app->post('/search_batches', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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

    if (!isset($input["course_id"]) || empty($input["course_id"])) {
        $error["message"] = "Missing Course ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if (!isset($input["batch_code_id"]) || empty($input["batch_code_id"])) {
        $error["message"] = "Missing Batch Code ID";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if ((isset($input["take_online_admissions"]) && $input["take_online_admissions"] === "0") || !empty($input["take_online_admissions"])) {
        if ($input["take_online_admissions"] > 0) {
            $input["take_online_admissions"] = 1;
        }
    } else {
        $error["message"] = "Please provide online admissions flag";
        $error["error"] = true;

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    if ((isset($input["admissions_open"]) && $input["admissions_open"] === "0") || !empty($input["admissions_open"])) {
        if ($input["admissions_open"] > 0) {
            $input["admissions_open"] = 1;
        }
    } else {
        $error["message"] = "Please provide admissions open flag";
        $error["error"] = true;
        $error["value"] = $input["admissions_open"];

        $result["status"] = $error;

        header('Content-Type: application/json');
        return json_encode($result);
    }

    $staff = new StaffUsers();
    if ($staff->is_session_valid($input["session_key"]) == true) {
        $batches = new Batches();
        $result = $batches->search_batches($input["course_id"], $input["batch_code_id"], $input["admissions_open"], $input["take_online_admissions"]);
    } else {
        $error['error'] = true;
        $error['session_expired'] = true;
        $error['message'] = 'Invaid Session. Please Sign-in again to continue.';

        $result["status"] = $error;
    }
    header('Content-Type: application/json');
    return json_encode($result);
});


$app->post('/getOldBatches', function(Request $request, Response $response) {
    require_once 'lib/rahuls/StaffUsers.php';
    require_once 'lib/rahuls/Batches.php';

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
        $batches = new Batches();
        $result = $batches->getOldBatches();
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
