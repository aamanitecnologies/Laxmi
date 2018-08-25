<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Failedtransactions extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('Failedtransactions_model', 'model');
    }

    public function index() {
        $data['pg'] = $this->model->getPgTransactions();
        $this->load->view('failedtransactions_view', $data);
    }

    public function getPgTransactionById() {
        $requests = array(
          'pg_tracking_id' => $this->input->post('pg_tracking_id'),
        );
        $response = $this->model->getPgTransactionById($requests);
        echo $response;
    }

    public function deletePgTransactionById($id) {
        $requests = array(
          'id' => $id,
        );
        $response = $this->model->deletePgTransactionById($requests);
        echo json_encode($response);
    }

}
