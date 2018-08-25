<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model', 'login');
    }

    public function index() {
        $response = $this->login->logout();
        if ($response->status->error) {
            $this->session->set_flashdata('msg', $response->status->message);
        } else {
            //$this->session->unset_userdata('session');
        }
        $this->session->unset_userdata('session');
        redirect('login');
    }

}
