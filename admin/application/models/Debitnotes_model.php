<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debitnotes_model extends CI_Model {

    public function getDebitNotes($data = array()) {
        return $this->api_lib->callApi('getDebitNotes', $data);
    }

    public function getDebitNotesById($data = array()) {
        return $this->api_lib->callApi('getDebitNotesById', $data);
    }

    public function save($data = array()) {
        return $this->api_lib->callApi('saveDebitNotes', $data);
    }

    public function update($data = array()) {
        return $this->api_lib->callApi('updateDebitNotes', $data);
    }

}
