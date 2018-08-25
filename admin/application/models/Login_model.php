<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {


    public function checkLogin($data=array()){
    	return $this->api_lib->callApi('staff_login', $data);
    }

    public function logout($data=array()){
    	echo $this->api_lib->callApi('staff_logout', array());
    }

}