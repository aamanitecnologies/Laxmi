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
                                    <b>Staff users</b>
                                    <div class="float-md-right">
                                        <button type="button" class="btn btn-primary" id="add-button">Add new user</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-block bg-white">
                            <table class="table table-striped table-bordered dataTable" id="table-1">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Email id</th>
                                        <th>Phone no.</th>
                                        <th>Status</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($payload->staff_users)) {
                                        foreach ($payload->staff_users as $val) {
                                            ?>
                                            <tr id="r<?php echo $val->id; ?>">
                                                <td><?php echo $val->id; ?></td>
                                                <td><?php echo $val->fname; ?></td>
                                                <td><?php echo $val->lname; ?></td>
                                                <td><?php echo $val->email; ?></td>
                                                <td><?php echo $val->phone; ?></td>
                                                <td><?php echo ($val->status) ? '<span class="text-success">Enable</span>' : '<span class="text-danger">Disable</span>'; ?></td>
                                                <td>
                                                    <button type="button" onclick="editRec('<?php echo $val->id; ?>');" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit">Edit</button>
                                                    <button type="button" onclick="deleteRec('<?php echo $val->id; ?>');" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">Delete</button>
                                                    <button type="button" onclick="resetPassword('<?php echo $val->id; ?>');" class="btn btn-success btn-sm" data-toggle="modal" data-target="#reset-password">Reset password</button>
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
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Add New Staff User</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form name="addFrm" id="addFrm" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input required="required" name="fname" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email/User name</label>
                                        <input required="required" name="email" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input required="required"  name="password" id="pass" type="password" class="form-control">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input required="required" name="lname" type="text" class="form-control" name="">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone no.</label>
                                        <input required="required" name="phone" type="number" class="form-control" name="">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm password</label>
                                        <input required="required" name="confirm_password" id="conpass" type="password" class="form-control">
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
        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Edit Staff User</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form name="editFrm" id="editFrm" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input required="required" name="fname" id="fname" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email/User name</label>
                                        <input required="required" name="email" id="email" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input required="required" name="lname" id="lname" type="text" class="form-control" name="">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone no.</label>
                                        <input required="required" name="phone" id="phone" type="number" class="form-control" name="">
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
        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Delete Staff User</b>
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
        <!-- Reset password -->
        <div class="modal fade" id="reset-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Reset Password</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form  id="frmPass" class="form-" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User id</label>
                                        <input id="user_id" name="user_id" type="text" class="form-control" disabled="disabled">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="repassword" name="password" required="required" type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User name</label>
                                        <input id="remail" name="email" type="text" class="form-control" disabled="disabled">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm password</label>
                                        <input id="reconfirm_password" name="confirm_password" required="required" type="password" class="form-control">
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
                            <input type="hidden" name="id" id="staff_user_id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/users.js"></script>
    </body>
</html>