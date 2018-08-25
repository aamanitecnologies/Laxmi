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
                                    <b>States</b>
                                    <div class="float-md-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-course">Add new state</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-block bg-white">
                            <table class="table table-striped table-bordered dataTable" id="table-1">
                                <thead>
                                    <tr>
                                        <th>State code</th>
                                        <th>State</th>
                                        <th>Preferred Language</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($payload->states)) {
                                        foreach ($payload->states as $val) {
                                            ?>
                                            <tr id="r<?php echo $val->id; ?>">
                                                <td><?php echo $val->id; ?></td>
                                                <td><?php echo $val->state; ?></td>
                                                <td><?php echo $val->language; ?></td>
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
        <!-- Add new State -->
        <div class="modal fade" id="add-new-course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Add New State</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="addFrm" name="editFrm" method="post" action="<?php echo site_url('states/save'); ?>" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State code</label>
                                        <input required="required" name="state_code" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Preferred language</label>
                                        <select required="required" name="language" class="form-control" id="exampleFormControlSelect1">
                                            <option>English</option>
                                            <option>Hindi</option>
                                            <option>Both(English and hindi)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input required="required" name="state" type="text" class="form-control" name="">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <span class="pull-left loader"></span>
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->
                </div>
            </div>
        </div>
        <!-- Edit -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Edit State</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="editFrm" method="post" action="<?php echo site_url('states/update'); ?>" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State code</label>
                                        <input required="required" name="state_code" id="state_code" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Preferred language</label>
                                        <select required="required" name="language" id="language" class="form-control" id="exampleFormControlSelect1">
                                            <option>English</option>
                                            <option>Hindi</option>
                                            <option>Both(English and hindi)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <input required="required" name="state" id="state" type="text" class="form-control" name="">
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
                            <input type="hidden" id="id" name="id">
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
                    <div class="card-header text-uppercase"><b>Delete State</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <h5 class="text-xs-center">Are you sure want to delete this?</h5>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <span class="pull-left loader"></span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            No
                        </button>
                        <button id="delete" type="button" class="btn btn-primary">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/states.js"></script>
    </body>
</html>