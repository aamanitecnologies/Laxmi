<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parts_model extends CI_Model {

    public function getAllParts($data = array()) {
        return $this->api_lib->callApi('getAllParts', $data);
    }

    public function getPartById($data = array()) {
        return $this->api_lib->callApi('getPartById', $data);
    }

    public function save($data = array()) {
        return $this->api_lib->callApi('savePart', $data);
    }

    public function update($data = array()) {
        return $this->api_lib->callApi('updatePart', $data);
    }

    public function delete($data) {
        return $this->api_lib->callApi('deletePart', $data);
    }

}
