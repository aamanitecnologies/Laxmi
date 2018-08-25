<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function getDashboardStatus($data = array()) {
        return $this->api_lib->callApi('getDashboardStatus', $data);
    }
    
    public function getRecentAdmissions($data = array()) {
        return $this->api_lib->callApi('getRecentAdmissions', $data);
    }
    
    public function getRecentInvoices($data = array()) {
        return $this->api_lib->callApi('getRecentInvoices', $data);
    }
    
}
