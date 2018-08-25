<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function pr($data = array()) {
    echo'<pre>';
    print_r($data);
    echo'</pre>';
}

function dateFromat($date = '') {
    //return date('dS F Y', strtotime($date));
    return date('d F Y', strtotime($date));
}

function getPaymentMode($payment_type_id = 0) {
    switch ($payment_type_id) {
        case 1;
            $payment_type = 'Cash';
            break;
        case 2;
            $payment_type = 'Cheque';
            break;
        case 3;
            $payment_type = 'Demand Draft';
            break;
        case 4;
            $payment_type = 'NEFT';
            break;
        case 5;
            $payment_type = 'IMPS';
            break;
        case 6;
            $payment_type = 'Online Payment Gateway';
            break;
        default;
            $payment_type = 'Unknown';
    }
    return $payment_type;
}

function getPaymentType($payment_mode_id = 0) {
    switch ($payment_mode_id) {
        case 1;
            $payment_mode = 'Admission Fee';
            break;
        case 2;
            $payment_mode = 'Installment Fee';
            break;
        case 3;
            $payment_mode = 'Refund Fee';
            break;
        default;
            $payment_mode = 'Unknown';
    }
    return $payment_mode;
}

function getSBC($amount) {
    $coachingFee = getOldCoachingFee($amount);
    $sbc = ($coachingFee * 0.50) / 100;
    return $sbc;
}

function getKKC($amount) {
    $coachingFee = getOldCoachingFee($amount);
    $kkc = ($coachingFee * 0.50) / 100;
    return $kkc;
}

function getServiceTax($amount) {

    $coachingFee = getOldCoachingFee($amount);

    $serviceTax = ($coachingFee * 14) / 100;
    return $serviceTax;
}

function getOldCoachingFee($amount) {
    $coachingFee = round(($amount * 100) / 115);
    return $coachingFee;
}

function getCoachingFee($amount) {
    $cf = round(($amount / 118) * 100);
    return $cf;
}

function getCgst($amount = 0) {
    return getGst($amount) / 2;
}

function getSgst($amount = 0) {
    return getGst($amount) / 2;
}

function getGst($amount = 0) {
    return $amount - getCoachingFee($amount);
}

function getInvoiceId($data = array()) {
    if (strtotime($data->created_at) > strtotime('2017-07-01')) {
        $pre = 'RIAS';
        $year = date('Y', strtotime($data->created_at));
        $invoice_id = $data->id;
        $invoiceId = $pre . '/' . $year . '/' . $invoice_id;
    } else {
        $pre = 'R';
        $invoice_id = $data->id;
        $year = date('y', strtotime($data->created_at)) . '-' . (date('y', strtotime($data->created_at)) + 1);
        $invoiceId = $pre . '/' . $invoice_id . '/' . $year;
    }
    return $invoiceId;
}

function getRegNo($val) {
    if (isset($val->student_id)) {
        $val->id = $val->student_id;
    }
    if (isset($val->registration_no)) {
        $val->id = $val->registration_no;
    }
    if (isset($val->student_created_at)) {
        $created_at = $val->student_created_at;
    } else {
        $created_at = $val->created_at;
    }
    $preval = 'RIAS';
    $year = date('Y', strtotime($created_at));
    $course_code = 'JS'; //$val->course_code;
    $student_id = $val->id;
    $l = strlen($student_id);
    if ($l == 1) {
        $pre = '000';
    } elseif ($l == 2) {
        $pre = '00';
    } elseif ($l == 3) {
        $pre = '0';
    } else {
        $pre = '';
    }
    $regNo = $preval . '/' . $year . '/' . $course_code . '/' . $pre . $student_id;
    return $regNo;
}

function getOldRegNo($val) {
    if (isset($val->student_id)) {
        $val->id = $val->student_id;
    }
    if (isset($val->registration_no)) {
        $val->id = $val->registration_no;
    }
    if (isset($val->student_created_at)) {
        $created_at = $val->student_created_at;
    } else {
        $created_at = $val->created_at;
    }
    $preval = 'Reg-HO';
    $year = date('Y', strtotime($created_at)) . '-' . (date('Y', strtotime($created_at)) + 1);
    $student_id = $val->id;
    $l = strlen($student_id);
    if ($l == 1) {
        $pre = '000';
    } elseif ($l == 2) {
        $pre = '00';
    } elseif ($l == 3) {
        $pre = '0';
    } else {
        $pre = '';
    }
    $regNo = $preval . $pre . $student_id . '-' . $year;
    return $regNo;
}

function getOldReceiptNo($invoice_id, $created_at) {
    $preval = 'R';
    $l = strlen($invoice_id);
    if ($l == 1) {
        $pre = '000';
    } elseif ($l == 2) {
        $pre = '00';
    } elseif ($l == 3) {
        $pre = '0';
    } else {
        $pre = '';
    }
    $invoice_id = $pre . $invoice_id;
    $year = date('y', strtotime($created_at)) . '-' . (date('y', strtotime($created_at)) + 1);
    $receiptNo = $preval . '/' . $invoice_id . '/' . $year;
    return $receiptNo;
}

function numberTowords($number) {
    //$number = 190908100.25;
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
        } else
            $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
            "." . $words[$point / 10] . " " .
            $words[$point = $point % 10] : '';
    if($points){
        echo ucwords($result . "Rupees  " . $points . " Paise Only.");
    }else{
        echo ucwords($result . "Rupees Only.");
    }
}

function numberTowordsold($num) {
    $ones = array(
        1 => "one",
        2 => "two",
        3 => "three",
        4 => "four",
        5 => "five",
        6 => "six",
        7 => "seven",
        8 => "eight",
        9 => "nine",
        10 => "ten",
        11 => "eleven",
        12 => "twelve",
        13 => "thirteen",
        14 => "fourteen",
        15 => "fifteen",
        16 => "sixteen",
        17 => "seventeen",
        18 => "eighteen",
        19 => "nineteen"
    );
    $tens = array(
        1 => "ten",
        2 => "twenty",
        3 => "thirty",
        4 => "forty",
        5 => "fifty",
        6 => "sixty",
        7 => "seventy",
        8 => "eighty",
        9 => "ninety"
    );
    $hundreds = array(
        "hundred",
        "thousand",
        "million",
        "billion",
        "trillion",
        "quadrillion"
    ); //limit t quadrillion 
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {
        if ($i < 20) {
            $rettxt .= $ones[$i];
        } elseif ($i < 100) {
            $rettxt .= $tens[substr($i, 0, 1)];
            $rettxt .= " " . $ones[substr($i, 1, 1)];
        } else {
            $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
            $rettxt .= " " . $tens[substr($i, 1, 1)];
            $rettxt .= " " . $ones[substr($i, 2, 1)];
        }
        if ($key > 0) {
            $rettxt .= " " . $hundreds[$key] . " ";
        }
    }
    if ($decnum > 0) {
        $rettxt .= " and ";
        if ($decnum < 20) {
            $rettxt .= $ones[$decnum];
        } elseif ($decnum < 100) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
        }
    }
    return $rettxt;
}
