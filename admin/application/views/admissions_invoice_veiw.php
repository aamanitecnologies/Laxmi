<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="content-area py-1">
                    <div class="container-fluid">
                        <h4>Invoice</h4>
                        
                        <div class="card">
                            <div class="card-header clearfix">
                                <h5 class="float-xs-left mb-0">Invoice #49021</h5>
                                <div class="float-xs-right">January 25, 2017</div>
                            </div>
                            <div class="card-block">
                                <div class="row mb-2">
                                    <div class="col-sm-8 col-xs-6">
                                        <h5>Google Inc,</h5>
                                        <p><a class="text-primary" href="#"><span class="underline">www.google.com</span></a></p>
                                        <p>1 Infinite Loop<br>95014 Cuperino, CA<br>United States</p>
                                        <p>Telephone: 800-692-7753<br>Fax: 800-692-7753</p>
                                        <h5>Invoice To:</h5>
                                        <p class="mb-0">John Smith <br>Normand axis LTD 3 Goodman street</p>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <h5>Payment Details:</h5>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Total Due:</span>
                                            <span class="float-xs-right">$1205</span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Bank Name:</span>
                                            <span class="float-xs-right">Profit Bank Europe</span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Country:</span>
                                            <span class="float-xs-right">United Kingdom</span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">City:</span>
                                            <span class="float-xs-right">London E18BF</span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">Address:</span>
                                            <span class="float-xs-right">3 Goodman Street</span>
                                        </div>
                                        <div class="clearfix mb-0-25">
                                            <span class="float-xs-left">IBAN:</span>
                                            <span class="float-xs-right">KFH37784028476740</span>
                                        </div>
                                        <div class="clearfix">
                                            <span class="float-xs-left">SWIFT Code:</span>
                                            <span class="float-xs-right">BPT4E</span>
                                        </div>
                                    </div>

                                </div>
                                <table class="table table-bordered table-striped mb-2">
                                    <thead>
                                        <tr>
                                            <th>
                                                Description
                                            </th>
                                            <th>
                                                Hours
                                            </th>
                                            <th>
                                                Unit Price
                                            </th>
                                            <th>
                                                Total Price
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Design Services on 12 Feb 2016</td>
                                            <td>5</td>
                                            <td>$50</td>
                                            <td>$500</td>
                                        </tr>
                                        <tr>
                                            <td>Design Services on 24 Feb 2016</td>
                                            <td>15</td>
                                            <td>$50</td>
                                            <td>$1500</td>
                                        </tr>
                                        <tr>
                                            <td>Design Services on 12 Feb 2016</td>
                                            <td>5</td>
                                            <td>$50</td>
                                            <td>$500</td>
                                        </tr>
                                        <tr>
                                            <td>Design Services on 24 Feb 2016</td>
                                            <td>15</td>
                                            <td>$50</td>
                                            <td>$1500</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <strong>Terms and Conditions</strong>
                                        <p class="text-muted mb-0">Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="text-xs-right">
                                            <div class="mb-0-5">Sub - Total amount: <b>$4,800</b></div>
                                            <div class="mb-0-5">VAT: $35</div>
                                            Grand Total: <strong>$4,000</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="button" class="btn btn-danger label-left float-xs-right">
                                    <span class="btn-label"><i class="ti-download"></i></span>
                                    Download
                                </button>
                                <button type="button" class="btn btn-info label-left float-xs-right mr-0-5">
                                    <span class="btn-label"><i class="ti-printer"></i></span>
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('includes/footer_view'); ?>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/batches.js"></script>
    </body>
</html>