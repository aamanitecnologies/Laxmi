<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class States extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('states_model', 'model');
    }

    public function index() {
        $response = $this->model->getAllRows();
        $this->load->view('states_view', $response);
    }

    public function getRow() {
        $data = $this->input->post();
        $response = $this->model->getRow($data);
        echo json_encode($response);
    }

    public function save() {
        $data = $this->input->post();
        $response = $this->model->save($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('states');
    }

    public function update() {
        $data = $this->input->post();
        $response = $this->model->update($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('states');
    }

    public function delete($id) {
        $data = array('id' => $id);
        $response = $this->model->delete($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('states');
    }

}
