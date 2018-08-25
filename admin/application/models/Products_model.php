<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CI_Model {


    public function getAllRows($data = array()){
    	return $this->api_lib->callApi('getAllProducts', $data);
    }
    
    public function getProductById($data = array()){
    	return $this->api_lib->callApi('getProductById', $data);
    }
    
    public function save($data=array()){
    	return $this->api_lib->callApi('saveProduct', $data);
    }

    public function update($data = array()){
        return $this->api_lib->callApi('updateProduct', $data);
    }

    public function delete($data){
         return $this->api_lib->callApi('deleteProduct', $data);
    }


}