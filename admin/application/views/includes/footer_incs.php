<!-- Vendor JS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/detectmobilebrowser.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/mwheelIntent.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.fullscreen-min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/waves.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/switchery.min.js"></script>
<!-- Data Tables JS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<?php if ($this->uri->segment(2) == 'documents') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/signature_pad.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/signature_app.js"></script>
<?php } ?>
<!-- Neptune JS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/demo.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tables-datatable.js"></script>
<script type="text/javascript">
    var site_url = "<?php echo site_url(); ?>/";
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/page/comman.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var start = moment().month(3).startOf('month');//moment().subtract(0, 'days');
        var end = moment().add(1, 'year').month(2).endOf('month');//moment();

        function cb(start, end) {
            //alert(start);
            $('#datefilter span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //make ajax request here
            setDateRange(start.format('MMMM D, YYYY'), end.format('MMMM D, YYYY'));
        }

        $('#datefilter').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last Fiscal Year': [moment().subtract(1, 'year').month(3).startOf('month'), moment().month(2).endOf('month')],
                'Current Fiscal Year': [moment().month(3).startOf('month'), moment().add(1, 'year').month(2).endOf('month')]
            }
        }, cb);

        //cb(start, end);

    });

    function setDateRange(startDate, endDate) {
        $.ajax({
            url: site_url + 'dashboard/setFiscalYear/',
            method: "POST",
            dataType: "json",
            data: {startDate: startDate, endDate: endDate},
            success: function (data) {
                window.location.replace(data);
            }
        });
    }



</script>
