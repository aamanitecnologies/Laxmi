<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OldStudents extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
    }

    public function index() {
        $data['batches'] = $this->api_lib->callApi('getOldBatches', array());
        $this->load->view('old_contacts_view', $data);
    }
    
    public function getContactsByBatchId($batch_id){
        $requests = array(
          'batch_id' => $batch_id
        );
        $response = $this->api_lib->callApi('getContactsByBatchId', $requests);//9899596938,9990771758
        
        $contacts='';
        foreach ($response->payload->students as $val){
           $contacts .= $val->mobile.',';
        }
        echo substr($contacts, 0,-1);        
    }

    public function sendSms(){
        $text_sms = $this->input->post('text_sms');
        $contacts = $this->input->post('contacts');
        echo $this->api_lib->sendSmsApi($contacts, $text_sms);
    }

}
