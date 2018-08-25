<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('products_model', 'model');
    }

    public function index() {
        $response = $this->model->getAllRows();
        $this->load->view('products_view', $response);
    }

    public function getProductById() {
        $data = array('id' => $this->input->post('id'));
        $response = $this->model->getProductById($data);
        echo json_encode($response);
    }
    
    public function getAllCourses(){
        $response = $this->model->getAllRows();
        $response = json_encode($response);
        echo $response;
    }

    public function save() {
        $data = array(
          'product_name'=>$this->input->post('product_name'),
          'model_no'=>$this->input->post('model_no')
        );
        $data = array_map('trim', $data);
        $response = $this->model->save($data);
        echo json_encode($response);
    }

    public function update() {
        $data = array(
          'id'=>$this->input->post('id'),
          'name'=>$this->input->post('name'),
          'course_code'=>$this->input->post('course_code'),
          'course_fee'=>$this->input->post('course_fee'),
          'duration'=>$this->input->post('duration'),
          'duration_code'=>$this->input->post('duration_code')
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
