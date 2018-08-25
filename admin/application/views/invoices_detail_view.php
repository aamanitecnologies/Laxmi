<!DOCTYPE html>
<html lang="en">
    <?php //$this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content" id="DivIdToPrint">
                <!-- Vendor CSS -->
                <!-- Vendor CSS -->
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themify-icons.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.jscrollpane.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/waves.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.bootstrap4.min.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
                <?php if ($this->uri->segment(2) == 'documents') { ?>
                    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/signature-pad.css">
                <?php } ?>


                <!-- Neptune CSS -->
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/core.css">

                <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
                <!-- Content -->
                <div class="content-area bg-white">
                    <div class="container-fluid" style="padding-left: 35px;">
                        <div id="rcorners1">
                            <div><h4>TAX INVOICE</h4></div>
                            <div>
                                <img style="padding-left:128px;" width="400" src="<?php echo base_url('assets/img/logo.jpg'); ?>">
                                <table align="right" style="font-size: 10;">
                                    <tr>
                                        <td align="right">Receipt No.</td>
                                        <td align="cneter">:</td>
                                        <td align="left"><span style="font-size: 10; font-weight: bold;"><?php echo 'RIAS/' . date('Y', strtotime($detail->payload->invoice->created_at)) . '/' . $detail->payload->invoice->id; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Date</td>
                                        <td align="center">:</td>
                                        <td align="left"><?php echo dateFromat($detail->payload->invoice->created_at); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="padding-top: 10px;">
                                B-13, 1st Floor, Commercial Complex, Dr. Mukherjee Nagar, Delhi-9<br>
                                <h6>Phone No : 011-27654216, 27655845, 9811195920<br>
                                    E-mail : rahuls_ias@rediffmail.com, rahulsiaslaw@gmail.com<br>
                                    GSTIN : 07AFDPR6397F1Z1</h6>
                            </div>
                            <table width='100%' style="font-size: 11px;">
                                <tr>
                                    <td valign='top' width="50%">
                                        <table cellpadding="3" style="font-size: 11px;" valign="middle" width='100%' border='1'>
                                            <tr>
                                                <td width='40%' align="right"><b>Name :</b></td>
                                                <td align="left"><b><?php echo $detail->payload->invoice->fname; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Reg.No. :</b></td>
                                                <td align="left"><?php if(strtotime($detail->payload->invoice->student_created_at) > strtotime('2018-03-31')){echo getRegNo($detail->payload->invoice); }else{echo getOldRegNo($detail->payload->invoice);} ?></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Father's Name :</b></td>
                                                <td align="left"><?php echo $detail->payload->invoice->fathers_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Contact No. :</b></td>
                                                <td align="left"><?php echo $detail->payload->invoice->mobile; ?></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Address :</b></td>
                                                <td align="left"><?php echo $detail->payload->invoice->permanant_address; ?></td>
                                            </tr>
                                        </table></td>
                                    <td valign='top'>
                                        <table width='100%' style="font-size: 11px;" cellpadding="3" valign="middle" border='1'>
                                            <tr>
                                                <td width='30%' align="right"><b>Course :</b></td>
                                                <td align="left"><b><?php echo $detail->payload->invoice->course_name; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Total Fees :</b></td>
                                                <td align="left"><b><?php echo number_format((float) $detail->payload->invoice->total_course_fee, 2, '.', ','); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width='30%' align="right"><b>Batch :</b></td>
                                                <td align="left"><?php echo $detail->payload->invoice->batch_code; ?> | <?php echo dateFromat($detail->payload->invoice->batch_start_date); ?></td>
                                            </tr>
                                        </table>
                                        <div style="text-align: left; font-weight: bold;">
                                            <table width="100%" style="font-size: 11px;">
                                                <tr>
                                                    <td width="35%">Bank Name</td>
                                                    <td>:</td>
                                                    <td>HDFC BANK LIMITED</td>
                                                </tr>
                                                <tr>
                                                    <td>IFSC Code</td>
                                                    <td>:</td>
                                                    <td>HDFC0000247</td>
                                                </tr>
                                                <tr>
                                                    <td>Account No.</td>
                                                    <td>:</td>
                                                    <td>02472560001219</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="padding-top: 5px;">
                            <div id="rcorners2">
                                <div style="padding-top: 20px;">
                                    <table width='100%' style="font-size: 11px;" cellpadding="3" valign="middle" border='1'>
                                        <tr>
                                            <th width='10%'>Sr.No.</th>
                                            <th>Description</th>
                                            <th width='10%'>SAC CODE</th>
                                            <th width='10%'>Tax Rate</th>
                                            <th style="text-align: center;" width='30%'>Amount</th>
                                        </tr>
                                        <tr>
                                            <th width='10%'>1.</th>
                                            <th>Coaching Fees</th>
                                            <!--th width='10%'>00440229</th-->
                                            <th width='10%'>999293</th>
                                            <th width='10%'></th>
                                            <th style="text-align: right;" align='right' width='30%'><?php echo number_format((float) $detail->payload->invoice->tuition_fee, 2, '.', ','); ?></th>
                                        </tr>
                                        <tr>
                                            <th width='10%'>&nbsp;</th>
                                            <th></th>
                                            <th width='10%'></th>
                                            <th width='10%'></th>
                                            <th style="text-align: right;" align='right' width='30%'></th>
                                        </tr>
                                        <tr>
                                            <th width='10%'></th>
                                            <th>Taxable Value</th>
                                            <th width='10%'></th>
                                            <th width='10%'></th>
                                            <th style="text-align: right;" align='right' width='30%'><?php echo number_format((float) $detail->payload->invoice->tuition_fee, 2, '.', ','); ?></th>
                                        </tr>
                                        <tr>
                                            <th width='10%'></th>
                                            <th>CGST</th>
                                            <th width='10%'></th>
                                            <th style="text-align: center;" width='10%'>9%</th>
                                            <th style="text-align: right;" align='right' width='30%'><?php echo number_format((float) $detail->payload->invoice->cgst, 2, '.', ','); ?></th>
                                        </tr>
                                        <tr>
                                            <th width='10%'></th>
                                            <th>SGST</th>
                                            <th width='10%'></th>
                                            <th style="text-align: center;" width='10%'>9%</th>
                                            <th style="text-align: right;" align='right' width='30%'><?php echo number_format((float) $detail->payload->invoice->sgst, 2, '.', ','); ?></th>
                                        </tr>
                                        <tr>
                                            <th width='10%'></th>
                                            <th>Total Amount : </th>
                                            <th width='10%'></th>
                                            <th width='10%'></th>
                                            <th style="text-align: right;" align='right' width='30%'><?php echo number_format((float) $detail->payload->invoice->payment_amount, 2, '.', ','); ?></th>
                                        </tr>
                                        <tr>
                                            <td align='left' colspan="5" width='10%'><b style="padding-right: 20px;">Rs.(In Words):-</b><?php echo strtoupper(numberTowords($detail->payload->invoice->payment_amount)); ?> /-</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="padding-top: 10px;">
                                    <div style="text-align: left;"><b>Mode of Payment</b> : <?php echo $detail->payload->invoice->payment_mode; ?></div>
                                    <div>
                                        <table cellpadding="3" style="font-size: 11px;" valign="middle" width='100%' border='1'>
                                            <tr>
                                                <td>Cheque/DD No./Ref.No.</td>
                                                <td align='left'><?php echo ($detail->payload->invoice->payment_mode_id > 1)?($detail->payload->invoice->payment_mode_id == 6)?$detail->payload->invoice->pg_tracking_id:$detail->payload->invoice->payment_bank_ref_number:'NA'; ?></td>
                                                <td colspan="2">Balance and Due Date</td>
                                            </tr>
                                            <tr>
                                                <td>Bank</td>
                                                <td align='left'><?php echo ($detail->payload->invoice->payment_mode_id != 1)?$detail->payload->invoice->payment_bank_name:'NA'; ?></td>
                                                <td>Next Due Date</td>
                                                <td><?php echo $detail->payload->invoice->next_due_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td align='left'>Amount/Date</td>
                                                <td align='left'><?php echo number_format((float) $detail->payload->invoice->payment_amount, 2, '.', ',') . ' / ' . dateFromat($detail->payload->invoice->created_at); ?></td>
                                                <td>Total Due Amount</td>
                                                <td><?php echo number_format((float) $detail->payload->invoice->total_due_amount, 2, '.', ','); ?></td>
                                            </tr>
                                        </table>
                                        <div style="padding-top:10px;">
                                            <table width='100%'>
                                                <tr>
                                                    <td align='left' style="font-waight:bold;">
                                                        <strong>NOTE :
                                                        <ol style="padding-left:10px; font-size:10px; font-weight: bold;">
                                                            <li>Amount once paid is neither refundable nor adustable. Disputes are subject to Delhi jurisdiction only.</li>
                                                            <li>The cheque/Demand Draft should be crossed 'A/c Payee Only' and drawn in favour of 'RAHUL'S IAS' payable at Delhi.</li>
                                                            <li>Irregularity in classes is strictly prohibited. The institute will not be responsible for non-completion of the course if a student has been irregular to the classes (on whatever account). Irregular students will not be allowed to repeat the classes in the subsequent batches. In case of reasonably explained absence, the proprietor holds the discretion to allow repetition of classes in the subsequent batches. For any such absence, a written permission from the proprietor shall be obtained.</li>
                                                        </ol>
                                                            </strong>
                                                    </td>
                                                    <td width='27%'>
                                                        <div style="padding-top: 32px; font-weight: bold; font-weight: 9px;">
                                                            <div style="text-align: center; vertical-align: top;">For Rahul's IAS</div>
                                                            <div style="text-align: center; vertical-align: bottom; padding-top: 50px;">Authorised Signatory</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 30px; font-weight: bold; text-align: left; padding-left: 120px;" colspan="2" width='20%'>
                                                        Student Signature
                                                    </td>
                                                </tr>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //$this->load->view('includes/footer_view'); ?>
                </div>
                <?php $this->load->view('includes/footer_incs'); ?>
            </div>
            <div class="card-footer clearfix">
                <!--button type="button" onclick="getDownload();" class="btn btn-danger label-left float-xs-right">
                    <span class="btn-label"><i class="ti-download"></i></span>
                    Download
                </button-->
                <button type="button" onclick="printDiv();" class="btn btn-info label-left float-xs-right mr-0-5">
                    <span class="btn-label"><i class="ti-printer"></i></span>
                    Print
                </button>
            </div>

            <script type="text/javascript">
                function getDownload() {
                    window.location.replace("<?php echo site_url('invoices/download/' . $detail->payload->invoice->id); ?>");
                }
                function printDiv() {

                    var divToPrint = document.getElementById('DivIdToPrint');

                    var newWin = window.open('', 'Print-Window');

                    newWin.document.open();

                    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                    newWin.document.close();

                    setTimeout(function () {
                        newWin.close();
                    }, 10);

                }
            </script>
    </body>
</html>