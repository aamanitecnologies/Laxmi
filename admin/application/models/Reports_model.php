<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

    public function getBalanceReport($data = array()) {
        return $this->api_lib->callApi('getBalanceReport', $data);
    }

    public function getBalanceReportByBatchId($data = array()) {
        return $this->api_lib->callApi('getBalanceReportByBatchId', $data);
    }

    public function getPaymentReport($data = array()) {
        return $this->api_lib->callApi('getPaymentReport', $data);
    }

    public function getPaymentReportByDateRange($data = array()) {
        return $this->api_lib->callApi('getPaymentReportByDateRange', $data);
    }

    public function getAdmissionReport($data = array()) {
        return $this->api_lib->callApi('getAdmissionReport', $data);
    }

    public function getAdmissionReportByDateRange($data = array()) {
        return $this->api_lib->callApi('getAdmissionReportByDateRange', $data);
    }

    public function getDiscountReport($data = array()) {
        return $this->api_lib->callApi('getDiscountReport', $data);
    }

}
