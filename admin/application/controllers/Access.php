<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        die('adsf');
        if (empty($this->session->userdata('session'))) {
            redirect('');
        }elseif(($this->uri->segments[1] == 'login' or empty ($this->uri->segments)) and $this->uri->segments[2] != 'logout'){
            redirect('dashboard');
        }
    }

}