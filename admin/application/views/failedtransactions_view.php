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
                            <div class="col-sm-12">
                                <div class="card-header text-uppercase">
                                    <b>Gateway Directory</b>
                                </div>
                                <div class="card-header" id="msg" style="display:none; text-align: center; color: green;"></div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Name</th>
                                                <th>Batch</th>
                                                <th>Transaction No.</th>
                                                <th>Transaction Status</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($pg->status->error == false) {
                                                foreach ($pg->payload->pgstudents as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo $val->id. '- '. $val->created_at ; ?></td>
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><?php echo dateFromat($val->batch_start_date); ?></td>
                                                        <td><?php echo $val->pg_tracking_id; ?></td>
                                                        <td><?php echo $val->pg_order_status; ?></td>
                                                        <td><?php echo $val->mobile; ?></td>
                                                        <td><?php echo $val->email; ?></td>
                                                        <td>
                                                            <button type="button" onClick="deleteRec('<?php echo $val->id; ?>');" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                                            <!--button type="button" class="btn btn-primary btn-sm edit-btn">Confirm</button-->
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
                            <!--
                            <div class="col-sm-3">
                                <div class="card-header text-uppercase">
                                    <b>Filter</b>
                                </div>
                                <div class="box box-block bg-white">
                                    <form method="post" id="student-filter-frm">
                                        <div class="form-group">
                                            <label>Batch codes</label>
                                            <select required="required" name="batch_code_id" id="batch_code_id" class="form-control">
                                                <option value="">Please Select Batch</option>
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
                                            <label>Courses</label>
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

                                        <div class="float-xs-right">
                                            <button type="button" class="btn btn-default btn-sm">Reset</button>&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                        </div>
                                        <br/>
                                    </form>
                                </div>
                            </div>
                            -->
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
                        <input type="hidden" id="delId">

                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            No
                        </button>
                        <button type="button" onclick="deletePg()" class="btn btn-primary">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/students.js"></script>
        <script type="text/javascript">
                            $(document).ready(function () {
                                table.column('1:visible').order('desc').draw(false);
                            });

                            function deleteRec(id) {
                                $('#delId').val(id);
                                $('#delete-modal').modal('show');
                            }

                            function deletePg() {
                                $('#msg').html('');
                                loaderProcess();
                                var id = $('#delId').val();
                                $.ajax({
                                    url: site_url + "failedtransactions/deletePgTransactionById/" + id,
                                    type: "post",
                                    success: function (data) {
                                        var obj = jQuery.parseJSON(data);
                                        if (obj.status.error) {
                                            loaderFail(obj.status.message);
                                            return false;
                                        } else {
                                            table.row($('#r' + id)).remove();
                                            table.draw(false);
                                            $('#delete-modal').modal('hide');
                                            $('#msg').show();
                                            $('#msg').html('Successfully Deleted');
                                        }

                                    }
                                });
                            }
        </script>
    </body>
</html>