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
                                <div class="card-header text-uppercase"><b>Debits</b></div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr id="r<?php echo $debitnotes->payload->debitnotes->id; ?>">
                                                <th>Credit Note No.</th>
                                                <th>Registration No.</th>
                                                <th>Name</th>
                                                <th>Phone No.</th>
                                                <th>Refund Date</th>
                                                <!--th>Action</th-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!$debitnotes->status->error) {
                                                foreach ($debitnotes->payload->debit_notes as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><a href="<?php echo site_url('debitnotes/detail/' . $val->id); ?>"><?php echo $val->id; ?></a></td>
                                                        <td><a href="<?php echo site_url('students/profile/' . $val->registration_no); ?>"><?php echo getRegNo($val); ?></a></td>
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><?php echo $val->phone; ?></td>
                                                        <td><?php echo dateFromat($val->created_at); ?></td>
                                                        <!--td><button type="button" data-id="<?php echo $val->id; ?>" class="btn btn-primary btn-sm edit-btn edit-debitnotes">Edit</button></td-->
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
                                <div class="card-header text-uppercase"><b>Filter</b></div>
                                <div class="box box-block bg-white">
                                    <form method="post" id="filter">
                                        <div class="form-group">
                                            <label>Debit No.</label>
                                            <input type="text" required="required" class="form-control" name="debit_id" id="debit_id" placeholder="Search by debit id.">
                                        </div>
                                        <div class="float-xs-right">
                                            <button type="button" onclick="return window.location.replace('')" class="btn btn-default btn-sm">Reset</button>&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                        </div>
                                        <br/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Debit Notes Modal-->
                <div class="modal fade" id="edit-pay-fee-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Edit Refund</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form method="post" id="frm" class="update-debit-notes-frm">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Registration no.</label>
                                                <input type="text" id="edit-dis-student_id" class="form-control" disabled="disabled" >
                                                <input type="hidden" name="student_id" id="edit-student_id" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" id="dis-edit-student_name" disabled="disabled" value="" class="form-control">
                                                <input type="hidden" name="name" id="edit-student_name" value="" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <div class="form-group">
                                                    <input type="text" disabled="disabled" value="Refund Fee" class="form-control">
                                                    <input type="hidden" name="payment_type_id" id="edit-payment_type_id" value="3">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" required="" name="payment_amount" id="edit-payment_amount" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tution Fee</label>
                                                <input type="text" disabled="disabled" name="payment_tution_fee" id="edit-payment_tution_fee" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>CGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_cgst" id="edit-payment_cgst" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>SGST (9%)</label>
                                                <input type="text" disabled="disabled" name="payment_sgst" id="edit-payment_sgst" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label>Payment Mode</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-1" checked="checked" value="1" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cash</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-2" value="2" name="payment_mode_id" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cheque</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-3" name="payment_mode_id" value="3" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">DD</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-4" name="payment_mode_id" value="4" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">NEFT</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="custom-control custom-radio">
                                                            <input id="edit-pay-mode-5" name="payment_mode_id" value="5" type="radio" class="custom-control-input">
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">IMPS</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="edit-check-frm" style="display: none;">
                                                <div class="form-group">
                                                    <label>Refrence No</label>
                                                    <input type="text" name="payment_bank_ref_number" id="edit-payment_bank_ref_number" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>IFSC</label>
                                                    <div class="input-group">
                                                        <input type="text" name="payment_bank_ifsc" id="edit-payment_bank_ifsc" class="form-control">
                                                        <div class="input-group-addon edit-search-bank" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="payment_bank_name" id="edit-payment_bank_name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Branch Name</label>
                                                    <input type="text" name="payment_bank_branch_name" id="edit-payment_bank_branch_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <span class="pull-left loader"></span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="sumit" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="debit_id" id="edit-debit-id">
                            </form>
                        </div>
                    </div> 
                </div>
                <!-- Edit Select Bank Model -->
                <div class="modal fade" id="edit-bank-detail-modal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="card-header text-uppercase"><b>Select Bank</b>
                                <button type="button" class="close" 
                                        data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <table class="table table-striped table-bordered dataTable" id="table-0">
                                    <thead>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <th>Bank Name</th>
                                            <th>Branch Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('includes/footer_view'); ?>
            </div>
        </div>

        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(function () {
                    $("#filter").on("submit", function (event) {
                        event.preventDefault();
                        $('.loader').html('loading...');
                        $.ajax({
                            url: site_url + "debitnotes/filter",
                            type: "post",
                            data: $(this).serialize(),
                            success: function (data) {
                                var obj = $.parseJSON(data);
                                table.clear();
                                table.draw(false);
                                if (obj.status.error) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                if (obj.payload.invoice.id) {
                                    table.row.add([
                                        '<a href="<?php echo site_url('invoices/detail/'); ?>' + obj.payload.invoice.id + '">' + obj.payload.invoice.id + '</a>',
                                        '<a href="<?php echo site_url('students/profile/'); ?>' + obj.payload.invoice.student_id + '">' + getRegNo(obj.payload.invoice) + '</a>',
                                        obj.payload.invoice.fname + ' ' + obj.payload.invoice.lname,
                                        obj.payload.invoice.phone,
                                        obj.payload.invoice.created_at,
                                        '<button type="button" data-id="'+obj.payload.invoice.id+'" class="btn btn-primary btn-sm edit-btn edit-debitnotes">Edit</button>'
                                    ]).node().id = 'r';
                                }
                                table.draw(false);
                                
                                $(".edit-debitnotes").on("click", function(event) {
                                    var debit_id = $(this).data("id");
                                    editHandler(debit_id);
                                });
                            }
                        });
                    });
                });
                // Edit Debit Notes
                $(".edit-debitnotes").on("click", function (event) {
                    var debit_id = $(this).data("id");
                    editHandler(debit_id);
                });
                
                function editHandler(id) {
                     event.preventDefault();
                    $('#edit-pay-fee-modal').modal('show');
                    var debit_id = id;
                    $('#edit-debit-id').val(debit_id);
                    $.ajax({
                        url: site_url + 'debitnotes/getDebitNotesById',
                        type: "post",
                        data: {debit_id: debit_id},
                        cache: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error === true) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            $('#edit-dis-student_id').val(obj.payload.invoice.student_id);
                            $('#edit-student_id').val(obj.payload.invoice.student_id);
                            $('#dis-edit-student_name').val(obj.payload.invoice.fname + ' ' + obj.payload.invoice.lname);
                            $('#edit-student_name').val(obj.payload.invoice.fname + ' ' + obj.payload.invoice.lname);
                            $('#edit-payment_amount').val(obj.payload.invoice.payment_amount);
                            $('#edit-payment_tution_fee').val(getTuitionFee(obj.payload.invoice.payment_amount));
                            $('#edit-payment_cgst').val(getCgst(obj.payload.invoice.payment_amount));
                            $('#edit-payment_sgst').val(getSgst(obj.payload.invoice.payment_amount));
                            $('#edit-payment_bank_branch_name').val(obj.payload.invoice.payment_bank_branch_name);
                            $('#edit-payment_bank_ifsc').val(obj.payload.invoice.payment_bank_ifsc);
                            $('#edit-payment_bank_name').val(obj.payload.invoice.payment_bank_name);
                            $('#edit-payment_bank_ref_number').val(obj.payload.invoice.payment_bank_ref_number);
                            $("#edit-pay-mode-" + obj.payload.invoice.payment_mode_id).click();
                            if (obj.payload.invoice.payment_mode_id !== 1) {
                                $('#edit-check-frm').show();
                            }else{
                                $('#edit-check-frm').hide();
                            }
                        }
                    });
                }
                
                $('#edit-pay-mode-1').on('click', function () {
                    $('#payment_bank_name').prop('required', false);
                    $('#payment_bank_ref_number').prop('required', false);
                    $('#payment_bank_ifsc').prop('required', false);
                    $('#edit-check-frm').hide();
                });
                $('#edit-pay-mode-2').on('click', function () {
                    $('#payment_bank_name').prop('required', true);
                    $('#payment_bank_ref_number').prop('required', true);
                    $('#payment_bank_ifsc').prop('required', true);
                    $('#edit-check-frm').show();
                });
                $('#edit-pay-mode-3').on('click', function () {
                    $('#payment_bank_name').prop('required', true);
                    $('#payment_bank_ref_number').prop('required', true);
                    $('#payment_bank_ifsc').prop('required', true);
                    $('#edit-check-frm').show();
                });
                $('#edit-pay-mode-4').on('click', function () {
                    $('#payment_bank_name').prop('required', true);
                    $('#payment_bank_ref_number').prop('required', true);
                    $('#payment_bank_ifsc').prop('required', true);
                    $('#edit-check-frm').show();
                });
                $('#edit-pay-mode-5').on('click', function () {
                    $('#payment_bank_name').prop('required', true);
                    $('#payment_bank_ref_number').prop('required', true);
                    $('#payment_bank_ifsc').prop('required', true);
                    $('#edit-check-frm').show();
                });

                // Search Banks
                $('.edit-search-bank').on('click', function () {
                    $('#edit-bank-detail-modal').modal('show');
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'invoices/getBankDetail',
                        type: "post",
                        data: {search_ifsc: $('#edit-payment_bank_ifsc').val()},
                        cache: false,
                        success: function (data) {
                            var obj = jQuery.parseJSON(data);
                            if (obj.status.error === true) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            table = $('#table-0').DataTable();
                            table.clear();
                            for (var i = 0; i < obj.payload.bank_details.length; i++) {
                                var vals = "'" + obj.payload.bank_details[i].ifsc_code + "', '" + obj.payload.bank_details[i].bank_name + "', '" + obj.payload.bank_details[i].branch_name + "'";
                                table.row.add([
                                    obj.payload.bank_details[i].ifsc_code,
                                    obj.payload.bank_details[i].bank_name,
                                    obj.payload.bank_details[i].branch_name,
                                    '<button type="button" onClick="editSelectedBank(' + vals + ');" class="btn btn-info btn-sm select">Select</button>'
                                ]).node().id = 'ar' + obj.payload.bank_details[i].id;
                            }
                            table.draw(false);
                            loaderSuccess();
                        }
                    });
                });
                // Update Debit Notes
                $(".update-debit-notes-frm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'debitnotes/update',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error === true) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            $('#edit-pay-fee-modal').modal('hide');
                            window.location.replace(site_url + 'debitnotes/detail/' + obj.payload.invoice.id);
                        }
                    });
                });
            });
            function editSelectedBank(ifsc_code, bank_name, branch_name) {
                $('#edit-bank-detail-modal').modal('hide');
                $('#edit-payment_bank_ifsc').val(ifsc_code);
                $('#edit-payment_bank_name').val(bank_name);
                $('#edit-payment_bank_branch_name').val(branch_name);
            }
        </script>
    </body>
</html>