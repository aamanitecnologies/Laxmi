<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debits extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('debits_model', 'model');
    }

    public function index() {
        $data['debits'] = $this->model->getDebits();
        $this->load->view('debits_view', $data);
    }

}
