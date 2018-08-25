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
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="card-header text-uppercase">
                                <b>Student Payment Report</b>
                                <span class="pull-right"><a id="download" href="<?php echo site_url('reports/downloadStudentPaymentReport'); ?>" class="btn btn-primary btn-sm" >Download All</a></span>
                            </div>
                            <div class="box box-block bg-white">
                                <table class="table table-striped table-bordered dataTable" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Invoice Id</th>
                                            <th>Payment Date</th>
                                            <th>Registration No.</th>
                                            <th>Student Name</th>
                                            <th>Batch</th>
                                            <th>Payment Mode</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($paymentReport->status->error == false) {
                                            foreach ($paymentReport->payload->paymentReport as $val) {

                                                if($val->payment_mode_id == 1){
                                                    $total_cash_amount = $total_cash_amount + $val->payment_amount;
                                                }

                                                ?>
                                                <tr id="r<?php echo $val->id; ?>">
                                                <td><a href="<?php echo site_url('invoices/detail/' . $val->id . '/'. $val->student_created_at.'/'. $val->created_at); ?>"><?php echo $val->id; ?></a></td>
                                                    <td><?php echo dateFromat($val->created_at); ?></td>
                                                    <td><a href="<?php echo site_url('students/profile/' . $val->student_id); ?>"><?php echo getRegNo($val); ?></a></td>
                                                    <td><?php echo $val->fname; ?></td>
                                                    <td><?php echo $val->batch_code . '<br>' . dateFromat($val->batch_start_date); ?></td>
                                                    <td><?php echo getPaymentMode($val->payment_mode_id); ?></td>
                                                    <td><?php echo $val->payment_amount; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card-header text-uppercase">
                                <b>Filter</b>
                            </div>
                            <div class="box box-block bg-white">
                                <form method="post" id="payment-report-frm">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select name="payment_mode_id" class="form-control">
                                                <option value="">All Payment Mode</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Cheque</option>
                                                <option value="3">Demand Draft</option>
                                                <option value="4">NEFT</option>
                                                <option value="5">IMPS</option>
                                                <option value="6">Online Payment Gateway</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Invoice From</label>
                                            <input type="text" required="required" id="datepicker-invoice-from" name="invoice_from"  class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Invoice To</label>
                                            <input type="text" required="required" id="datepicker-invoice-to" name="invoice_to"  class="form-control">
                                        </div>
                                    </div>                                        
                                    <div class="float-xs-right">
                                        <button type="button" class="btn btn-default btn-sm">Reset</button>&nbsp;&nbsp;
                                        <button type="submit" id="filter" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                    <br/>
                                </form>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-6 col-xs-12">
                            <div class="box box-block bg-white tile tile-1 mb-2">
                                <div class="t-icon right"><span class="bg-danger"></span><i class="ti-shopping-cart-full"></i></div>
                                <div class="t-content">
                                    <h6 class="text-uppercase mb-1">Total Cash Amount</h6>
                                    <h1 class="mb-1" id="total_cash_amount"><?php echo $total_cash_amount;?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <?php $this->load->view('includes/footer_view'); ?>
        </div>
    </div>

    <!-- Add new course -->
    <div class="modal fade" id="add-new-course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" 
                    data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Add new batch code
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batch code</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batch code display</label>
                                <input type="text" class="form-control" name="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batch code</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Batch code display</label>
                                <input type="text" class="form-control" name="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Delete
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <h5 class="text-xs-center">Are you sure want to delete this?</h5>

            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    No
                </button>
                <button type="button" class="btn btn-primary">
                    Yes
                </button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer_incs'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/reports.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        table.column('0:visible').order('ASC').draw(false);

        $('#datepicker-invoice-from').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        $('#datepicker-invoice-to').datepicker({
            autoclose: true,
            todayHighlight: true
        });

        $('#filter').on('click', function () {
            $("#download").html('Download From ' + dateFormate($('#datepicker-invoice-from').val()) + ' To ' + dateFormate($('#datepicker-invoice-to').val()));
            $("#download").attr("href", "<?php echo site_url('reports/downloadStudentPaymentReport/'); ?>" + dateFormate($('#datepicker-invoice-from').val()) + '/' + dateFormate($('#datepicker-invoice-to').val()));
        });
    });
</script>
</body>
</html>