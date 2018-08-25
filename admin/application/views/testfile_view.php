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
                            <div class="col-sm-6">
                                <div class="float-md-left">
                                    <h4 class="mb-2">New batch</h4>
                                </div>
                            </div>
                        </div>
                        <div class="box box-block bg-white">
                            <div class="row">
                                <form method="post" action="<?php echo site_url('courses/save'); ?>" enctype="multipart/form-data">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                        <label>Course name</label>
                                        <input required="required" type="text" class="form-control" name="name">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Course icon</label>
                                        <input type="file" class="form-control" name="icon">
                                        </div>
                                        <div class="form-group">
                                            <label>Duration</label>
                                        <input required="required" type="number" class="form-control" name="duration">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Duration period</label>
                                        <select required="required" class="form-control" id="exampleFormControlSelect1" name="duration_code">
                                            <option>Weeks</option>
                                            <option>Months</option>
                                            <option>Years</option>
                                        </select>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/courses.js"></script>
    </body>
</html>