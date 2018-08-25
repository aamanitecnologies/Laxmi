<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_lib {

    //protected $mEndpoint = 'https://api.rahulsias.com/v1/index.php/';
    protected $mEndpoint = 'http://localhost/farmaceutical/api/v1/index.php/';

    public function callApi($api, $data = array()) {

        
        
        $CI = & get_instance();
        if ($api != 'staff_login') {
            $data['session_key'] = $CI->session->userdata('session')->payload->session->session_key;
        }

        $data['startDate'] = $CI->session->userdata('FISCAL_YEAR')['startDate'];
        $data['endDate'] = $CI->session->userdata('FISCAL_YEAR')['endDate'];

        $api_endpoint = $this->mEndpoint . $api;
        $post_data = json_encode($data);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($post_data),
          "Expect:  ")
        ); //multipart/form-data
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $server_output = curl_exec($ch);
                
        if (curl_errno($ch) !== 0) {
            echo 'cURL error when connecting to ' . $url . ': ' . curl_error($ch);
            die();
        }
        curl_close($ch);
        $server_output = json_decode($server_output);
        return $server_output;
    }

    public function callApiByPhp($api, $data = array()) {
        $CI = & get_instance();
        if ($api != 'staff_login') {
            $data['session_key'] = $CI->session->userdata('session')->payload->session->session_key;
        }
        $url = $this->mEndpoint . $api;
        // use key 'http' even if you send the request to https://...
        $options = array(
          'http' => array(
            'header' => "Content-type: application/json",
            'method' => 'POST',
            'content' => json_encode($data),
          ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result);
        return $result;
    }

    public function fileUpload($api = '', $data = array()) {
        try {
            $CI = & get_instance();
            if ($api != 'staff_login') {
                $data['session_key'] = $CI->session->userdata('session')->payload->session->session_key;
            }
            $api_endpoint = $this->mEndpoint . $api;
            $post_data = $data;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_endpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Expect:  ",
              'Content-Type: multipart/form-data'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $server_output = curl_exec($ch);
            $server_output = json_decode($server_output);
            if ($server_output == true) {
                return $server_output;
            } else {
                return curl_error($ch);
            }
            curl_close($ch);
        } catch (Exeption $e) {
            return $e->getMessage();
        }
    }

    public function sendSmsApi($contacts, $sms_text) {
        $user = 'vikas1';
        $pass = 'vikas1';
        $sendId = 'RAHULL';//RAHULS
        $clientId = 'e7fc193b-b471-4a6c-a0a4-19b37428cfe3';
        $apiKey = 'b9a256e1-df14-4197-b4e6-9944954b27fe';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://103.209.146.119/vendorsms/pushsms.aspx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "clientid=$clientId&apikey=$apiKey&user=$user&password=$pass&msisdn=$contacts&sid=$sendId&msg=$sms_text&fl=0&gwid=2");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}
