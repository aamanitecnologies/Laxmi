<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admissions extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('admissions_model', 'model');
        $this->load->model('batches_model', 'batches');
    }

    public function index() {
        $this->load->view('admissions_view');
    }

    public function add() {
        $data['batches'] = $this->model->getAllRows();
        $this->load->view('admissions_add_view', $data);
    }

    public function save() {
        $data = array_map('trim', $this->input->post());
        $this->session->set_userdata('admission', $data);
    }

    public function documents() {
        if (isset($this->session->userdata('admission')['student_photo'])) {
            $data['student_photo'] = $this->session->userdata('admission')['student_photo'];
        } else {
            $data['student_photo'] = base_url() . '/assets/img/user.png';
        }
        if (isset($this->session->userdata('admission')['id_proof'])) {
            $data['id_proof'] = $this->session->userdata('admission')['id_proof'];
        } else {
            $data['id_proof'] = base_url() . '/assets/img/voter-id-card.png';
        }
        if (isset($this->session->userdata('admission')['signature'])) {
            $data['signature'] = $this->session->userdata('admission')['signature'];
        } else {
            $data['signature'] = '';
        }
        $this->load->view('admissions_documents_view', $data);
    }

    public function upload() {
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $val) {
                $file = new CURLFile($_FILES[$key]['tmp_name'], $_FILES[$key]['type'], $_FILES[$key]['name']);
                $file_data = array('file' => $file);
                $response = $this->model->upload($file_data);
                if ($key == 'student_photo') {
                    $file_id = 'photo_id';
                    $file_url = 'student_photo';
                }
                if ($key == 'id_proof') {
                    $file_id = 'id_proof_id';
                    $file_url = 'id_proof';
                }
                $_SESSION['admission'][$file_id] = $response->payload->upload->id;
                $_SESSION['admission'][$file_url] = $response->payload->upload->file_url;
            }
        } else {
            $obj = array(
              'status' => array(
                'error' => TRUE,
                'message' => 'File is empty !'
              ),
            );
            echo (object) $obj;
        }
        echo json_encode($response);
    }

    public function saveDocuments() {
        // Save Admission Form
        $data = $this->session->userdata('admission');
        $data['dob'] = date('Y-m-d h:i:s', strtotime($data['dob']));
        $data['leave_from'] = $data['leave_from'];
        $data['leave_to'] = $data['leave_to'];
        $data['photo_id'] = $this->session->userdata('admission')['photo_id'];
        $data['signature_id'] = 0;//$this->session->userdata('admission')['signature_id'];
        $data['id_proof_id'] = (int)$this->session->userdata('admission')['id_proof_id'];
        $data['discount'] = (int)$this->session->userdata('admission')['discount'];
        $response = $this->model->save($data);
        if($response->status->error == FALSE){
            //$this->resetAdmission();
        }
        echo json_encode($response);
    }

    public function invoice($invoice_no) {
        $data['invoice'] = $this->model->getInvoiceById(array('invoice_no' => $invoice_no));
        $this->load->view('admissions_invoice_veiw', $data);
    }

    public function resetAdmission() {
        $this->session->unset_userdata('admission');
        echo true;
    }

    public function base64_to_png() {
        $data = array('base64' => $this->input->post('name'));
        $response = $this->model->uploadSignature($data);
        $_SESSION['admission']['signature_id'] = $response->payload->upload->id;
        $_SESSION['admission']['signature'] = $response->payload->upload->file_url;
        echo json_encode($response);
    }

}
