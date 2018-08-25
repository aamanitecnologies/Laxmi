<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debitnotes extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->isLogedIn();
    $this->load->model('debitnotes_model', 'model');
    $this->load->model('invoices_model', 'invoices');
    $this->load->model('students_model', 'students');
  }

  public function index() {
    $data['debitnotes'] = $this->model->getDebitNotes();
    $this->load->view('debitnotes_view', $data);
  }

  public function save() {
    $data['debit'] = array(
      'student_id' => $this->input->post('student_id'),
      'payment_type_id' => $this->input->post('payment_type_id'),
      'payment_mode_id' => $this->input->post('payment_mode_id'),
      'payment_mode_id' => $this->input->post('payment_mode_id'),
      'payment_amount' => $this->input->post('payment_amount'),
      'payment_bank_name' => $this->input->post('payment_bank_name'),
      'payment_bank_branch_name' => $this->input->post('payment_bank_branch_name'),
      'payment_bank_ifsc' => $this->input->post('payment_bank_ifsc'),
      'payment_bank_ref_number' => $this->input->post('payment_bank_ref_number'),
      'remarks'=>$this->input->post('remarks'),
      );
    $response['debit'] = $this->model->save($data['debit']);
    if ($response['debit']->status->error == false) {
      $data['student'] = array(
        'id' => $data['debit']['student_id'],
        'seat_confirmed' => 2
        );
      $response['student'] = $this->students->studentSeatConfirmed($data['student']);
    }
    echo json_encode($response['debit']);
  }

  public function filter() {
    $results = $this->model->getDebitNotesById(array('debit_id' => $this->input->post('debit_id')));
    if (!$results->status->error) {
      $results->payload->debitnotes->created_at = dateFromat($results->payload->debitnotes->created_at);
    }
    echo json_encode($results);
  }

  public function detail($id) {
    $data['detail'] = $this->model->getDebitNotesById(array('debit_id' => $id));
    $data['invoices'] = $this->invoices->getInvoicesByStudentId(array('student_id' => $data['detail']->payload->invoice->student_id));
    $data['detail']->payload->invoice->cgst = getCgst($data['detail']->payload->invoice->payment_amount);
    $data['detail']->payload->invoice->sgst = getSgst($data['detail']->payload->invoice->payment_amount);
    $data['detail']->payload->invoice->tuition_fee = $data['detail']->payload->invoice->payment_amount - getGst($data['detail']->payload->invoice->payment_amount);
    $data['detail']->payload->invoice->payment_mode = getPaymentMode($data['detail']->payload->invoice->payment_mode_id);
    $data['detail']->payload->invoice->payment_type = getPaymentType($data['detail']->payload->invoice->payment_type_id);
    $data['detail']->payload->invoice->total_due_amount = $data['detail']->payload->invoice->total_course_fee - $data['detail']->payload->invoice->total_fee_paid;
    $this->load->view('debitnotes_detail_view', $data);
  }

  public function getDebitNotesById() {
    $data = array(
      'debit_id' => $this->input->post('debit_id')
      );
    $response = $this->model->getDebitNotesById($data);
    echo json_encode($response);
  }

  public function update() {
    $data = array(
      'id' => $this->input->post('debit_id'),
      'student_id' => $this->input->post('student_id'),
      'payment_type_id' => $this->input->post('payment_type_id'),
      'payment_mode_id' => $this->input->post('payment_mode_id'),
      'payment_amount' => $this->input->post('payment_amount'),
      'payment_bank_name' => $this->input->post('payment_bank_name'),
      'payment_bank_branch_name' => $this->input->post('payment_bank_branch_name'),
      'payment_bank_ifsc' => $this->input->post('payment_bank_ifsc'),
      'payment_bank_ref_number' => $this->input->post('payment_bank_ref_number'),
      );
    $result = $this->model->update($data);
    echo json_encode($result);
  }

}
