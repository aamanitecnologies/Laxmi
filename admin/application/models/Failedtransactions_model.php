<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Failedtransactions_model extends CI_Model {

    public function getPgTransactions($data = array()) {
        return $this->api_lib->callApi('getPgTransactions', $data);
    }

    public function getPgTransactionById($data = array()) {
        return $this->api_lib->callApi('getPgTransactionById', $data);
    }

    public function deletePgTransactionById($data = array()) {
        return $this->api_lib->callApi('deletePgTransactionById', $data);
    }

}
