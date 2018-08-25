<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('dashboard_model', 'model');
        if(empty($this->session->userdata('FISCAL_YEAR'))){

            $requests = array(
                'startDate' => date('Y-04-01 00:00:00'),
                'endDate'=> date('Y-03-31 00:00:00', strtotime("+1Year"))
            );
            $this->session->set_userdata('FISCAL_YEAR', $requests);
        }
    }

    public function index() {
        //pr($this->session->userdata());die();
        //echo date('D F d Y 00:00:00 P');die();
        //pr($this->session->userdata());die();
        $data['status'] = $this->model->getDashboardStatus();
        $data['admissions'] = $this->model->getRecentAdmissions();
        $data['invoices'] = $this->model->getRecentInvoices();
        $this->load->view('dashboard_view', $data);
    }

    public function setFiscalYear($startDate, $endDate){
        $startDate = date('Y-m-d 00:00:00', strtotime($this->input->post('startDate')));
        $endDate = date('Y-m-d 23:59:59', strtotime($this->input->post('endDate')));
        $requests = array(
            'startDate' => $startDate,
            'endDate'=> $endDate
        );
        $this->session->set_userdata('FISCAL_YEAR', $requests);
        echo json_encode($_SERVER['HTTP_REFERER']);
    }

}
