<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('parts_model', 'model');
    }

    public function index() {
        $response = $this->model->getAllParts();
        $this->load->view('parts_view', $response);
    }

    public function getPartById() {
        $data = array('id' => $this->input->post('id'));
        $response = $this->model->getPartById($data);
        echo json_encode($response);
    }
    
    public function save() {
        $data = array(
          'part_name'=>$this->input->post('part_name'),
          'qty'=>$this->input->post('qty')
        );
        $data = array_map('trim', $data);
        $response = $this->model->save($data);
        echo json_encode($response);
    }

    public function update() {
        $data = array(
          'id'=>$this->input->post('id'),
          'part_name'=>$this->input->post('part_name'),
          'qty'=>$this->input->post('qty')
        );
        $data = array_map('trim', $data);
        $response = $this->model->update($data);
        echo json_encode($response);
    }

    public function delete($id) {
        $data = $this->input->post();
        $response = $this->model->delete($data);
        echo json_encode($response);
    }

}
