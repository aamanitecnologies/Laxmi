<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="content-area pb-1">
                    <div class="profile-header mb-1">
                        <div class="profile-header-counters clearfix">
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <div class="card profile-card">
                                    <div class="profile-avatar">
                                        <img width="200" src="<?php echo $student->payload->student->file_url; ?>" alt="">
                                    </div>
                                    <div class="card-block">
                                        <h4><?php echo $student->payload->student->fname . ' ' . $student->payload->student->lname; ?> <span title="edit" class="edit-profile" style="cursor: pointer; float: right; font-size: 14px; color:#aaa; padding:4px 0 0 0;"><i class="ti-pencil"></i></span></h4>
                                        <h5 class="mb-0-25"><span class="batch-name-head" title="batch name" id="batch_code_p"><?php echo $student->payload->student->batch_code; ?></span> | <span class="batch-code-head" title="batch code" id="batch_start_date_p"><?php echo $student->payload->student->batch_start_date; ?></span></h5>
                                        <div class="text-muted mb-1" id="batch_course_name_p"><?php echo $student->payload->student->course_name; ?></div>
                                        <div class="text-muted mb-1"><?php echo $student->payload->student->id; ?></div>
                                        <label id="admission" class="btn <?php echo($fee_status) ? 'btn-success' : 'btn-danger'; ?> btn-sm label-left b-a-0 waves-effect waves-light mb-0-5" style="cursor: default;">
                                            <span class="btn-label"><i id="admission_i" class="ti-<?php echo($fee_status) ? 'check' : 'close'; ?>"></i></span>
                                            <span id="admission_text"><?php echo($fee_status) ? 'Seat Confirmed' : 'Seat Unconfirm'; ?></span>
                                        </label>
                                    </div> 
                                </div>
                                <div class="card">
                                    <div class="card-header text-uppercase"><b>Action</b></div>
                                    <div class="card-block">

                                        <div style="margin-bottom: 8px;">
                                            <button type="button" id="pay-fee" class="btn btn-success enable-admission">Pay Fee</button>
                                            <span id="admission_status" style="display: none;">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="box bg-white">
                                    <div class="card-header text-uppercase"><b>Student informations</b></div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <p class="first-name"><strong>First name</strong></p>
                                                        <p class="last-name"><strong>Last name</strong></p>
                                                        <p class="law-school"><strong>Law School</strong></p>
                                                        <p class="yop"><strong>Year Of Passing</strong></p>
                                                        <p class="referred-by"><strong>Referred By</strong></p>
                                                        <p class="course-name"><strong>Course name</strong></p>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <p class="first-name-val"><?php echo $student->payload->student->fname; ?></p>
                                                        <p class="last-name-val"><?php echo $student->payload->student->lname; ?></p>
                                                        <p class="Law-school-val"><?php echo $student->payload->student->law_school; ?></p>
                                                        <p class="yop-val"><?php echo $student->payload->student->yop; ?></p>
                                                        <p class="referred-by-val"><?php echo $student->payload->student->referred_by; ?></p>
                                                        <p class="course-name-val"><?php echo $student->payload->student->course_name; ?></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary edit-informations">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <p class="father-name"><strong>Father's name</strong></p>
                                                        <p class="occupation"><strong>Father's occupation</strong></p>
                                                        <p class="father-phone"><strong>Phone</strong></p>
                                                        <p class="student-email"><strong>Student email</strong></p>
                                                        <p class="student-mobile"><strong>Student mobile</strong></p>
                                                        <p class="temporary-add"><strong>Temporary address</strong></p>
                                                        <p class="permanent-add"><strong>Permanent address</strong></p>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <p class="father-name-val"><?php echo $student->payload->student->fathers_name; ?></p>
                                                        <p class="occupation-val"><?php echo $student->payload->student->fathers_occupation; ?></p>
                                                        <p class="father-phone-val"><?php echo $student->payload->student->phone; ?></p>
                                                        <p class="student-email-val">email</p>
                                                        <p class="student-mobile-val"><?php echo $student->payload->student->mobile; ?></p>
                                                        <p class="temporary-add-val"><?php echo $student->payload->student->local_address; ?></p>
                                                        <p class="permanent-add-val"><?php echo $student->payload->student->permanant_address; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box bg-white">
                                    <div class="card-header text-uppercase"><b>Fee details</b></div>
                                    <br/>
                                    <div class="table-responsive pa-0-75">
                                        <table class="table table-striped table-bordered dataTable" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No.</th>
                                                    <th>Amount Paid</th>
                                                    <th>Date Of Payment</th>
                                                    <th>Mode Of Payment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!$invoices->payload->invoices->status->error) {
                                                    foreach ($invoices->payload->invoices as $val) {
                                                        ?>
                                                        <tr id="r<?php echo $val->id; ?>">
                                                            <td><a href="<?php echo site_url('admissions/invoice/' . $val->id); ?>"><?php echo $val->id; ?></a></td>
                                                            <td><?php echo $val->payment_amount; ?></td>
                                                            <td><?php echo $val->created_at; ?></td>
                                                            <td><?php echo ($val->payment_mode_id == 1) ? 'Cash' : ($val->payment_mode_id == 2) ? 'Check' : 'DD'; ?></td>
                                                            <td>
                                                                <button type="button" onClick="editRec('<?php echo $val->id; ?>');" class="btn btn-primary btn-sm edit-btn">Edit</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-xs-center">
                            <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                                2018 © Rahul's IAS
                            </div>
                            <div class="col-sm-8 text-sm-right">
                                <ul class="nav nav-inline l-h-2">
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Privacy</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Terms</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Help</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Pay Fee -->
        <div class="modal fade" id="pay-fee-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Pay Fee</b></div>
                    <!-- Modal Body -->
                    <form method="post" id="frm" class="add-fee-frm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Registration no.</label>
                                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->id; ?>">
                                        <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select required="required" name="payment_type_id" id="payment_type_id" class="form-control">
                                            <option value="">Please Select Payment Type</option>
                                            <option value="1">Admission Fee</option>
                                            <option value="2">Installment Fee</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="student_name" id="student_name" value="<?php echo $student->payload->student->fname . ' ' . $student->payload->student->lname; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="text" name="payment_amount" id="payment_amount" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tution Fee</label>
                                        <input type="text" disabled="disabled" name="payment_tution_fee" id="payment_tution_fee" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>GST (18%)</label>
                                        <input type="text" disabled="disabled" name="payment_gst" id="payment_gst" class="form-control">
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
                                                    <input id="pay-mode-1" checked="checked" value="1" name="payment_mode_id" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Cash</span>
                                                </label>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="custom-control custom-radio">
                                                    <input id="pay-mode-2" value="2" name="payment_mode_id" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Check</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="custom-control custom-radio">
                                                    <input id="pay-mode-3" name="payment_mode_id" value="3" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">DD</span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="check-frm" style="display: none;">
                                        <div class="form-group">
                                            <label>IFSC</label>
                                            <div class="input-group">
                                                <input type="text" name="payment_bank_ifsc" id="payment_bank_ifsc" class="form-control">
                                                <div class="input-group-addon search-batch-code-informations" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <input type="text" name="payment_bank_name" id="payment_bank_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Check No</label>
                                            <input type="text" name="payment_bank_ref_number" id="payment_bank_ref_number" class="form-control">
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
                        <input type="hidden" name="invoice_id" id="invoice-id">
                    </form>
                </div>
            </div> 
        </div>
        <!-- edit -->
        <div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" id="edit-batch-frm">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="card-header text-uppercase"><b>Edit Batch</b></div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Registration no.</label>
                                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->lname; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Batch Start Date</label>
                                        <input type="text" id="edit-batch_start_date" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->batch_start_date; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->fname; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Batch code</label>
                                        <div class="input-group">
                                            <input type="text" id="edit-batch_code" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->batch_code; ?>">
                                            <div class="input-group-addon search-batch-code-informations" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Course name</label>
                                        <input type="text" id="edit-copurse_name" class="form-control" disabled="disabled" value="<?php echo $student->payload->student->course_name; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="student_id" value="<?php echo $student->payload->student->id; ?>">
                    <input type="hidden" name="batch_id" id="edit-batch_id" value="<?php echo $student->payload->student->batch_id; ?>">
                </form>
            </div>
        </div>
        <!-- edit informations -->
        <div class="modal fade" id="edit-informations-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" id="edit-frm">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="card-header text-uppercase"><b>Edit Information</b></div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input type="text" name="fname" id="edit-fname" required="required" value="<?php echo $student->payload->student->fname; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Father's occupation</label>
                                        <input type="text" name="fathers_occupation" id="edit-fathers_occupation" required="required" value="<?php echo $student->payload->student->fathers_occupation; ?>"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Student email</label>
                                        <input type="email" name="email" id="edit-email" required="required" value="<?php echo $student->payload->student->email; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Law School</label>
                                        <input type="text" name="law_school" id="law_school" required="required" value="<?php echo $student->payload->student->law_school; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Year Of Passing</label>
                                        <input type="text" name="yop" id="yop" required="required" value="<?php echo $student->payload->student->yop; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Referred By</label>
                                        <input type="text" name="referred_by" id="referred_by" required="required" value="<?php echo $student->payload->student->referred_by; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Temporary address</label>
                                        <textarea class="form-control" name="local_address" id="edit-local_address" rows="3"> <?php echo $student->payload->student->local_address; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" name="lname" id="edit-lname" required="required" value="<?php echo $student->payload->student->lname; ?>" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Father's name</label>
                                        <input type="text" name="fathers_name" id="edit-fathers_name" required="required" value="<?php echo $student->payload->student->fathers_name; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" name="phone" id="edit-phone" required="required" value="<?php echo $student->payload->student->phone; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Student mobile</label>
                                        <input type="number" name="mobile" id="edit-mobile" required="required" value="<?php echo $student->payload->student->mobile; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Permanent address</label>
                                        <textarea class="form-control" name="permanant_address" id="edit-permanant_address" required="required" rows="3"><?php echo $student->payload->student->permanant_address; ?></textarea>
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
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="edit-student_id" value="<?php echo $student->payload->student->id; ?>">
                </form>
            </div>
        </div>
        <div class="modal fade" id="batch-code-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Select batches</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <table class="table table-striped table-bordered dataTable" id="table-1">
                            <thead>
                                <tr>
                                    <th>Batch Id</th>
                                    <th>Course</th>
                                    <th>Batch Code</th>
                                    <th>Batch start date</th>
                                    <th>Fee</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($batches->payload->batches)) {
                                    foreach ($batches->payload->batches as $val) {
                                        ?>
                                        <tr id="r<?php echo $val->id; ?>">
                                            <td><?php echo $val->id; ?></td>
                                            <td><?php echo $val->course; ?></td>
                                            <td><?php echo $val->batch_code; ?></td>
                                            <td><?php echo $val->batch_start_date; ?></td>
                                            <td><?php echo $val->course_fee; ?></td>
                                            <td><button type="button" class="btn btn-info btn-sm select select-batch">Select</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.select-batch').on('click', function () {
                    $('#batch-code-modal').modal('hide');
                    var $row = $(this).closest("tr"),
                            $tds = $row.find("td");
                    var array = [];
                    $.each($tds, function () {
                        array.push($(this).text());
                    });
                    $('#edit-batch_id').val(array[0]);
                    $('#edit-course_name').val(array[1]);
                    $('#edit-batch_code').val(array[2]);
                    $('#edit-batch_start_date').val(array[3]);
                    $('#edit-course_name').val(array[1]);
                });
                $('#payment_amount').on('keyup', function () {
                    var amount = parseInt($('#payment_amount').val())
                    var gst = (amount * 18) / 100;
                    var tution_fee = amount - gst;
                    $('#payment_tution_fee').val(tution_fee);
                    $('#payment_gst').val(gst);
                });
                $('.edit-profile').on('click', function () {
                    $('#edit-profile-modal').modal('show');
                });
                $('.edit-informations').on('click', function () {
                    $('#edit-informations-modal').modal('show');
                });
                $('.search-batch-code-informations').on('click', function () {
                    $('#batch-code-modal').modal('show');
                });
                $('#pay-fee').on('click', function () {
                    $('#pay-fee-modal').modal('show');
                });
                $('#pay-mode-1').on('click', function () {
                    $('#check-frm').hide();
                });
                $('#pay-mode-2').on('click', function () {
                    $('#check-frm').show();
                });
                $('#pay-mode-3').on('click', function () {
                    $('#check-frm').show();
                });
                $('#edit-pay-mode-1').on('click', function () {
                    $('#edit-check-frm').hide();
                });
                $('#edit-pay-mode-2').on('click', function () {
                    $('#edit-check-frm').show();
                });
                $('#edit-pay-mode-3').on('click', function () {
                    $('#edit-check-frm').show();
                });
                $(function () {
                    $("#edit-batch-frm").on("submit", function (event) {
                        event.preventDefault();
                        $('.loader').html('loading...');
                        $.ajax({
                            url: site_url + 'students/editBatch',
                            type: "post",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
                                if (obj.status.error === true) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                // Chagne Batch
                                $('#batch_code_p').html($('#edit-batch_code').val());
                                $('#batch_start_date_p').html($('#edit-batch_start_date').val());
                                $('#batch_course_name_p').html($('#edit-course_name').val());
                                $('.loader').html('Data Saved');
                                $('#edit-profile-modal').modal('hide');
                            }
                        });
                    });
                    $("#edit-frm").on("submit", function (event) {
                        event.preventDefault();
                        $('.loader').html('loading...');
                        $.ajax({
                            url: site_url + 'students/editProfile',
                            type: "post",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
                                if (obj.status.error === true) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                $('.loader').html('Data Saved');
                                $('#edit-informations-modal').modal('hide');
                                // view Info
                                $('.first-name-val').html(obj.payload.student.fname);
                                $('.last-name-val').html(obj.payload.student.lname);
                                $('.Law-school-val').html(obj.payload.student.law_school);
                                $('.yop-val').html(obj.payload.student.yop);
                                $('.referred-by-val').html(obj.payload.student.referred_by);
                                $('.course-name-val').html(obj.payload.student.course_name);
                                $('.father-name-val').html(obj.payload.student.fathers_name);
                                $('.occupation-val').html(obj.payload.student.fathers_occupation);
                                $('.father-phone-val').html(obj.payload.student.phone);
                                $('.student-email-val').html(obj.payload.student.email);
                                $('.student-mobile-val').html(obj.payload.student.mobile);
                                $('.temporary-add-val').html(obj.payload.student.local_address);
                                $('.permanent-add-val').html(obj.payload.student.permanant_address);
                            }
                        });
                    });
                    $(".add-fee-frm").on("submit", function (event) {
                        alert('asdf');
                        event.preventDefault();
                        $('.loader').html('loading...');
                        $.ajax({
                            url: site_url + 'invoices/payFee',
                            type: "post",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
                                if (obj.status.error === true) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                $('.loader').html('Data Saved');
                                $('#pay-fee-modal').modal('hide');
                                table.row.add([
                                    '<a href="' + site_url + 'invoices/detail/' + obj.payload.invoice.id + '">' + obj.payload.invoice.id + '</a>',
                                    obj.payload.invoice.payment_amount,
                                    obj.payload.invoice.created_at,
                                    obj.payload.invoice.payment_mode_id,
                                    '<button type="button" onClick="editRec(' + obj.payload.invoice.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>'
                                ]).node().id = 'r' + obj.payload.invoice.id;
                                table.draw(false);
                                window.location.replace('<?php echo site_url("invoices/detail/"); ?>' + obj.payload.invoice.id);
                            }
                        });
                    });
                    $(".edit-fee-frm").on("submit", function (event) {
                        event.preventDefault();
                        $('.loader').html('Updating...');
                        $.ajax({
                            url: site_url + 'invoices/editPayFee',
                            type: "post",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                alert(data);
                                var obj = jQuery.parseJSON(data);
                                if (obj.status.error === true) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                $('.loader').html('Data updated');
                                table.row($('#r' + obj.payload.course.id)).remove();
                                table.row.add([
                                    '<a href="' + site_url + 'invoices/detail/' + obj.payload.invoice.id + '">' + obj.payload.invoice.id + '</a>',
                                    obj.payload.invoice.payment_amount,
                                    obj.payload.invoice.created_at,
                                    obj.payload.invoice.payment_mode_id,
                                    '<button type="button" onClick="editRec(' + obj.payload.invoice.id + ');" class="btn btn-primary btn-sm edit-btn">Edit</button>'
                                ]).node().id = 'r' + obj.payload.invoice.id;
                                table.draw(false);
                                $('.loader').html('');
                                $('#pay-fee-modal').modal('hide');
                            }
                        });
                    });

                });
            });
            function editRec(invoice_id) {
                $('#pay-fee-modal').modal('show');
                $('#frm').removeClass("add-fee-frm").addClass("edit-fee-frm");
                $('.loader').html('Data loading...');
                $.ajax({
                    type: "POST",
                    url: site_url + 'invoices/filter',
                    data: {invoice_no: invoice_id},
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.status.error) {
                            $('.loader').html(obj.status.message);
                            return false;
                        }
                        $('#invoice-id').val(obj.payload.invoice.id);
                        $('#payment_type').val(obj.payload.invoice.payment_type);
                        $('#payment_amount').val(obj.payload.invoice.payment_amount);
                        var amount = parseInt($('#payment_amount').val())
                        var gst = (amount * 18) / 100;
                        var tution_fee = amount - gst;
                        $('#payment_tution_fee').val(tution_fee);
                        $('#payment_gst').val(gst);
                        $("#pay-mode-" + obj.payload.invoice.payment_mode_id).attr('checked', 'checked');
                        $('#edit-ifsc').val(obj.payload.invoice.payment_bank_ifsc);
                        $('#edit-bank-name').val(obj.payload.invoice.payment_bank_name, );
                        $('#edit-account-number').val(obj.payload.invoice.payment_bank_ref_number);
                        $('.loader').html('');
                    }
                });
            }

        </script>
    </body>
</html>