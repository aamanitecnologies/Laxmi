<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {

    public function getAllInvoices($data = array()) {
        return $this->api_lib->callApi('getAllInvoices', $data);
    }

    public function getInvoiceById($data = array()) {
        return $this->api_lib->callApi('getInvoiceById', $data);
    }
    
    public function getOldInvoiceById($data = array()) {
        return $this->api_lib->callApi('getOldInvoiceById', $data);
    }

    public function getInvoicesByStudentId($data = array()) {
        return $this->api_lib->callApi('getInvoicesByStudentId', $data);
    }

    public function payFee($data = array()) {
        return $this->api_lib->callApi('payFee', $data);
    }

    public function update($data = array()) {
        return $this->api_lib->callApi('editPayFee', $data);
    }

    public function getBankDetail($data = array()) {
        return $this->api_lib->callApi('getBankDetail', $data);
    }

    public function transactionReceipt($data = array()) {
        return $this->api_lib->callApi('transactionReceipt', $data);
    }

}
