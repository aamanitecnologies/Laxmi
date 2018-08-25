<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batches extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('batches_model', 'model');
        $this->load->model('batchcodes_model', 'batchcodes');
        $this->load->model('courses_model', 'courses');
        $this->load->model('students_model', 'students');
    }

    public function index() {
        $data['batches'] = $this->model->getAllRows();
        $data['batchcodes'] = $this->batchcodes->getAllRows();
        $data['courses'] = $this->courses->getAllRows();
        $this->load->view('batches_list_view', $data);
    }

    public function add() {
        $data['batchcodes'] = $this->batchcodes->getAllRows();
        $data['courses'] = $this->courses->getAllRows();
        $this->load->view('batch_add_view', $data);
    }

    public function save() {
        $d = explode('/', $this->input->post('batch_start_date'));
        $batch_start_date = strtotime("$d[1]-$d[0]-$d[2]");
        $data = array(
          'batch_code_id' => $this->input->post('batch_code_id'),
          'batch_start_date' => $batch_start_date,
          'course_id' => $this->input->post('course_id'),
          'total_seats' => $this->input->post('total_seats'),
          'max_online_seats' => $this->input->post('max_online_seats'),
          'min_admission_fee' => $this->input->post('min_admission_fee'),
          'take_online_admissions' => $this->input->post('take_online_admissions'),
          'admissions_open' => $this->input->post('admissions_open'),
          'admissions_show' => $this->input->post('admissions_show')
        );
        $response = $this->model->save($data);
        echo json_encode($response);
    }

    public function update() {
        $batch_start_date = date('Y-m-d 01:i:s', strtotime($this->input->post('batch_start_date')));
        $data = array(
          'id' => $this->input->post('id'),
          'batch_code_id' => $this->input->post('batch_code_id'),
          'batch_start_date' => $batch_start_date,
          'course_id' => $this->input->post('course_id'),
          'total_seats' => $this->input->post('total_seats'),
          'max_online_seats' => $this->input->post('max_online_seats'),
          'min_admission_fee' => $this->input->post('min_admission_fee'),
        );
        $response = $this->model->update($data);
        echo json_encode($response);
    }

    public function detail($batch_id = 0) {
        $data['batch'] = $this->model->getRow(array('id' => $batch_id));
        foreach ($data['batch']->payload->students as $val) {
            $data['contacts'] .= $val->mobile . ',';
        }
        $data['contacts'] = substr($data['contacts'], 0, -1);
        $data['batchcodes'] = $this->batchcodes->getAllRows();
        $data['students'] = $this->model->getStudentsByBatchId(array('batch_id' => $batch_id));
        $data['refunded'] = $this->model->getRefundedStudentListByBatchId(array('batch_id' => $batch_id));
        $data['courses'] = $this->courses->getAllRows();
        $this->load->view('batch_edit_view', $data);
    }

    public function sendEmails() {
        $this->load->library('email');
        $this->email->initialize(array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_user' => 'rahulsiaslaw@gmail.com',
          'smtp_pass' => '216yadav',
          'smtp_port' => 465,
          'crlf' => "\r\n",
          'newline' => "\r\n",
          //'mailtype' => 'html',
          'charset' => 'iso-8859-1'
        ));
        $data = array(
          'from_email' => 'rahulsiaslaw@gmail.com',
          'to_email' => $this->input->post('to_email'),
          'bcc' => $this->input->post('bcc'),
          'subject' => $this->input->post('subject'),
          'message' => $this->input->post('message')
        );
        $this->email->from($data['from_email']);
        $this->email->to($data['to_email']);
        //$this->email->cc('another@another-example.com');
        $this->email->bcc($data['bcc']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);
        if($this->email->send()){
            echo 'Successfully Send';
        }else{
            echo $this->email->print_debugger();
        }
    }

    public function admissionStatus() {
        $data = array(
          'id' => $this->input->post('id'),
          'status' => $this->input->post('status'),
        );
        $response = $this->model->admissionOpen($data);
        echo json_encode($response);
    }

    public function onlineAdmissionStatus() {
        $data = array(
          'id' => $this->input->post('id'),
          'status' => $this->input->post('status'),
        );
        $response = $this->model->onlineAdmissionOpen($data);
        echo json_encode($response);
    }

    public function filter() {
        $data = array(
          'course_id' => $this->input->post('course_id'),
          'batch_code_id' => $this->input->post('batch_code_id'),
          'take_online_admissions' => $this->input->post('take_online_admissions'),
          'admissions_open' => $this->input->post('admissions_open'),
        );
        $response = $this->model->getFiltersRows($data);
        echo json_encode($response);
    }

    public function sendSms() {
        $text_sms = $this->input->post('text_sms');
        $contacts = $this->input->post('contacts');
        $n = 20;
        $arr = explode(',', $contacts);
        $count = count($arr);
        $batchContacts = '';
        for ($a = 0; $a <= $count; $a += $n) {
            $con = array();
            for ($i = $a; $i < $a + $n; $i++) {
                if ($arr[$i]) {
                    $con[] = $arr[$i];
                }
            }
            $batchContacts = implode(',', $con);
            echo $this->api_lib->sendSmsApi($batchContacts, $text_sms);
        }
    }

}
