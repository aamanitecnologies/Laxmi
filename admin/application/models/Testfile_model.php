<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testfile_model extends CI_Model {


    public function save($data = array()){
    	return $this->api_lib->fileUpload('uploadnew', $data);
    }

}