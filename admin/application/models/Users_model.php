<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {


    public function getAllRows($data = array()){
    	return $this->api_lib->callApi('get_all_staff_users', $data);
    }
    
    public function getRow($data = array()){
    	return $this->api_lib->callApi('get_staff_user_by_id', $data);
    }
    
    public function save($data=array()){
    	return $this->api_lib->callApi('add_new_staff_user', $data);
    }

    public function update($data = array()){
        return $this->api_lib->callApi('edit_staff_user', $data);
    }

    public function delete($data){
         return $this->api_lib->callApi('delete_staff_user', $data);
    }

    public function resetPassword($data){
         return $this->api_lib->callApi('staff_user_reset_password', $data);
    }


}