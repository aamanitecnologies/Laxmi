<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class States_model extends CI_Model {


    public function getAllRows($data = array()){
    	return $this->api_lib->callApi('get_all_states', $data);
    }
    
    public function getRow($data = array()){
    	return $this->api_lib->callApi('get_state_by_id', $data);
    }
    
    public function save($data=array()){
    	return $this->api_lib->callApi('add_new_state', $data);
    }

    public function update($data = array()){
        return $this->api_lib->callApi('edit_state', $data);
    }

    public function delete($data){
         return $this->api_lib->callApi('delete_state', $data);
    }


}