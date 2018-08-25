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
                                <div class="card-header text-uppercase"><b>Batches</b></div>
                                <div class="box box-block bg-white">
                                    <table class="table table-striped table-bordered dataTable" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Admissions</th>
                                                <th>Course</th>
                                                <th>Batch Code</th>
                                                <th>Batch Start Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($batches->payload->batches)) {
                                                foreach ($batches->payload->batches as $val) {
                                                    ?>
                                                    <tr id="r<?php echo $val->id; ?>">
                                                        <td><?php echo $val->total_admissions.' / '.$val->total_seats; ?></td>
                                                        <td><?php echo $val->course; ?></td>
                                                        <td><a href="<?php echo site_url('batches/detail/' . $val->id); ?>"><?php echo $val->batch_code; ?></a></td>
                                                        <td><?php echo $val->batch_start_date; ?></td>
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
                                    
                                    <form id="filter" method="post" action="<?php echo site_url('batches/filter'); ?>">
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
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label>Admission Open</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_open1" checked="checked" name="admissions_open" value="1" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="admissions_open2" name="admissions_open" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Enable online admission</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label class="custom-control custom-radio">
                                                        <input id="take_online_admissions1" checked="checked" name="take_online_admissions" value="1" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Yes</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="take_online_admissions2" name="take_online_admissions" value="0" type="radio" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="float-xs-right">
                                                <button onclick="resetFilter()" type="button" class="btn btn-default btn-sm">Reset</button>
                                                <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                            </div>
                                        </div>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/page/batches.js"></script>
    </body>
</html>