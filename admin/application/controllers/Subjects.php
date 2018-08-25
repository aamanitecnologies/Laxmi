<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('subjects_model', 'model');
        $this->load->model('courses_model', 'courses');
    }

    public function index() {
        $response = $this->model->getAllRows();
        $response->courses = $this->courses->getAllRows();
        $this->load->view('subjects_view', $response);
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
        //redirect('subjects');
    }

    public function update() {
        $data = $this->input->post();
        $response = $this->model->update($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('subjects');
    }

    public function delete($id) {
        $data = $this->input->post();
        $response = $this->model->delete($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('subjects');
    }

}
