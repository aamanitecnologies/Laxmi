<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('invoices_model', 'model');
        $this->load->model('Students_model', 'students');
    }

    public function index() {
        $data['invoices'] = $this->model->getAllInvoices();
        $this->load->view('invoices_view', $data);
    }

    public function payFee() {
        $data['invoice'] = array(
          'student_id' => $this->input->post('student_id'),
          'payment_type_id' => $this->input->post('payment_type_id'),
          'payment_mode_id' => $this->input->post('payment_mode_id'),
          'payment_amount' => $this->input->post('payment_amount'),
          'payment_bank_name' => $this->input->post('payment_bank_name'),
          'payment_bank_branch_name' => $this->input->post('payment_bank_branch_name'),
          'payment_bank_ifsc' => $this->input->post('payment_bank_ifsc'),
          'payment_bank_ref_number' => $this->input->post('payment_bank_ref_number'),
          'next_due_date' => date('Y-m-d h:i:s', strtotime($this->input->post('next_due_date')))
        );
        $studentDetail = $this->api_lib->callApi('getStudentById', array('id' => $data['invoice']['student_id']));
        if ($studentDetail->payload->student->total_fee_paid > TOTAL_FEE_AMOUNT) {
            $response['invoice']->status->error = true;
            $response['invoice']->status->message = 'Error ! Amount Exceed, Please enter valid amount';
        } else {
            $response['invoice'] = $this->model->payFee($data['invoice']);
            if ($response['invoice']->status->error == false) {
                if ($data['invoice']['payment_type_id'] == 1) {
                    $data['student'] = array(
                      'id' => $data['invoice']['student_id'],
                      'seat_confirmed' => 1
                    );

                    $response['student'] = $this->students->studentSeatConfirmed($data['student']);

                    // Send SMS
                    $transactionReceipt = $this->model->transactionReceipt(array('id' => $data['invoice']['student_id']));
                    $text_sms = "Congratulations !! Mr/Ms " . $transactionReceipt->payload->transactionReceipt->fname . " You have got registered in " . $transactionReceipt->payload->transactionReceipt->batch_code . " " . dateFromat($transactionReceipt->payload->transactionReceipt->batch_start_date) . " batch for Judicial Services at Rahul's IAS-India's most prestigious and best Institute for LAW. Your registration No. " . getRegNo($transactionReceipt->payload->transactionReceipt) . " . Your batch starts from " . dateFromat($transactionReceipt->payload->transactionReceipt->batch_start_date) . ". You are requested to please contact the office at 011-27655845, 27654216, 9811195920, between 11 am and 6 pm (Monday-Saturday) for further details and formalities. 
You are most welcome to the Rahul's IAS family. Wish you grand success in life. God bless.";
                    $contacts = $transactionReceipt->payload->transactionReceipt->mobile;
                    $this->api_lib->sendSmsApi($contacts, $text_sms);
                }
            }
        }
        $response['invoice']->payload->invoice->student_created_at = $studentDetail->payload->student->created_at;
        echo json_encode($response['invoice']);
    }

    public function update() {
        $data = array(
          'id' => $this->input->post('invoice_id'),
          'student_id' => $this->input->post('student_id'),
          'payment_type_id' => $this->input->post('payment_type_id'),
          'payment_mode_id' => $this->input->post('payment_mode_id'),
          'payment_amount' => $this->input->post('payment_amount'),
          'payment_bank_name' => $this->input->post('payment_bank_name'),
          'payment_bank_branch_name' => $this->input->post('payment_bank_branch_name'),
          'payment_bank_ifsc' => $this->input->post('payment_bank_ifsc'),
          'payment_bank_ref_number' => $this->input->post('payment_bank_ref_number'),
          'next_due_date'=>date('Y-m-d 00:00:00', strtotime($this->input->post('next_due_date')))
        );
        $studentDetail = $this->api_lib->callApi('getStudentById', array('id' => $data['student_id']));
        if ($studentDetail->payload->student->total_fee_paid > TOTAL_FEE_AMOUNT) {
            $response->status->error = true;
            $response->status->message = 'Error ! Amount Exceed, Please enter valid amount';
        } else {
            $response = $this->model->update($data);
            $response->payload->invoice->updated_at = dateFromat(date('d F Y'));
            $responseInvoce = $this->api_lib->callApi('getInvoiceById', array('invoice_id'=>$data['id']));
        }
        echo json_encode($responseInvoce);
    }

    public function filter() {
        $results = $this->model->getInvoiceById(array('invoice_id' => $this->input->post('invoice_no')));
        if (!empty($results->payload->invoice)) {
            $results->payload->invoice->created_at = dateFromat($results->payload->invoice->created_at);
        }
        echo json_encode($results);
    }

    public function detail($invoice_id, $student_created_at, $created_at) {
        $created_at = urldecode($created_at);
        $student_created_at = urldecode($student_created_at);
        if (strtotime($created_at) < strtotime(date('2017-07-01'))) {
            $this->getServiceInvoice($invoice_id, $student_created_at);
        } else {
            $this->getGstInvoice($invoice_id, $student_created_at);
        }
    }

    public function getServiceInvoice($invoice_id, $student_created_at) {
        $data['detail'] = $this->model->getOldInvoiceById(array('invoice_id' => $invoice_id));
        $data['detail']->payload->invoice->cgst = getCgst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->sgst = getSgst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->tuition_fee = getOldCoachingFee($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->payment_mode = getPaymentMode($data['detail']->payload->invoice->payment_mode_id);
        $data['detail']->payload->invoice->payment_type = getPaymentType($data['detail']->payload->invoice->payment_type_id);
        $data['detail']->payload->invoice->total_due_amount = $data['detail']->payload->invoice->total_course_fee - $data['detail']->payload->invoice->total_fee_paid;
        
        if ($data['detail']->payload->invoice->total_due_amount) {
            if ($data['detail']->payload->invoice->payment_type_id == 1) {
                $data['detail']->payload->invoice->next_due_date = date('d M Y', strtotime($data['detail']->payload->invoice->batch_start_date));
            } else {
                $data['detail']->payload->invoice->next_due_date = date('Y-m-d',  strtotime($data['detail']->payload->invoice->batch_start_date . ' +'.($data['detail']->payload->invoice->installment-1).' month'));
            }
        } else {
            $data['detail']->payload->invoice->next_due_date = 'NA';
        }
        if($data['detail']->payload->invoice->payment_bank_name == 'Unknown'){
            $data['detail']->payload->invoice->payment_bank_name = 'Online Payment Gateway';
        }
        $this->load->view('invoice_old_detail_view', $data);
    }

    public function getGstInvoice($invoice_id, $student_created_at) {
        $data['detail'] = $this->model->getInvoiceById(array('invoice_id' => $invoice_id));
        $data['detail']->payload->invoice->cgst = getCgst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->sgst = getSgst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->tuition_fee = $data['detail']->payload->invoice->payment_amount - getGst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->payment_mode = getPaymentMode($data['detail']->payload->invoice->payment_mode_id);
        $data['detail']->payload->invoice->payment_type = getPaymentType($data['detail']->payload->invoice->payment_type_id);


        $data['detail']->payload->invoice->total_due_amount = $data['detail']->payload->invoice->total_course_fee - ($data['detail']->payload->invoice->total_fee_paid + $data['detail']->payload->invoice->discount);

        if ($data['detail']->payload->invoice->total_due_amount) {
            if ($data['detail']->payload->invoice->payment_type_id == 1) {
                $data['detail']->payload->invoice->next_due_date = date('d M Y', strtotime($data['detail']->payload->invoice->batch_start_date));
            } else {
                $data['detail']->payload->invoice->next_due_date = dateFromat($data['detail']->payload->invoice->next_due_date);
            }
        } else {
            $data['detail']->payload->invoice->next_due_date = 'NA';
        }
        if($data['detail']->payload->invoice->payment_bank_name == 'Unknown'){
            $data['detail']->payload->invoice->payment_bank_name = 'Online Payment Gateway';
        }
        $this->load->view('invoices_detail_view', $data);
    }

    public function getInvoiceById() {
        $response = $this->model->getInvoiceById(array('invoice_id' => $this->input->post('invoice_id')));
        $response->payload->invoice->next_due_date = date('m/d/Y', strtotime($response->payload->invoice->next_due_date));
        echo json_encode($response);
    }

    public function download($invoice_id) {
        $data['detail'] = $this->model->getInvoiceById(array('invoice_id' => $invoice_id));
        $data['detail']->payload->invoice->gst = getGst($data['detail']->payload->invoice->payment_amount);
        $data['detail']->payload->invoice->tuition_fee = $data['detail']->payload->invoice->payment_amount - $data['detail']->payload->invoice->gst;
        $data['detail']->payload->invoice->payment_mode = getPaymentMode($data['detail']->payload->invoice->payment_mode_id);
        $data['detail']->payload->invoice->payment_type = getPaymentType($data['detail']->payload->invoice->payment_type_id);
        $file_name = $data['detail']->payload->invoice->id . '-' . $data['detail']->payload->invoice->student_id;
        //$this->load->view('invoice_downlaod_view', $data);
        $this->load->library('pdf', 'pdf');
        $this->pdf->load_view('invoice_downlaod_view', $file_name, $data);
    }

    public function getBankDetail() {
        $data = array('ifsc_code' => $this->input->post('search_ifsc'));
        $results = $this->model->getBankDetail($data);
        echo json_encode($results);
    }

}
