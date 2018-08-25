<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Batches_model extends CI_Model {

    public function getAllRows($data = array()){
    	return $this->api_lib->callApi('get_all_batches', $data);
    }
    
    public function getRow($data = array()){
    	return $this->api_lib->callApi('get_batch_by_id', $data);
    }
    
    public function getStudentsByBatchId($data = array()) {
        return $this->api_lib->callApi('getStudentsByBatchId', $data);
    }

    public function getRefundedStudentListByBatchId($data = array()) {
        return $this->api_lib->callApi('getRefundedStudentListByBatchId', $data);
    }

    public function save($data=array()){
    	return $this->api_lib->callApi('add_new_batch', $data);
    }

    public function update($data = array()){
        return $this->api_lib->callApi('edit_batch', $data);
    }

    public function delete($data){
         //return $this->api_lib->callApi('delete_batch_code', $data);
    }
    
    public function admissionOpen($data=array()){
        if($data['status'] == 0){
            return $this->api_lib->callApi('batch_admission_close', $data);
        }else{
            return $this->api_lib->callApi('batch_admission_open', $data);
        }
    }

    public function onlineAdmissionOpen($data=array()){
        if($data['status'] == 0){
            return $this->api_lib->callApi('batch_online_admission_close', $data);
        }else{
            return $this->api_lib->callApi('batch_online_admission_open', $data);
        }
    }
    
    public function getFiltersRows($data = array()){
        return $this->api_lib->callApi('search_batches', $data);
    }


}