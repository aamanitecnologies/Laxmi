<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('users_model', 'model');
    }

    public function index() {
        $response = $this->model->getAllRows();
        $this->load->view('users_view', $response);
    }

    public function getRow() {
        $data = $this->input->post();
        $response = $this->model->getRow($data);
        echo json_encode($response);
    }
    
    public function getAllCourses(){
        $response = $this->model->getAllRows();
        $response = json_encode($response);
        echo $response;
    }

    public function save() {
        $data = $this->input->post();
        $response = $this->model->save($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('courses');
    }

    public function update() {
        $data = $this->input->post();
        $response = $this->model->update($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('courses');
    }

    public function delete() {
        $data = $this->input->post();
        $response = $this->model->delete($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('courses');
    }

    public function resetPassword() {
        $data = $this->input->post();
        $response = $this->model->resetPassword($data);
        echo json_encode($response);
        //$this->session->set_flashdata('msg', $response->status->message);
        //redirect('courses');
    }

}
