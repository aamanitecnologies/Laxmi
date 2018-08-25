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
                                    <b>Admission Report</b>
                                    <span class="pull-right"><a id="download" href="<?php echo site_url('reports/downloadAdmissionReport'); ?>" class="btn btn-primary btn-sm" >Download All</a></span>
                                </div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Admission Date</th>
                                                <th>Registration No.</th>
                                                <th>Student Name</th>
                                                <th>Mobile</th>
                                                <th>Batch</th>
                                                <th>Payment Mode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($admissionReport->status->error == false) {
                                                foreach ($admissionReport->payload->admissionReport as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo dateFromat($val->created_at); ?></td>
                                                        <td><a href="<?php echo site_url('students/profile/' . $val->id); ?>"><?php echo getRegNo($val); ?></a></td>
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><?php echo $val->mobile; ?></td>
                                                        <td><?php echo $val->batch_code . '<br>' . dateFromat($val->batch_start_date); ?></td>
                                                        <td><?php echo getPaymentMode($val->payment_mode_id); ?></td>
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
                                    <form method="post" id="admission-report-frm">
                                        <div class="form-group">
                                            <label>Batchs</label>
                                            <select name="batch_id" id="batch_id" class="form-control">
                                                <option value="">Please Select All</option>
                                                <?php
                                                if ($batches->status->error == false) {
                                                    foreach ($batches->payload->batches as $val) {
                                                        echo "<option value='" . $val->id . "'>" . $val->batch_code . ' ' . $val->batch_start_date . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>    
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Admission From</label>
                                                <input type="text" required="required" id="datepicker-admission-from" name="admission_from"  class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Admission To</label>
                                                <input type="text" required="required" id="datepicker-admission-to" name="admission_to"  class="form-control">
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

                $('#datepicker-admission-from').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
                $('#datepicker-admission-to').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });

                $('#filter').on('click', function () {
                    $("#download").html('Download From ' + dateFormate($('#datepicker-admission-from').val()) + ' To '+dateFormate($('#datepicker-admission-to').val()));
                    $("#download").attr("href", "<?php echo site_url('reports/downloadAdmissionReport/'); ?>" + dateFormate($('#datepicker-admission-from').val())+'/'+dateFormate($('#datepicker-admission-to').val())+'/'+$('#batch_id').val());
                });
            });
        </script>
    </body>
</html>