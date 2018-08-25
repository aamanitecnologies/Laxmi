<!-- Preloader -->
<div class="preloader"></div>

<!-- Sidebar -->
<div class="site-overlay"></div>
<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-layout-tab"></i></span>
                    <span class="s-text">Master</span>
                </a>
                <ul>
                    <li><a href="<?php echo site_url('products'); ?>">Products</a></li>
                    <li><a href="<?php echo site_url('parts'); ?>">Parts</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo site_url('users'); ?>" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="ti-user"></i></span>
                    <span class="s-text">Staff users</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Header -->
<div class="site-header">
    <nav class="navbar navbar-light">
        <div class="navbar-left">
            <a class="navbar-brand" href="<?php echo site_url();?>">
                <div class="logo"></div>
            </a>
            <div class="toggle-button dark sidebar-toggle-first float-xs-left hidden-md-up">
                <span class="hamburger"></span>
            </div>
            <div class="toggle-button-second dark float-xs-right hidden-md-up">
                <i class="ti-arrow-left"></i>
            </div>
            <div class="toggle-button dark float-xs-right hidden-md-up" data-toggle="collapse" data-target="#collapse-1">
                <span class="more"></span>
            </div>
        </div>
        <div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
            <div class="toggle-button light sidebar-toggle-second float-xs-left hidden-sm-down">
                <span class="hamburger"></span>
            </div>
            <ul class="nav navbar-nav float-md-right" style="padding:14px;">
                <li class="nav-item dropdown">
                    <div class="dropdown-messages dropdown-tasks dropdown-menu dropdown-menu-right animated fadeInUp">
                        <div class="m-item">
                            <div class="mi-icon bg-info"><i class="ti-comment"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">commented post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">5 min ago</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-danger"><i class="ti-heart"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">liked post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">15:07</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-purple"><i class="ti-user"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">followed</span> <a class="text-black" href="#">Kate Doe</a></div>
                            <div class="mi-time">yesterday</div>
                        </div>
                        <div class="m-item">
                            <div class="mi-icon bg-danger"><i class="ti-heart"></i></div>
                            <div class="mi-text"><a class="text-black" href="#">John Doe</a> <span class="text-muted">liked post</span> <a class="text-black" href="#">Lorem ipsum dolor</a></div>
                            <div class="mi-time">3 days ago</div>
                        </div>
                        <a class="dropdown-more" href="#">
                            <strong>View all notifications</strong>
                        </a>
                    </div>
                </li>


                <div class="row nav-item dropdown hidden-sm-down">
                    <div class="col-sm-10">
                    <div id="datefilter" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                          <i class="fa fa-calendar"></i>&nbsp;
                          <span><?php echo date('F d, Y', strtotime($this->session->userdata('FISCAL_YEAR')['startDate'])).' - '.date('F d, Y', strtotime($this->session->userdata('FISCAL_YEAR')['endDate']));?></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                    <div class="col-sm-2">
<li class="nav-item dropdown hidden-sm-down">
                    <a href="#" data-toggle="dropdown" aria-expanded="false">
                        <span class="avatar box-32">
                                <!-- <img src="img/avatars/1.jpg" alt=""> -->
                            <i class="ti-user"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated fadeInUp">
                        <a class="dropdown-item" href="#">
                            <i class="ti-user mr-0-5"></i> Profile
                        </a>
                        <a class="dropdown-item" href="<?php echo site_url('logout'); ?>"><i class="ti-power-off mr-0-5"></i> Sign out</a>
                    </div>
                </li>
                    </div>

                </div>

                





            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item hidden-sm-down">
                    <a class="nav-link toggle-fullscreen" href="#">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>