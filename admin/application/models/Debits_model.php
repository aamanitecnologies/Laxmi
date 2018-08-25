<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debits_model extends CI_Model {

    public function getDebits($data = array()) {
        return $this->api_lib->callApi('getDebits', $data);
    }
}
