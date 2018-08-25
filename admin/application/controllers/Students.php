<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('students_model', 'model');
        $this->load->model('batchcodes_model', 'batchcodes');
        $this->load->model('courses_model', 'courses');
        $this->load->model('admissions_model', 'admissions');
        $this->load->model('invoices_model', 'invoices');
    }

    public function index() {
        $data['students'] = $this->model->getAllStudents();
        $data['batchcodes'] = $this->batchcodes->getAllRows();
        $data['courses'] = $this->courses->getAllRows();
        $this->load->view('students_view', $data);
    }

    public function profile($id) {
        $data['fee_status'] = false;
        $data['student'] = $this->model->getStudentById(array('id' => $id));
        $data['invoices'] = $this->invoices->getInvoicesByStudentId(array('student_id' => $id));
        //pr($data['invoices']);die();
        if (!empty($data['invoices']->payload->invoices)) {
            foreach ($data['invoices']->payload->invoices as $val) {
                $fee_paid += $val->payment_amount;
            }
        }
        $data['fee_summary']->fee_payable = $data['student']->payload->student->total_course_fee;
        $data['fee_summary']->fee_paid = $fee_paid;
        $data['fee_summary']->fee_pending = ($data['fee_summary']->fee_payable - ($data['student']->payload->student->discount + $data['fee_summary']->fee_paid));
        $data['batches'] = $this->admissions->getAllRows();
        $this->load->view('student_profile_view', $data);
    }

    public function editImage() {
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $val) {
                $file = new CURLFile($_FILES[$key]['tmp_name'], $_FILES[$key]['type'], $_FILES[$key]['name']);
                $file_data = array('file' => $file);
                $response = $this->model->upload($file_data);
                if ($key == 'student_photo') {
                    $file_id = 'photo_id';
                    $file_url = 'student_photo';
                    $studentData = array(
                      'photo_id' => $response->payload->upload->id,
                      'student_id' => (int)$this->input->post('student_id'),
                      'id_proof_id' => (int)$this->input->post('id_proof_id')
                    );
                    $std = $this->model->updateStudentImage($studentData);
                }
                if ($key == 'id_proof') {
                    $file_id = 'id_proof_id';
                    $file_url = 'id_proof';
                    $studentData = array(
                      'id_proof_id' => $response->payload->upload->id,
                      'student_id' => $this->input->post('student_id'),
                      'photo_id' => $this->input->post('photo_id')
                    );
                    $std = $this->model->updateStudentImage($studentData);
                }
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

    public function editProfile() {
        $data = array(
          'id' => $this->input->post('id'),
          'fname' => $this->input->post('fname'),
          'lname' => $this->input->post('lname'),
          'email' => $this->input->post('email'),
          'dob' => date('Y-m-d h:i:s', strtotime($this->input->post('dob'))),
          'law_school' => $this->input->post('law_school'),
          'yop' => $this->input->post('yop'),
          'referred_by' => $this->input->post('referred_by'),
          'discount' => (int)$this->input->post('discount'),
          'phone' => $this->input->post('phone'),
          'mobile' => $this->input->post('mobile'),
          'fathers_name' => $this->input->post('fathers_name'),
          'fathers_occupation' => $this->input->post('fathers_occupation'),
          'local_address' => $this->input->post('local_address'),
          'permanant_address' => $this->input->post('permanant_address'),
          'leave_entitlement' => $this->input->post('leave-entitlement'),
          'leave_from' => $this->input->post('leave_from'),
          'leave_to' => $this->input->post('leave_to'),
        );
        $response = $this->model->editProfile($data);
        echo json_encode($response);
    }

    public function editBatch() {
        $data = array(
          'id' => $this->input->post('student_id'),
          'batch_id' => $this->input->post('batch_id')
        );
        $response = $this->model->editBatch($data);
        echo json_encode($response);
    }

    public function getSearchedStudents() {
        $data = array(
          'batch_id' => $this->input->post('batch_code_id'),
          'course_id' => $this->input->post('course_id')
        );
        $response = $this->model->getSearchedStudents($data);
        echo json_encode($response);
    }

}
