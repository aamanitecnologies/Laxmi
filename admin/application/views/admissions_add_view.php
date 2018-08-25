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
                        <form method="post" id="addFrm">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card-header text-uppercase"><b>Student informations</b></div>
                                    <div class="box-block bg-white">
                                        <div class="form-group">
                                            <label>Student Name</label>
                                            <input type="text" required="required" id="fname" name="fname" value="<?php echo(isset($this->session->userdata('admission')['fname'])) ? $this->session->userdata('admission')['fname'] : ''; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Batch Code</label>
                                            <div class="input-group">
                                                <input type="text" required="required" id="batch_code_d" value="<?php echo(isset($this->session->userdata('admission')['batch_code'])) ? $this->session->userdata('admission')['batch_code'] : ''; ?>" class="form-control" disabled="disabled">
                                                <input type="hidden" id="batch_code" name="batch_code" value="<?php echo(isset($this->session->userdata('admission')['batch_code'])) ? $this->session->userdata('admission')['batch_code'] : ''; ?>" class="form-control">
                                                <div class="input-group-addon search-batch-code" style="cursor: pointer; background:#ddd;"><i class="ti-search"></i></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Batch Start Date</label>
                                            <input type="text" required="required"  id="batch_start_date_d" class="form-control" name="" value="<?php echo(isset($this->session->userdata('admission')['batch_start_date'])) ? $this->session->userdata('admission')['batch_start_date'] : ''; ?>" disabled="disabled">
                                            <input type="hidden" id="batch_start_date" name="batch_start_date" value="<?php echo(isset($this->session->userdata('admission')['batch_start_date'])) ? $this->session->userdata('admission')['batch_start_date'] : ''; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Course Name</label>
                                            <input type="text" required="required"  id="course_name_d" value="<?php echo(isset($this->session->userdata('admission')['course_name'])) ? $this->session->userdata('admission')['course_name'] : ''; ?>" class="form-control" disabled="disabled">
                                            <input type="hidden" id="course_name" name="course_name" value="<?php echo(isset($this->session->userdata('admission')['course_name'])) ? $this->session->userdata('admission')['course_name'] : ''; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Fee Payable</label>
                                            <input type="text" required="required"  id="course_fee" name="course_fee" value="<?php echo(isset($this->session->userdata('admission')['course_fee'])) ? $this->session->userdata('admission')['course_fee'] : ''; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Discount</label>
                                            <input type="text"  id="discount" name="discount" value="<?php echo(isset($this->session->userdata('admission')['discount'])) ? $this->session->userdata('admission')['discount'] : ''; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <div class="input-group">
                                                <input type="text" required="required"  class="form-control" name="dob" id="datepicker-autoclose" value="<?php echo(isset($this->session->userdata('admission')['dob'])) ? $this->session->userdata('admission')['dob'] : ''; ?>" placeholder="mm/dd/yyyy">
                                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Law Faculty from where did/doing LLB</label>
                                            <input type="text" class="form-control" name="law_school" id="law_school" value="<?php echo(isset($this->session->userdata('admission')['law_school'])) ? $this->session->userdata('admission')['law_school'] : ''; ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label>Leave Entitlement</label>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="custom-control custom-radio">
                                                        <input id="leave-entitlement-1" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 1) ? 'checked="checked"' : ''; ?> name="leave-entitlement" value="1" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="leave-entitlement-2" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 0) ? 'checked="checked"' : ''; ?> name="leave-entitlement" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                    <div class="custom-control custom-radio" id="leaverange" <?php echo($this->session->userdata('admission')['leave-entitlement'] == 0) ? 'style="display:none;"' : ''; ?>>
                                                        <input type="text" style="width:100px;" name="leave_from" value="<?php echo(isset($this->session->userdata('admission')['leave_from'])) ? $this->session->userdata('admission')['leave_from'] : ''; ?>"  placeholder="Leave From"> To
                                                        <input type="text" style="width:100px;" name="leave_to" value="<?php echo(isset($this->session->userdata('admission')['leave_to'])) ? $this->session->userdata('admission')['leave_to'] : ''; ?>" placeholder="Leave To">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label>Year of Passing</label>
                                            <input type="text"  class="form-control" name="yop" id="yop" value="<?php echo(isset($this->session->userdata('admission')['yop'])) ? $this->session->userdata('admission')['yop'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Referred By</label>
                                            <input type="text"  class="form-control" id="referred_by" value="<?php echo(isset($this->session->userdata('admission')['referred_by'])) ? $this->session->userdata('admission')['referred_by'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-header text-uppercase"><b>Contact Informations</b></div>
                                    <div class="box box-block bg-white">
                                        <div class="form-group">
                                            <label>Father's Name</label>
                                            <input type="text" required="required"  class="form-control" name="fathers_name" id="fathers_name" value="<?php echo(isset($this->session->userdata('admission')['fathers_name'])) ? $this->session->userdata('admission')['fathers_name'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Father's Occupation</label>
                                            <input type="text" required="required"  class="form-control" name="fathers_occupation" id="fathers_occupation" value="<?php echo(isset($this->session->userdata('admission')['fathers_occupation'])) ? $this->session->userdata('admission')['fathers_occupation'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" maxlength="10" minlength="10" required="required"  class="form-control" name="phone" id="phone" value="<?php echo(isset($this->session->userdata('admission')['phone'])) ? $this->session->userdata('admission')['phone'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Student Email</label>
                                            <input type="email" required="required"  class="form-control" name="email" id="email" value="<?php echo(isset($this->session->userdata('admission')['email'])) ? $this->session->userdata('admission')['email'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Student Mobile</label>
                                            <input type="text" maxlength="10" minlength="10" required="required"  class="form-control" name="mobile" id="mobile" value="<?php echo(isset($this->session->userdata('admission')['mobile'])) ? $this->session->userdata('admission')['mobile'] : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Temporary Address</label>
                                            <textarea class="form-control" required="required"  name="local_address" id="local_address" rows="5"><?php echo(isset($this->session->userdata('admission')['local_address'])) ? $this->session->userdata('admission')['local_address'] : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Permanent Address</label>
                                            <textarea required="required"  class="form-control" name="permanant_address" id="permanant_address" rows="5"><?php echo(isset($this->session->userdata('admission')['permanant_address'])) ? $this->session->userdata('admission')['permanant_address'] : ''; ?></textarea>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-header text-uppercase"><b>Declarations</b></div>
                                    <div class="box box-block bg-white">
                                        <div class="form-group">
                                            <p>I <span id="student-name-d" style="font-weight: bold;"></span> S/o D/o W/o <span id="fathers-name-d" style="font-weight: bold;"></span>, hereby declare that the brochure of terms & conditions have been carefully read by me & I have read and understood fully, all the 'terms and conditions' of the institute. I am joining the institute with my free will and have no objection to any of the 'terms and conditions'. I do agree that I will abide by all the 'terms and conditions' of the Institute. Any disputes shall be subject to the jurisdiction of the Delhi Courts only. </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" id="cancel-admission" class="btn btn-default">Cancel Admission</button>
                                            <button type="sumbit" class="btn btn-success">Upload Documents</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php $this->load->view('includes/footer_view'); ?>
            </div>
        </div>
        <!-- Select Bathes Model -->
        <div class="modal fade" id="search-batch-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <td><?php echo dateFromat($val->batch_start_date); ?></td>
                                            <td><?php echo $val->course_fee; ?></td>
                                            <td><button type="button" onclick="selBatch('<?php echo $val->id;?>','<?php echo $val->batch_code;?>', '<?php echo $val->batch_start_date;?>', '<?php echo $val->course;?>', '<?php echo $val->course_fee;?>');">Select</button></td>
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
        <!-- Cancel Admission -->
        <div class="modal fade" id="cancel-admission-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Cancel Admission</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <h5 class="text-xs-center">Are you sure you want to cancel this admission?</h5>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <span class="pull-left loader"></span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            No
                        </button>
                        <button id="reset-session" type="button" class="btn btn-primary">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>

        <script type="text/javascript">
            //table.column('0:visible').order('desc').draw(false);
            var fname = $('#fname').val();
            var fathers_name = $('#fathers_name').val();
            $('#student-name-d').html(fname);
            $('#fathers-name-d').html(fathers_name);
            $(document).ready(function () {
                $('#cancel-admission').on('click', function () {
                    $('#cancel-admission-modal').modal('show');
                });
                $('#fname').on('keyup', function () {
                    fname = $('#fname').val();
                    $('#student-name-d').html(fname);
                });
                $('#fathers_name').on('keyup', function () {
                    fathers_name = $('#fathers_name').val();
                    $('#fathers-name-d').html(fathers_name);
                });
                $('#leave-entitlement-1').on('click', function () {
                    $('#leaverange').show();
                });
                $('#leave-entitlement-2').on('click', function () {
                    $('#datepicker-leave-from').val('');
                    $('#datepicker-leave-to').val('');
                    $('#leaverange').hide();
                });
                $("#reset-session").on("click", function () {
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'admissions/resetAdmission',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            loaderSuccess();
                            window.location.replace("<?php echo site_url('admissions/add'); ?>");
                        }
                    });
                });
                $('#datepicker-autoclose').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
                $('#datepicker-leave-from').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
                $('#datepicker-leave-to').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });

                $('.search-batch-code').on('click', function () {
                    $('#search-batch-modal').modal('show');
                });

                $(function () {
                    $("#addFrm").on("submit", function (event) {
                        event.preventDefault();
                        var discount = parseInt($('#discount').val());
                        var feePending = parseInt($('#course_fee').html());
                        if (discount > feePending) {
                            loaderFail('Discount should not be greater than Fee');
                            return false;
                        }
                        loaderProcess();
                        $.ajax({
                            url: site_url + 'admissions/save',
                            type: "post",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                loaderSuccess();
                                window.location.replace(site_url + "admissions/documents");
                            }
                        });
                    });
                });
            });

            function selBatch(batch_id, batch_code, batch_start_date, course_name, course_fee){
                //alert(batch_id+'-'+batch_code+'-'+batch_start_date+'-'+course_name+'-'+course_fee);
                $('#batch_code_d').val(batch_code);
                $('#batch_start_date_d').val(dateFormate(batch_start_date));
                $('#course_name_d').val(course_name);
                $('#batch_code').val(batch_id);
                $('#batch_start_date').val(dateFormate(batch_start_date));
                $('#course_name').val(course_name);
                $('#course_fee').val(course_fee);
                $('#search-batch-modal').modal('hide');
            }

            $('.select-batch').on('click', function () {
                var $row = $(this).closest("tr"),
                        $tds = $row.find("td");
                var array = [];
                $.each($tds, function () {
                    array.push($(this).text());
                });
                $('#batch_code_d').val(array[2] + ' - ' + array[0]);
                $('#batch_start_date_d').val(array[3]);
                $('#course_name_d').val(array[1]);
                $('#batch_code').val(array[0]);
                $('#batch_start_date').val(array[3]);
                $('#course_name').val(array[1]);
                $('#course_fee').val(array[4]);
                $('#search-batch-modal').modal('hide');
            });
        </script>
    </body>
</html>