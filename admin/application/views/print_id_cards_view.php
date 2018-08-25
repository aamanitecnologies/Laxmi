<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="row">
                    <div class="col-sm-9">
                        <div class="content-area pb-1">
                            <div class="profile-header mb-1">
                                <div class="profile-header-counters clearfix">
                                </div>
                            </div>
                            <div class="box box-block bg-white">
                                <table class="table table-striped table-bordered dataTable" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Registration No.</th>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Date Of Admission</th>
                                            <th>Validity</th>
                                            <th>Temporary Address</th>
                                            <th>Permanent Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($cards->status->error == false) {
                                            foreach ($cards->payload->cards as $val) {
                                                ?>
                                                <tr id="r<?php echo $val->id; ?>">
                                                    <td><?php echo getRegNo($val); ?></td>
                                                    <td><?php echo $val->fname; ?></td>
                                                    <td><?php echo $val->course_code; ?></td>
                                                    <td class="valid-from"><?php echo dateFromat($val->created_at); ?></td>
                                                    <td class="valid-to"><?php echo dateFromat($val->created_at); ?></td>
                                                    <td><?php echo $val->local_address; ?></td>
                                                    <td><?php echo $val->permanant_address; ?></td>
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
                    <div class="col-sm-3">
                        <div class="card-header text-uppercase">
                            <b>Filter</b>
                        </div>
                        <div class="box box-block bg-white">
                            <form method="post" id="card-frm" action="<?php echo site_url('PrintIdCards/printCards');?>">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Valid From</label>
                                        <input onchange="validFrom()" type="text" required="required" id="datepicker-valid-from" name="valid_from"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Valid To</label>
                                        <input onchange="validTo()" type="text" required="required" id="datepicker-valid-to" name="valid_to"  class="form-control">
                                    </div>
                                </div>                                        
                                <div class="float-xs-right">
                                    <button type="button" class="btn btn-default btn-sm">Reset</button>&nbsp;&nbsp;
                                    <button type="submit" id="filter" class="btn btn-primary btn-sm">Download</button>
                                </div>
                                <br>
                                <input type="hidden" name="batch_id" value="<?php echo $batch_id;?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                table.column('0:visible').order('ASC').draw(false);
                
                $('#datepicker-valid-from').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
                $('#datepicker-valid-to').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });  
                
                
                
            });
            
            function validFrom(){
                $('.valid-from').html(dateFormate($('#datepicker-valid-from').val()));
            }
            
            function validTo(){
                $('.valid-to').html(dateFormate($('#datepicker-valid-to').val()));
            }
            
        </script>
    </body>
</html>