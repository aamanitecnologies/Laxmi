<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admissions_model extends CI_Model {

    public function getAllRows($data = array()) {
        return $this->api_lib->callApi('get_admission_open_batches', $data);
    }

    public function getInvoiceById($data = array()) {
        return $this->api_lib->callApi('getInvoiceById', $data);
    }

    public function upload($data = array()) {
        return $this->api_lib->fileUpload('upload', $data);
    }

    public function uploadSignature($data = array()) {
        return $this->api_lib->callApi('uploadSignature', $data);
    }

    public function save($data = array()) {
        return $this->api_lib->callApi('add_new_admission', $data);
    }

}
