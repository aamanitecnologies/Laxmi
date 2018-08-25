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
                        <h4 class="col-sm-9">Dashboard </h4>
                      </div>
                        <div class="row row-md">
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="box box-block bg-white tile tile-1 mb-2">
                                    <div class="t-icon right"><span class="bg-danger"></span><i class="ti-shopping-cart-full"></i></div>
                                    <div class="t-content">
                                        <h6 class="text-uppercase mb-1">Total students</h6>
                                        <h1 class="mb-1"><?php echo $status->payload->dashboard_status->total_students; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="box box-block bg-white tile tile-1 mb-2">
                                    <div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
                                    <div class="t-content">
                                        <h6 class="text-uppercase mb-1">Admissions</h6>
                                        <h1 class="mb-1"><?php echo $status->payload->dashboard_status->admissions; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="box box-block bg-white tile tile-1 mb-2">
                                    <div class="t-icon right"><span class="bg-primary"></span><i class="ti-package"></i></div>
                                    <div class="t-content">
                                        <h6 class="text-uppercase mb-1">Collections</h6>
                                        <h1 class="mb-1">Rs. <?php echo $status->payload->dashboard_status->collections; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-xs-12">
                                <div class="box box-block bg-white tile tile-1 mb-2">
                                    <div class="t-icon right"><span class="bg-warning"></span><i class="ti-receipt"></i></div>
                                    <div class="t-content">
                                        <h6 class="text-uppercase mb-1">Refunds</h6>
                                        <h1 class="mb-1">Rs. <?php echo $status->payload->dashboard_status->refunds; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card-header text-uppercase">Recent Admissions</div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" class="table-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Registration No.</th>
                                                <th>Batch</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($admissions->status->error == false) {
                                                foreach ($admissions->payload->admissions as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo $val->fname ?></td>
                                                        <td><a href="<?php echo site_url('students/profile/'.$val->id);?>"><?php echo getRegNo($val);?></a></td>
                                                        <td><?php echo $val->batch_code; ?></td>
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
                            <div class="col-sm-6">
                                <div class="card-header text-uppercase">Recent Invoices</div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" class="table-0">
                                        <thead>
                                            <tr>
                                                <th>Invoice No.</th>
                                                <th>Registration No.</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($invoices->status->error == false) {
                                                foreach ($invoices->payload->invoices as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><a href="<?php echo site_url('invoices/detail/' . $val->id.'/'.$val->student_created_at.'/'.$val->created_at); ?>"><?php echo $val->id;?></a></td>
                                                        <td><a href="<?php echo site_url('students/profile/'.$val->registration_no);?>"><?php echo getRegNo($val);?></a></td>
                                                        <td><?php echo $val->fname ; ?></td>
                                                        <td><?php echo $val->phone; ?></td>
                                                        <td><?php echo dateFromat($val->created_at); ?></td>
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
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                var table_0 = $('.table-0').DataTable();
            });
        </script>
    </body>
</html>
