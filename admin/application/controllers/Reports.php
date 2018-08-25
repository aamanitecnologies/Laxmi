<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('reports_model', 'model');
        $this->load->model('batches_model', 'batches');
        $this->load->library('excel');
    }

    public function balanceReport() {
        return $this->index();
    }

    public function index() {
        $data['balanceReport'] = $this->model->getBalanceReport();
        $data['batches'] = $this->batches->getAllRows();
        $this->load->view('balance_report_view', $data);
    }

    public function downloadBalanceReport($batch_id) {
        $data = array(
          'batch_id' => $batch_id,
        );
        if ($batch_id) {
            $response = $this->model->getBalanceReportByBatchId($data);
            $filename = dateFromat($response->payload->balanceReport[0]->batch_start_date) . '.xls';
        } else {
            $response = $this->model->getBalanceReport();
            $filename = 'AllBatches.xls';
        }
        $data = $response->payload->balanceReport;
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Balance Report');
        //set cell A1 content with some text
        //$this->excel->getActiveSheet()->setCellValue('A1', 'Balance Report');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Name');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Registration No.');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Total Fee');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Paid');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Discount');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Balance');

        $exceldata = "";
        foreach ($data as $row) {
            if (strtotime($row->created_at) > strtotime('01 April 2018')) {
                $row->balance = TOTAL_FEE_AMOUNT - $row->paid;
            } else {
                $row->balance = OLD_TOTAL_FEE_AMOUNT - $row->paid;
            }
            $exceldata[] = array(
              $row->fname,
              getRegNo($row),
              $row->total_course_fee,
              $row->paid,
              $row->discount,
              $row->balance
            );
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function getBalanceReportByBatchId() {
        $data = array(
          'batch_id' => $this->input->post('batch_id'),
        );
        $response = $this->model->getBalanceReportByBatchId($data);
        echo json_encode($response);
    }

    public function admissionReport() {
        $data['admissionReport'] = $this->model->getAdmissionReport();
        //pr($data['admissionReport']);die();
        $data['batches'] = $this->batches->getAllRows();
        $this->load->view('admission_report_view', $data);
    }

    public function downloadAdmissionReport($startDate = '', $endDate = '', $batch_id=0) {
        $startDate = urldecode($startDate);
        $endDate = urldecode($endDate);
        $delimiter = ";";
        $requests = array(
          'batch_id'=>(int)$batch_id,
          'admissionFrom' => date('Y-m-d 00:00:00', strtotime($startDate)),
          'admissionTo' => date('Y-m-d 23:59:59', strtotime($endDate))
        );
        if ($startDate) {
            $response = $this->model->getAdmissionReportByDateRange($requests);
            $filename = dateFromat($startDate) . '-' . dateFromat($endDate) . '.xls';
        } else {
            $response = $this->model->getAdmissionReport();
            $filename = 'AllAdmissions.xls';
        }
        $data = $response->payload->admissionReport;
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Balance Report');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Admission Date');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Registration No.');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Student Name');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Batch');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Payment Mode');

        $exceldata = "";
        foreach ($data as $row) {
            $exceldata[] = array(
              dateFromat($row->created_at),
              getRegNo($row),
              $row->fname,
              $row->batch_code . ' ' . dateFromat($row->batch_start_date),
              getPaymentMode($row->payment_mode_id)
            );
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function getAdmissionReportByDateRange() {
        $requests = array(
          'batch_id'=>(int)$this->input->post('batch_id'),
          'admissionFrom' => date('Y-m-d 00:00:00', strtotime($this->input->post('admission_from'))),
          'admissionTo' => date('Y-m-d 23:59:59', strtotime($this->input->post('admission_to')))
        );
        $response = $this->model->getAdmissionReportByDateRange($requests);
        echo json_encode($response);
    }

    public function studentPaymentReport() {
        $data['paymentReport'] = $this->model->getPaymentReport();
        $this->load->view('payment_report_view', $data);
    }

    public function downloadStudentPaymentReport($startDate = '', $endDate = '') {
        $startDate = urldecode($startDate);
        $endDate = urldecode($endDate);
        $delimiter = ";";
        $requests = array(
          'invoiceFrom' => date('Y-m-d 00:00:00', strtotime($startDate)),
          'invoiceTo' => date('Y-m-d 23:59:59', strtotime($endDate)),
        );
        if ($startDate) {
            $response = $this->model->getPaymentReportByDateRange($requests);
            $filename = dateFromat($startDate) . '-' . dateFromat($endDate) . '.xls';
        } else {
            $response = $this->model->getPaymentReport();
            $filename = 'AllPaymentReport.xls';
        }
        $data = $response->payload->paymentReport;
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Balance Report');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Invoice Id');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Payment Date');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Registration No.');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Student Name');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Batch');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Payment Mode');

        $exceldata = "";
        foreach ($data as $row) {
            $exceldata[] = array(
              $row->id,
              dateFromat($row->created_at),
              getRegNo($row),
              $row->fname,
              $line->batch_code . ' ' . dateFromat($row->batch_start_date),
              getPaymentMode($row->payment_mode_id)
            );
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function getPaymentReportByDateRange() {
        $requests = array(
          'invoiceFrom' => date('Y-m-d 00:00:00', strtotime($this->input->post('invoice_from'))),
          'invoiceTo' => date('Y-m-d 23:59:59', strtotime($this->input->post('invoice_to'))),
          'payment_mode_id' => $this->input->post('payment_mode_id')
        );
        $response = $this->model->getPaymentReportByDateRange($requests);
        echo json_encode($response);
    }

// Get All Discount Report
    public function discountReport() {
        $data['discountReport'] = $this->model->getDiscountReport();
        $this->load->view('discount_report_view', $data);
    }

}
