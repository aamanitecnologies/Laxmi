<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testfile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('testfile_model', 'model');
    }
    
    public function index(){
        $this->load->view('testfile_view');
    }

    public function save() {
        $cfile = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
        $data = array('file'=>$cfile);
        //$filename = $_FILES['file']['name'];
        //$filedata = $_FILES['file']['tmp_name'];
        //$filesize = $_FILES['file']['size'];
        //$data['file'] = array("filedata" => "@$filedata", "filename" => $filename);
        $response = $this->model->save($data);
        pr($response);
    }
}