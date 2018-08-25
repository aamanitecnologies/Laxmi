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
                                <div class="card-header text-uppercase"><b>Invoices</b></div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Registration No.</th>
                                                <th>Name</th>
                                                <th>Mobile No.</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($invoices->status->error == false) {
                                                foreach ($invoices->payload->invoices as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><a href="<?php echo site_url('invoices/detail/' . $val->id.'/'.$val->student_created_at.'/'.$val->created_at); ?>"><?php echo $val->id; ?></a></td>
                                                        <td><a href="<?php echo site_url('students/profile/'.$val->registration_no);?>"><?php echo getRegNo($val); ?></a></td>
                                                        <td><?php echo $val->fname; ?></td>
                                                        <td><?php echo $val->mobile; ?></td>
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
                            <div class="col-sm-3">
                                <div class="card-header text-uppercase"><b>Filter</b></div>
                                <div class="box box-block bg-white">
                                    <form method="post" id="filter">
                                        <div class="form-group">
                                            <label>Invoice no.</label>
                                            <input type="number" required="required" class="form-control" name="invoice_no" id="invoice_no" placeholder="Search by invoice no.">
                                        </div>
                                        <div class="float-xs-right">
                                            <span class="pull-left loader"></span>
                                            <button type="button" onclick="return window.location.replace('')" class="btn btn-default btn-sm">Reset</button>&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
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

        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.edit-btn').on('click', function () {
                    $('#edit-modal').modal('show');
                });
                $('.delete-btn').on('click', function () {
                    $('#delete-modal').modal('show');
                });

                $(function () {
                    $("#filter").on("submit", function (event) {
                        event.preventDefault();
                        $('.loader').html('loading...');
                        $.ajax({
                            url: site_url + "invoices/filter",
                            type: "post",
                            data: $(this).serialize(),
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
                                table.clear();
                                table.draw(false);
                                if (obj.status.error) {
                                    $('.loader').html(obj.status.message);
                                    return false;
                                }
                                if (obj.payload.invoice.id) {
                                    table.row.add([
                                        '<a href="<?php echo site_url('invoices/detail/');?>'+obj.payload.invoice.id+'">'+obj.payload.invoice.id+'</a>',
                                        '<a href="<?php echo site_url('students/profile/');?>'+obj.payload.invoice.student_id+'">'+getRegNo(obj.payload.invoice)+'</a>',
                                        obj.payload.invoice.fname + ' ' + obj.payload.invoice.lname,
                                        obj.payload.invoice.phone,
                                        obj.payload.invoice.created_at
                                    ]).node().id = 'r';
                                }
                                table.draw(false);
                                $('.loader').html('');
                            }
                        });
                    });

                });

            });
        </script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/students.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                table.column('0:visible').order('desc').draw(false);
            });
        </script>

    </body>
</html>