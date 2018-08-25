<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>
        <?php
        if (!empty($this->uri->rsegments)) {
            $page = $this->uri->rsegment(1);
        } else {
            $page = 'Login';
        }
        if($page == 'invoices'){
            $page = '';
        }
        echo ucfirst($page);
        ?>
    </title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.jscrollpane.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/waves.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
    <?php if ($this->uri->segment(2) == 'documents') { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/signature-pad.css">
    <?php } ?>



    <!-- Neptune CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/core.css">


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.css">











    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
