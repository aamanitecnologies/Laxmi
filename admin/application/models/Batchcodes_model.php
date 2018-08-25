<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Batchcodes_model extends CI_Model {

    public function getAllRows($data = array()){
    	return $this->api_lib->callApi('get_all_batch_codes', $data);
    }
    
    public function getRow($data = array()){
    	return $this->api_lib->callApi('get_batch_code_by_id', $data);
    }
    
    public function save($data=array()){
    	return $this->api_lib->callApi('add_new_batch_code', $data);
    }

    public function update($data = array()){
        return $this->api_lib->callApi('edit_batch_code', $data);
    }

    public function delete($data){
         return $this->api_lib->callApi('delete_batch_code', $data);
    }


}