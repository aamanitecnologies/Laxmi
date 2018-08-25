<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        if(!empty($this->session->userdata('session'))){
            $this->isLogedIn();
        }
        $this->load->model('Login_model', 'login');
    }

    public function index() {
        $this->load->view('login_view');
    }

    public function checklogin() {
        try {
            $data = array_map('trim', $this->input->post());
            $response = $this->login->checkLogin($data);
            if (!$response->status->error) {
                $this->session->set_userdata('session', $response);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('msg', $response->status->message);
                redirect('');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('msg', 'Caught exception: ', $e->getMessage(), "\n");
        }
    }

}
