<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>
    <body class="fixed-sidebar fixed-header fixed-footer content-appear skin-default">
        <div class="wrapper">
            <?php $this->load->view('includes/sidebar_view'); ?>
            <div class="site-content">
                <!-- Content -->
                <div class="content-area pb-1">
                    <div class="profile-header mb-1">
                        <div class="profile-header-counters clearfix">

                        </div>
                    </div>
                    <div class="container-fluid">
                        <h4>Admission Detail</h4>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="box bg-white">
                                    <div class="card-header text-uppercase"><b>Student informations</b><span class="pull-right loader"></span></div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="profile-avatar" id="photo-view">
                                                        <img width="200" id="photo-img" src="<?php echo base_url(); ?>/assets/img/user.png" alt="">
                                                    </div>
                                                    <form method="post" id="photo-frm" enctype="multipart/form-data">
                                                        <div class="card-block groupinfo">
                                                            <span class="loader pull-left"></span>
                                                            <a href="#" id="upload-photo">Upload Photo</a>
                                                            <input type="file" name="student_photo" id="fileupload" style="display:none;">
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <p class="first-name"><strong>First name</strong></p>
                                                        <p class="last-name"><strong>Last name</strong></p>
                                                        <p class="law_school"><strong>Law School</strong></p>
                                                        <p class="yop"><strong>Year Of Passing</strong></p>
                                                        <p class="referred_by"><strong>Referred By</strong></p>
                                                        <p class="course-name"><strong>Course name</strong></p>
                                                        <p class="date-of-birth"><strong>Date of Birth</strong></p>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <p class="first-name-val"><?php echo(isset($this->session->userdata('admission')['fname'])) ? $this->session->userdata('admission')['fname'] : ''; ?></p>
                                                        <p class="last-name-val"><?php echo(isset($this->session->userdata('admission')['lname'])) ? $this->session->userdata('admission')['lname'] : ''; ?></p>
                                                        <p class="law_school-val"><?php echo(isset($this->session->userdata('admission')['law_school'])) ? $this->session->userdata('admission')['law_school'] : ''; ?></p>
                                                        <p class="yop-val"><?php echo(isset($this->session->userdata('admission')['yop'])) ? $this->session->userdata('admission')['yop'] : ''; ?></p>
                                                        <p class="referred_by-val"><?php echo(isset($this->session->userdata('admission')['referred_by'])) ? $this->session->userdata('admission')['referred_by'] : ''; ?></p>
                                                        <p class="course-name-val"><?php echo(isset($this->session->userdata('admission')['course_name'])) ? $this->session->userdata('admission')['course_name'] : ''; ?></p>
                                                        <p class="date-of-birth-val"><?php echo(isset($this->session->userdata('admission')['dob'])) ? date('dS F Y', strtotime($this->session->userdata('admission')['dob'])) : ''; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="father-name"><strong>Father's name</strong></p>
                                                        <p class="occupation"><strong>Father's occupation</strong></p>
                                                        <p class="father-phone"><strong>Phone</strong></p>
                                                        <p class="student-email"><strong>Student email</strong></p>
                                                        <p class="student-mobile"><strong>Student mobile</strong></p>
                                                        <p class="temporary-add"><strong>Temporary address</strong></p>
                                                        <p class="permanent-add"><strong>Permanent address</strong></p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p class="father-name-val"><?php echo(isset($this->session->userdata('admission')['fathers_name'])) ? $this->session->userdata('admission')['fathers_name'] : ''; ?></p>
                                                        <p class="occupation-val"><?php echo(isset($this->session->userdata('admission')['fathers_occupation'])) ? $this->session->userdata('admission')['fathers_occupation'] : ''; ?></p>
                                                        <p class="father-phone-val"><?php echo(isset($this->session->userdata('admission')['phone'])) ? $this->session->userdata('admission')['phone'] : ''; ?></p>
                                                        <p class="student-email-val"><?php echo(isset($this->session->userdata('admission')['email'])) ? $this->session->userdata('admission')['email'] : ''; ?></p>
                                                        <p class="student-mobile-val"><?php echo(isset($this->session->userdata('admission')['mobile'])) ? $this->session->userdata('admission')['mobile'] : ''; ?></p>
                                                        <p class="temporary-add-val"><?php echo(isset($this->session->userdata('admission')['local_address'])) ? $this->session->userdata('admission')['local_address'] : ''; ?></p>
                                                        <p class="permanent-add-val"><?php echo(isset($this->session->userdata('admission')['permanant_address'])) ? $this->session->userdata('admission')['permanant_address'] : ''; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-6">
                                <div class="card-header text-uppercase"><b>Singnature</b></div>
                                <div class="box-block bg-white">
                                    <div id="signature-pad" class="signature-pad">
                                        <div class="signature-pad--body">
                                            <canvas></canvas>
                                        </div>
                                        <div class="signature-pad--footer">
                                            <div class="description">Sign above</div>
                                            <div class="signature-pad--actions">
                                                <div>
                                                    <button type="button" class="button clear" data-action="clear">Clear</button>
                                                    <button type="button" class="button" data-action="change-color">Change color</button>
                                                    <button type="button" class="button" data-action="undo">Undo</button>
                                                </div>
                                                <div>
                                                    <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                                                    <button type="button" id="signature-a" class="button save" data-action="save-png">Upload</button>
                                                    <form method="post" id="signature-frm" enctype="multipart/form-data">
                                                        <span class="loader pull-left"></span>

                                                        <input type="file" name="signature" id="signature-b" style="display: none;">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="upload-signature-block text-xs-center">
                                        <img src="" id="signature-img" width="200" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="card-header text-uppercase"><b>Id Proof</b></div>
                                <div class="box-block bg-white">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="profile-avatar" id="dvPreview-id-proof">
                                                <img width="200" id="document-img" src="<?php echo base_url(); ?>/assets/img/user.png" alt="">
                                            </div>
                                            <form method="post" id="documents-frm" enctype="multipart/form-data">
                                                <div class="card-block">
                                                    <span class="loader pull-left"></span>
                                                    <a href="#" id="document-a">Upload Id Proof</a>
                                                    <input type="file" name="id_proof" id="id-proof" style="display:none;">
                                                </div> 
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" id="back">Cancel</button>
                                        <button type="submi11t" class="btn btn-primary">Confirm Admission</button>
                                        <br>
                                        <span class="pull-left loader"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-xs-center">
                            <div class="col-sm-4 text-sm-left mb-0-5 mb-sm-0">
                                2018 © Rahul's IAS
                            </div>
                            <div class="col-sm-8 text-sm-right">
                                <ul class="nav nav-inline l-h-2">
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Privacy</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Terms</a></li>
                                    <li class="nav-item"><a class="nav-link text-black" href="#">Help</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <?php $this->load->view('includes/footer_incs'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                // Upload Photo
                $('#upload-photo').on('click', function () {
                    $('#fileupload').click();
                });
                $("#fileupload").change(function () {
                    $('#photo-frm').submit();
                });
                // Upload Id Proof
                $('#document-a').on('click', function () {
                    $('#id-proof').click();
                });
                $("#id-proof").change(function () {
                    $('#documents-frm').submit();
                });
                // Upload Signature
                $('#signature-a').on('click', function () {
                    $('#signature-b').click();
                });
                $("#signature-b").change(function () {
                    $('#signature-frm').submit();
                });
                // Back to Admission Form
                $('#back').on('click', function () {
                    window.location.replace("<?php echo site_url('admissions/add'); ?>");
                });
            });

            $(function () {
                // Save Photo
                $("#photo-frm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'admissions/upload',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            $("#photo-img").attr("src", obj.payload.upload.file_url);
                        }
                    });
                });
                // Save Id Proof
                $("#documents-frm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'admissions/upload',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            $("#document-img").attr("src", obj.payload.upload.file_url);
                        }
                    });
                });
                // Save Signature
                $("#signature-frm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'admissions/upload',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            $("#signature-img").show();
                            $("#signature-img").attr("src", obj.payload.upload.file_url);
                        }
                    });
                });
                $("#addFrm").on("submit", function (event) {
                    event.preventDefault();
                    loaderProcess();
                    $.ajax({
                        url: site_url + 'admissions/saveDocuments',
                        type: "post",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var obj = $.parseJSON(data);
                            if (obj.status.error) {
                                loaderFail(obj.status.message);
                                return false;
                            }
                            loaderSuccess();
                            window.location.replace(site_url + 'students/profile/' + obj.payload.admission.id);
                        }
                    });
                });
            });
        </script>
    </body>
</html>