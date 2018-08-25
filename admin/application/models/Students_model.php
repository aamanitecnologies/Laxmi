<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model {

    public function getAllStudents($data = array()) {
        return $this->api_lib->callApi('getAllStudents', $data);
    }

    public function getStudentById($data = array()) {
        return $this->api_lib->callApi('getStudentById', $data);
    }

    public function editProfile($data = array()) {
        return $this->api_lib->callApi('editProfile', $data);
    }

    public function editBatch($data = array()) {
        return $this->api_lib->callApi('editStudentBatch', $data);
    }

    public function getSearchedStudents($data = array()) {
        return $this->api_lib->callApi('getSearchedStudents', $data);
    }

    public function studentSeatConfirmed($data = array()) {
        return $this->api_lib->callApi('studentSeatConfirmed', $data);
    }
    
    public function updateStudentImage($data = array()) {
        return $this->api_lib->callApi('updateStudentImage', $data);
    }
    
    public function upload($data = array()) {
        return $this->api_lib->fileUpload('upload', $data);
    }

}
