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
                        <div class="card-header text-uppercase"><b>Add New Batch</b></div>
                        <div class="box box-block bg-white">
                            
                            <div class="row">
                                <form name="addFrm" id="addFrm" method="post" action="<?php echo site_url('batches/save'); ?>">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Batch code</label>
                                            <select required="required" name="batch_code_id" id="batch_code_id" class="form-control">
                                                <option value="">Please Select Batch Code</option>
                                                <?php
                                                if (!empty($batchcodes->payload->batch_codes)) {
                                                    foreach ($batchcodes->payload->batch_codes as $val) {
                                                        echo "<option value='" . $val->id . "'>" . $val->batch_code_display . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Course</label>
                                            <select required="required" name="course_id" id="course_id" class="form-control">
                                                <option value="">Please Select Course</option>
                                                <?php
                                                if (!empty($courses->payload->courses)) {
                                                    foreach ($courses->payload->courses as $val) {
                                                        echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Max online seats</label>
                                            <input type="number" name="max_online_seats" id="max_online_seats" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Min Admission Fee</label>
                                            <input type="number" name="min_admission_fee" id="min_admission_fee" required="required" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Batch start date</label>
                                            <div class="input-group">
                                                <input required="required" name="batch_start_date" type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Seat</label>
                                            <input required="required" name="total_seats" id="total_seats" type="number" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label>Enable online admission</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="custom-control custom-radio">
                                                        <input id="take_online_admissions1" checked="checked" value="1" name="take_online_admissions" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="take_online_admissions2" name="take_online_admissions" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label>Admission Open</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_open1" checked="checked" value="1" name="admissions_open" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_open2" name="admissions_open" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label>Show on Admissions Page</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_show1" value="1" name="admissions_show" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_show2" checked="checked" name="admissions_show" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="modal-footer">
                                        <div class="pull-left loader"></div>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </form>
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