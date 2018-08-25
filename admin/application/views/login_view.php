<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="img-cover" style="background-image: url(<?php echo base_url(); ?>/assets/img/photos-1/2.jpg);">
        <div class="container-fluid">
            <div class="sign-form">
                <div class="row">
                    <div class="col-md-4 offset-md-4 px-3">
                        <div class="box b-a-0">
                            <div class="p-2 text-xs-center">
                                <h5>Laxmi Pharma Equipment Adminstrations</h5>
                            </div>
                            <form action="<?php echo site_url('login/checklogin'); ?>" method="post" class="form-material mb-1">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email" required name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" required name="password">
                                </div>
                                <div class="px-2 form-group mb-0">
                                    <button type="submit" class="btn btn-purple btn-block text-uppercase">Sign in</button>
                                </div>
                            </form>
                            <div class="p-2 text-xs-center text-muted">
                                <span class="text-danger"><?php echo $this->session->flashdata('msg'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vendor JS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery-1.12.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/tether.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
    </body>
</html>