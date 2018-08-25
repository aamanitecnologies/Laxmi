<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view.php'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="content-area py-1">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-header text-uppercase">
                                    <b>Batch codes</b>
                                    <div class="float-md-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-course">Add new batch code</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-block bg-white">
                            <table class="table table-striped table-bordered dataTable" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Batch Id</th>
                                        <th>Batch Code</th>
                                        <th>Batch Code Display</th>
                                        <th>Batch Timing</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($payload->batch_codes)) {
                                        foreach ($payload->batch_codes as $val) {
                                            ?>
                                            <tr id="r<?php echo $val->id; ?>">
                                                <td><?php echo $val->id; ?></td>
                                                <td><?php echo $val->batch_code; ?></td>
                                                <td><?php echo $val->batch_code_display; ?></td>
                                                <td><?php echo $val->batch_code_timing; ?></td>
                                                <td>
                                                    <button type="button" onClick="editRow('<?php echo $val->id; ?>');" class="btn btn-primary btn-sm edit-btn">Edit</button>
                                                    <button type="button" onClick="deleteRow('<?php echo $val->id; ?>');" class="btn btn-danger btn-sm delete-btn">Delete</button>
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
                <?php $this->load->view('includes/footer_view'); ?>
            </div>
        </div>
        <!-- Add new course -->
        <div class="modal fade" id="add-new-course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Add New Batch Code</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="addFrm" name="addFrm" method="post" action="<?php echo site_url('batchcodes/save'); ?>" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code</label>
                                        <input name="batch_code" required="required" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code display</label>
                                        <input required="required" name="batch_code_display" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code display</label>
                                        <input required="required" name="batch_code_timing" type="text" class="form-control">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Edit Batch Code</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="editFrm" name="editFrm" method="post" action="<?php echo site_url('batchcodes/update'); ?>" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code</label>
                                        <input name="batch_code" id="batch_code" required="required" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code display</label>
                                        <input name="batch_code_display" id="batch_code_display" required="required" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Batch code display</label>
                                        <input name="batch_code_timing" id="batch_code_timing" required="required" type="text" class="form-control">
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
                            <input type="hidden" name="id" id="id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Delete Batch Code</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <h5 class="text-xs-center">Are you sure want to delete this?</h5>
                        <input type="hidden" id="delId">
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <span class="pull-left loader"></span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            No
                        </button>
                        <button onclick="deleteCon()" type="button" class="btn btn-primary">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/page/batchcodes.js"></script>
    </body>
</html>