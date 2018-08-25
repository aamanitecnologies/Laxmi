<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PrintIdCards_model extends CI_Model {

    public function getAllStudentsIdCardDetails($data = array()) {
        return $this->api_lib->callApi('getAllStudentsIdCardDetails', $data);
    }
}
