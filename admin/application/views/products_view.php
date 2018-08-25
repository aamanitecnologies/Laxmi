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
                                <div class="card-header text-uppercase"><b>Machine</b>
                                <div class="float-md-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-product">Add new Machine</button>
                                </div>
                            </div>
                            </div>
                            
                        </div>
                        <div class="box box-block bg-white">
                            <table class="table table-striped table-bordered dataTable" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Machine ID</th>
                                        <th>Machine Name</th>
                                        <th>Model No</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($payload->machine)) {
                                        foreach ($payload->machine as $val) {
                                            ?>
                                            <tr id="r<?php echo $val->id; ?>">
                                                <td><?php echo $val->id; ?></td>
                                                <td><?php echo $val->product_name; ?></td>
                                                <td><?php echo $val->model_no; ?></td>
                                                <td>
                                                    <button type="button" onClick="editRec('<?php echo $val->id; ?>');" class="btn btn-primary btn-sm edit-btn">Edit</button>
                                                    <button type="button" onClick="deleteRec('<?php echo $val->id; ?>');" class="btn btn-danger btn-sm delete-btn">Delete</button>
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
        <div class="modal fade" id="add-new-product" tabindex="-1" role="dialog" 
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?php echo site_url('courses/save'); ?>" name="addFrm" id="addFrm" enctype="multipart/form-data">
                        <!-- Modal Header -->
                        <div class="card-header text-uppercase"><b>Add New Machine</b>
                            <button type="button" class="close" 
                                    data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button></div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input required="required" type="text" class="form-control" name="product_name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Model Number</label>
                                        <input required="required" type="text" class="form-control" name="model_no">
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
                            <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Edit Machine</b>
                        <button type="button" class="close" 
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button></div>
                    <!-- Modal Body -->
                    <form id="editFrm" method="post" action="<?php echo site_url('product/update'); ?>" class="form-" role="form">
                        <div class="modal-body">                        
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Machine Name</label>
                                        <input name="product_name" id="edit-product_name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Model Number</label>
                                        <input required="required" type="text" class="form-control" name="model_no" id="edit-model_no">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <span class="pull-left loader"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                        <input type="hidden" name="id" id="courseId">
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="card-header text-uppercase"><b>Delete Course</b>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/page/products.js"></script>
    </body>
</html>