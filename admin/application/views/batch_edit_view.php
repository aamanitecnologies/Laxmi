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
                            <div class="col-sm-4 col-md-3">
                                <div class="card-header text-uppercase"><b>Batch Details</b></div>
                                <div class="card profile-card">
                                    <div class="card-block">
                                        <h4 class="mb-0-25"><?php echo $batch->payload->batch->batch_code; ?> <div class="text-muted" style="font-size: 12px; padding-top: 5px;"><?php echo dateFromat($batch->payload->batch->batch_start_date); ?></div><span title="edit" class="edit-profile" style="cursor: pointer; float: right; font-size: 14px; color:#aaa; padding:4px 0 0 0;"><i class="ti-pencil"></i></span></h4>
                                        <div class="text-muted mb-1"><?php echo $batch->payload->batch->course; ?></div>
                                        <label id="admission" class="btn <?php echo($batch->payload->batch->admissions_open) ? 'btn-success' : 'btn-danger'; ?> btn-sm label-left b-a-0 waves-effect waves-light mb-0-5" style="cursor: default;">
                                            <span class="btn-label"><i id="admission_i" class="ti-<?php echo($batch->payload->batch->admissions_open) ? 'check' : 'close'; ?>"></i></span>
                                            <span id="admission_text">Admission open</span>
                                        </label>
                                        <label id="online_admission" class="btn <?php echo($batch->payload->batch->take_online_admissions) ? 'btn-success' : 'btn-danger'; ?> btn-sm label-left b-a-0 waves-effect waves-light" style="cursor: default;">
                                            <span class="btn-label"><i id="online_admission_i" class="ti-<?php echo($batch->payload->batch->take_online_admissions) ? 'check' : 'close'; ?>"></i></span>
                                            <span id="online_admission_text">Online Admission open</span>
                                        </label>
                                    </div> 
                                    <div class="card-block" style="border-top: 1px solid #eee;">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <p><strong>Total seats:</strong></p>
                                                <p><strong>Max. online admissions:</strong></p>
                                                <p><strong>Total Students:</strong></p>
                                                <p><strong>Total Refunds:</strong></p>
                                            </div>
                                            <div class="col-sm-3">
                                                <p><?php echo $batch->payload->batch->total_seats; ?></p>
                                                <p><?php echo $batch->payload->batch->max_online_seats; ?></p>
                                                <p><?php echo $batch->payload->batch->total_students; ?></p>
                                                <p><?php echo $batch->payload->batch->total_refunds; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-uppercase"><b>Action</b></div>
                                    <div class="card-block">
                                        <div style="margin-bottom: 8px;">
                                            <a href="<?php echo site_url('admissions/add'); ?>">New Admission</a>
                                        </div>
                                        <div id="send-sms" style="margin-bottom: 8px;">
                                            <a href="#">Send SMS</a>
                                        </div>
                                        <div id="send-email" style="margin-bottom: 8px;">
                                            <a href="#">Send Email</a>
                                        </div>
                                        <div style="margin-bottom: 8px;">
                                            <a href="#" class="enable-admission">Enable/disable admission</a>
                                            <span id="admission_status"><?php echo $batch->payload->batch->admissions_open; ?></span>
                                        </div>
                                        <div style="margin-bottom: 8px;">
                                            <a href="#" class="enable-online-admission">Enable/disable online admission</a>
                                            <span id="online_admission_status" display="none"><?php echo $batch->payload->batch->take_online_admissions; ?></span>
                                        </div>
                                        <div id="print-card" style="margin-bottom: 8px;">
                                            <a href="<?php echo site_url('PrintIdCards/index/'.$batch->payload->batch->id);?>">Print Card</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Student List -->
                            <div class="col-sm-8 col-md-9">
                                <div class="card-header text-uppercase"><b>Student List</b></div>
                                <div class="card card-block">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Registration No.</th>
                                                <th>Batch</th>
                                                <th>Batch Start Date</th>
                                                <th>Mobile No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!$students->status->error) {
                                                foreach ($students->payload->students as $val) {
                                                    $emails[] = $val->email;
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><a href="<?php echo site_url('students/profile/' . $val->id); ?>"><?php echo getRegNo($val); ?></a></td>
                                                        <td><?php echo $val->batch_code; ?></td>
                                                        <td><?php echo dateFromat($val->batch_start_date); ?></td>
                                                        <td><?php echo $val->mobile; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">
                                <div class="card-header text-uppercase"><b>Refund Seats</b></div>
                                <div class="card card-block">
                                    <table class="table table-striped table-bordered dataTable" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Registration No.</th>
                                                <th>Batch</th>
                                                <th>Batch Start Date</th>
                                                <th>Phone No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!$refunded->status->error) {
                                                foreach ($refunded->payload->refunded as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><a href="<?php echo site_url('students/profile/' . $val->id); ?>"><?php echo getRegNo($val); ?></a></td>
                                                        <td><?php echo $val->batch_code; ?></td>
                                                        <td><?php echo dateFromat($val->batch_start_date); ?></td>
                                                        <td><?php echo $val->phone; ?></td>
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
                <?php $this->load->view('includes/footer_view'); ?>
                <!-- Admission Alert -->
                <div class="modal fade" id="admission-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    <?php echo $batch->payload->batch->batch_code; ?>
                                </h4>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <h5 class="text-xs-center" id="conf">Are you sure want to open admissions</h5>
                                <input type="hidden" id="delId">
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <div class="pull-left loader"></div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    No
                                </button>
                                <button  onclick="changeAdminssionStatus('<?php echo $batch->payload->batch->id; ?>')" type="button" class="btn btn-primary">
                                    Yes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Online Admission Alert -->
                <div class="modal fade" id="online-admission-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    <?php echo $batch->payload->batch->batch_code; ?>
                                </h4>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <h5 class="text-xs-center" id="online_conf">Are you sure want to open admissions</h5>
                                <input type="hidden" id="delId">
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <div class="pull-left loader"></div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    No
                                </button>
                                <button  onclick="changeOnlineAdminssionStatus('<?php echo $batch->payload->batch->id; ?>')" type="button" class="btn btn-primary">
                                    Yes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- edit -->
                <div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    Edit
                                </h4>
                            </div>
                            <!-- Modal Body -->
                            <form id="editFrm" name="editFrm" method="post" action="<?php echo site_url('batches/update/' . $batch->payload->batch->id); ?>">
                                <div class="modal-body">                        
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Batch code</label>
                                                <select required="required" name="batch_code_id" id="batch_code_id" class="form-control">
                                                    <option value="">Please Select Batch Code</option>
                                                    <?php
                                                    if (!empty($batchcodes->payload->batch_codes)) {
                                                        foreach ($batchcodes->payload->batch_codes as $val) {
                                                            if ($batch->payload->batch->batch_code_id == $val->id) {
                                                                echo "<option selected  value='" . $val->id . "'>" . $val->batch_code_display . "</option>";
                                                            } else {
                                                                echo "<option  value='" . $val->id . "'>" . $val->batch_code_display . "</option>";
                                                            }
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
                                                            if ($batch->payload->batch->course_id == $val->id) {
                                                                echo "<option selected value='" . $val->id . "'>" . $val->name . "</option>";
                                                            } else {
                                                                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Max online seats</label>
                                                <input type="number" value="<?php echo $batch->payload->batch->max_online_seats; ?>" name="max_online_seats" id="max_online_seats" required="required" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Batch start date</label>
                                                <div class="input-group">
                                                    <input required="required" value="<?php echo date('m/d/Y', strtotime($batch->payload->batch->batch_start_date)); ?>" name="batch_start_date" type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Total Seat</label>
                                                <input required="required" value="<?php echo $batch->payload->batch->total_seats; ?>" name="total_seats" id="total_seats" type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Min Admission Fee</label>
                                                <input required="required" value="<?php echo $batch->payload->batch->min_admission_fee; ?>" name="min_admission_fee" id="total_seats" type="number" class="form-control">
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
                                <input type="hidden" id="id" name="id" value="<?php echo $batch->payload->batch->id; ?>">
                            </form>

                        </div>
                    </div>
                </div>

                <!-- SMS Modal -->
                <div class="modal fade" id="sms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    Send Bulk SMS to all <b><?php echo $batch->payload->batch->batch_code; ?></b> Batch Students
                                </h4>
                            </div>
                            <!-- Modal Body -->

                            <div class="modal-body">                        
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form id="send-sms-frm" method="post">
                                            <div class="form-group">
                                                <label>Enter Text SMS</label>
                                                <textarea id="text-sms" name="text_sms" placeholder="Enter SMS"  required="required" class="form-control"></textarea>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer">
                                                <span class="pull-left loader"></span>
                                                <span id="msg" class="pull-left" style="dispaly:none;"></span>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Send SMS
                                                </button>
                                            </div>
                                            <input type="hidden" name="contacts" value="<?php echo $contacts; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Modal -->
                <div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">
                                    <b><?php echo $batch->payload->batch->batch_code . ' ' . dateFromat($batch->payload->batch->batch_start_date); ?></b>
                                </h4>
                            </div>
                            <!-- Modal Body -->

                            <div class="modal-body">                        
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form id="send-email-frm" method="post">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input type="email" disabled="disabled" class="form-control" name="from_email" id="from_email" placeholder="From" required="required" value="rahulsiaslaw@gmail.com">
                                            </div>
                                            <div class="form-group">
                                                <label>To</label>
                                                <input type="text" data-role="tagsinput" class="form-control" name="to_email" id="to_email" placeholder="To" required="required" value="rahulsiaslaw@gmail.com">
                                            </div>
                                            <div class="form-group">
                                                <label>BCC</label>
                                                <textarea id="bcc" name="bcc" placeholder="BCC"  required="required" class="form-control"><?php echo implode(', ',$emails); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>Enter Message</label>
                                                <textarea id="message" name="message" rows="4" placeholder="Enter Message"  required="required" class="form-control"></textarea>
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer">
                                                <span class="pull-left loader"></span>
                                                <span id="email-msg" class="pull-left" style="dispaly:none;"></span>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <button type="submit" id="send-email" class="btn btn-primary">
                                                    Send
                                                </button>
                                            </div>
                                            <input type="hidden" name="contacts" value="<?php echo $contacts; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php $this->load->view('includes/footer_incs'); ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/batches.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/typehead.js"></script>
    <script>
                                    var citynames = new Bloodhound({
                                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                                        prefetch: {
                                            url: 'assets/citynames.json',
                                            filter: function (list) {
                                                return $.map(list, function (cityname) {
                                                    return {name: cityname};
                                                });
                                            }
                                        }
                                    });
                                    citynames.initialize();

                                    $('input').tagsinput({
                                        typeaheadjs: {
                                            name: 'citynames',
                                            displayKey: 'name',
                                            valueKey: 'name',
                                            source: citynames.ttAdapter()
                                        }
                                    });
    </script>
</body>
</html>