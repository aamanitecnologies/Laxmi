<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('includes/head'); ?>

    <form method="post" id="testfrm" enctype="multipart/form-data">
        <input type="image" src="<?php echo base_url('assets/img/logo.png'); ?>" width="200px"/>
        <input type="file" name="icon" id="my_file" />
    </form>

    <?php $this->load->view('includes/footer_incs'); ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#my_file").change(function () {
                $('#testfrm').submit();
            });

            $("#testfrm").on("submit", function (event) {
                event.preventDefault();
                loaderProcess();
                $.ajax({
                    url: site_url + 'test/fileupload',
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        alert(data);
                    }
                });
            });

        });

    </script>
</body>
</html>