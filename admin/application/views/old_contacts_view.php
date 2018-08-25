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
                        <!-- Add new course -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" name="smsFrm" id="smsFrm">
                                    <!-- Modal Header -->
                                    <div class="card-header text-uppercase"><b>Send bulk sms to all old students</b>
                                        <button type="button" class="close" 
                                                data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button></div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Mobile Numbers</label>
                                                    <textarea rows="5" required="required" class="form-control" name="contacts" id="contacts"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Select Batch</label>
                                                    <select onchange="getContactsByBatchId(this.value)" name="batch_id" id="batch_id" class="form-control">
                                                        <option value="">Please Select Batch</option>
                                                        <?php foreach ($batches->payload->batches as $val) { ?>
                                                            <option value="<?php echo $val->id; ?>"><?php echo $val->batch_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enter Message</label>
                                                    <textarea required="required" type="text" rows="5" class="form-control" id="text-sms" name="text_sms" placeholder="Enter SMS"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <span class="pull-left loader" id="msg"></span>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('includes/footer_view'); ?>

            </div>
        </div>
    </div>
    <?php $this->load->view('includes/footer_incs'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                $("#smsFrm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: "<?php echo site_url('OldStudents/sendSms'); ?>",
                        type: "post",
                        data: $(this).serialize(),
                        success: function (data) {
                            $('#msg').html(data);
                            loaderSuccess();
                        }
                    });
                });
            });
        });
        function getContactsByBatchId(batch_id) {
            loaderProcess();
            $.ajax({
                url: "<?php echo site_url('OldStudents/getContactsByBatchId'); ?>/" + batch_id,
                success: function (contacts) {
                    $('#contacts').val(contacts);
                    loaderSuccess();
                }
            });
        }
    </script>
</body>
</html>