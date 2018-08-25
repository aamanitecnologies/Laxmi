<?php $this->load->view('includes/head'); ?>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header clearfix">
                <h5 class="float-xs-left mb-0">Invoice #<?php echo $detail->payload->invoice->id; ?></h5>
                <div class="float-xs-right"><?php echo dateFromat($detail->payload->invoice->created_at); ?></div>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-sm-8 col-xs-6">
                        <h5>Rahul's IAS,</h5>
                        <p><a class="text-primary" href="#"><span class="underline">www.rahulsias.com</span></a>                                            
                        </p>
                        <p>GSTIN: 07AFDPR6397F1Z1</p>
                        <p>Plot No. B13<br>1st Floor,Commercial Complex,<br>Mukharjee Nagar, Delhi - 110009<br>Near Batra Cinemas<br>India</p>
                        <p>Telephone: 011 - 27655845, 011 - 27654216<br>Mobile: 9811195920</p>
                        <h5>Invoice To:</h5>
                        <p class="mb-0"><?php echo $detail->payload->invoice->fname . ' ' . $paylaod->invoice->lname; ?> <br><?php echo $detail->payload->invoice->student_id; ?></p>
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-right" style="background: black;"><img width="150" src="<?php echo base_url(); ?>assets/img/logo.png"></span>
                        </div><br>
                        <h5>Payment Details:</h5>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Total Fee:</span>
                            <span class="float-xs-right"><?php echo $detail->payload->invoice->payment_amount; ?></span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Coaching Fee:</span>
                            <span class="float-xs-right"><?php echo $detail->payload->invoice->tuition_fee; ?></span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">GST (18%):</span>
                            <span class="float-xs-right"><?php echo $detail->payload->invoice->gst; ?></span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Pay Mode:</span>
                            <span class="float-xs-right"><?php echo $detail->payload->invoice->payment_mode; ?></span>
                        </div>
                        <?php if ($data->payload->invoice->payment_mode_id != 1) { ?>
                            <div class="clearfix mb-0-25">
                                <span class="float-xs-left">Bank Name:</span>
                                <span class="float-xs-right"><?php echo $detail->payload->invoice->payment_bank_name; ?></span>
                            </div>
                            <div class="clearfix mb-0-25">
                                <span class="float-xs-left">IFSC Code:</span>
                                <span class="float-xs-right"><?php echo $detail->payload->invoice->payment_bank_ifsc; ?></span>
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <table class="table table-bordered table-striped mb-2">
                    <thead>
                        <tr>
                            <th>
                                Payment Type
                            </th>
                            <th>
                                Coaching Fee
                            </th>
                            <th>
                                GST (18%)
                            </th>
                            <th>
                                Total Fee
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (!empty($detail->payload->invoice)) {
                            ?>
                            <tr>
                                <td><?php echo $detail->payload->invoice->payment_type; ?></td>
                                <td><?php echo $detail->payload->invoice->tuition_fee; ?></td>
                                <td><?php echo $detail->payload->invoice->gst; ?></td>
                                <td><?php echo $detail->payload->invoice->payment_amount; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-6">
                        <strong>Terms and Conditions</strong>
                        <p class="text-muted mb-0">Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
                        <span><img width="200" src="<?php echo $detail->payload->invoice->file_url; ?>"></span>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-xs-right">
                            <div class="mb-0-5">Sub - Total amount: <b><?php echo $detail->payload->invoice->tuition_fee; ?></b></div>
                            <div class="mb-0-5">GST: <?php echo $detail->payload->invoice->gst; ?></div>
                            Grand Total: <strong><?php echo $detail->payload->invoice->payment_amount; ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer_incs'); ?>
