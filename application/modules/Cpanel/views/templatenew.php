<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/logo_pyk.png') ?>" />
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo_pyk.png') ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>SODAP | KOTA PAYAKUMBUH sumbar</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  <!-- Canonical SEO -->
  <link rel="canonical" href="http://sodap.payakumbuhkota.go.id" />
  <!--  Social tags      -->
  <meta name="keywords" content="kota payakumbuh, aplikasi kota payakumbuh, goverment kota payakumbuh, kominfo kota payakumbuh, aplikasi kominfo payakumbuh, dinas kominfo kota payakumbuh, sodap kota payakumbuh, payakumbuh sumatra barat, pemerintah kota payakumbuh, sodap, smart city kota payakumbuh, payakumbuh go online,kominfo kota payakumbuh sumatra barat">
  <meta name="description" content="Aplikasi pemerintahan Kota Payakumbuh, yang di kembangkan Dinas Kominfo Kota Payakumbuh.">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Sodap | Kota Payakumbuh">
  <meta itemprop="description" content="Aplikasi pemerintahan Kota Payakumbuh, yang di kembangkan Dinas Kominfo Kota Payakumbuh">
  <meta itemprop="image" content="<?php echo base_url('assets/img/logobaru.png') ?>">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@ikyprima">
  <meta name="twitter:title" content="Sodap | Kota Payakumbuh">
  <meta name="twitter:description" content="Aplikasi pemerintahan Kota Payakumbuh, yang di kembangkan Dinas Kominfo Kota Payakumbuh.">
  <meta name="twitter:creator" content="@ikyprima">
  <meta name="twitter:image" content="<?php echo base_url('assets/img/logobaru.png') ?>">
  <meta name="theme-color" content="#5373F4"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/font-awesome/css/font-awesome.min.css') ?>">

  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/Ionicons/css/ionicons.min.css') ?>">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/bower_components/select2/dist/css/select2.min.css') ?>">

  <!-- Animation Css -->
  <link href="<?php echo base_url('assets/admin/plugins/animate-css/animate.css') ?>" rel="stylesheet" />

  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/pace/pace.min.css') ?>">

  <!-- Sweetalert Css -->
  <link href="<?php echo base_url('assets/admin/plugins/sweetalert/sweetalert.css') ?>" rel="stylesheet" />

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">

  <!--  spinner js -->

  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/jquery-spinner/dist/css/bootstrap-spinner.css') ?>">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/iCheck/all.css') ?>">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css') ?>">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/skins/_all-skins.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/orgchart/css/jquery.orgchart.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/orgchart/css/style.css')?>">
  <style type="text/css">
  #chart-container { height: 100%; border: 2px solid #aaa; }
  .orgchart { background: #fff; }
  .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
  .orgchart td>.down { background-color: #aaa; }
  .orgchart .middle-level .title { background-color: #006699; }
  .orgchart .middle-level .content { border-color: #006699; }
  .orgchart .product-dept .title { background-color: #009933; }
  .orgchart .product-dept .content { border-color: #009933; }
  .orgchart .rd-dept .title { background-color: #993366; }
  .orgchart .rd-dept .content { border-color: #993366; }
  .orgchart .pipeline1 .title { background-color: #996633; }
  .orgchart .pipeline1 .content { border-color: #996633; }
  .orgchart .frontend1 .title { background-color: #cc0066; }
  .orgchart .frontend1 .content { border-color: #cc0066; }



  /*blink*/
  .blink_me {
    -webkit-animation-name: blinker;
    -webkit-animation-duration: 2s;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;

    -moz-animation-name: blinker;
    -moz-animation-duration: 2s;
    -moz-animation-timing-function: linear;
    -moz-animation-iteration-count: infinite;

    animation-name: blinker;
    animation-duration: 2s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
  }

  @-moz-keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
  }

  @-webkit-keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
  }

  @keyframes blinker {
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
  }
  /*batas blink*/
  table td.highlighted {
    background-color:#367FA9;
  }

  .wizard {
    margin: 20px auto;
    background: #fff;
  }

  .wizard .nav-tabs {
    position: relative;
    margin: 40px auto;
    margin-bottom: 0;
    border-bottom-color: #e0e0e0;
  }

  .wizard > div.wizard-inner {
    position: relative;
  }

  .connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
  }

  .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
  }

  span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
  }
  span.round-tab i{
    color:#555555;
  }
  .wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #5bc0de;

  }
  .wizard li.active span.round-tab i{
    color: #5bc0de;
  }

  span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
  }

  .wizard .nav-tabs > li {
    width: 25%;
  }

  .wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
  }

  .wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #5bc0de;
  }

  .wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
  }

  .wizard .nav-tabs > li a:hover {
    background: transparent;
  }

  .wizard .tab-pane {
    position: relative;
    padding-top: 50px;
  }

  .wizard h3 {
    margin-top: 0;
  }

  @media( max-width : 585px ) {

    .wizard {
      width: 90%;
      height: auto !important;
    }

    span.round-tab {
      font-size: 16px;
      width: 50px;
      height: 50px;
      line-height: 50px;
    }

    .wizard .nav-tabs > li a {
      width: 50px;
      height: 50px;
      line-height: 50px;
    }

    .wizard li.active:after {
      content: " ";
      position: absolute;
      left: 35%;
    }
  }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/admin/bower_components/jquery/dist/jquery.min.js')?>" type="text/javascript"></script>
  <script type="text/javascript" >
  var base_url = '<?php echo base_url() ?>';
  </script>

  <!-- DataTables -->
  <script src="<?php echo base_url('assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini sidebar-collapse">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>P</b>YK</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Sodap</b>PYK</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">

              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li><!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <img src="<?php echo base_url('assets/img/default-avatar.png')?>" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                  </ul>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/img/default-avatar.png')?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url('assets/img/default-avatar.png')?>" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name ?>
                    <small><?php echo $this->ion_auth->user()->row()->username ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">

                    </div>
                    <div class="col-xs-4 text-center">

                    </div>
                    <div class="col-xs-4 text-center">

                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">

                  </div>
                  <div class="pull-right">

                    <a href="<?php echo base_url('User/logout');?>" class="btn btn-default btn-flat">Keluar</a>

                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->

          </ul>
        </div>
      </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <img class="profile-user-img img-responsive " src="<?php echo base_url('assets/img/logo_pyk.png') ?>" alt="Logo" >
          <!--    <div class="pull-left image">
          <img src="<?php echo base_url('assets/img/default-avatar.png')?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
        <p><?php echo $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name ?></p>
        <a><?php echo $this->ion_auth->user()->row()->username ?></a>
      </div> -->
    </div>


    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>

        </a>

      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?php
  echo $contents;
  ?>
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.0.0
  </div>
  <strong>Copyright &copy; 2018 <a href="http://payakumbuhkota.go.id">Payakumbuh Kota</a>.</strong> All rights
  reserved.
</footer>

<!-- Control Sidebar -->

<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->

</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')?>" type="text/javascript"></script>


<!-- Select2 -->
<script src="<?php echo base_url('assets/admin/bower_components/select2/dist/js/select2.full.min.js')?>"></script>

<!-- SlimScroll -->
<script src="<?php echo base_url('assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')?>" type="text/javascript"></script>

<!-- FastClick -->
<script src="<?php echo base_url('assets/admin/bower_components/fastclick/lib/fastclick.js')?>" type="text/javascript"></script>

<!-- PACE -->
<script src="<?php echo base_url('assets/admin/bower_components/PACE/pace.min.js')?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/admin/dist/js/adminlte.min.js')?>" type="text/javascript"></script>

<!-- date-range-picker -->
<script src="<?php echo base_url('assets/admin/bower_components/moment/min/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>

<!-- bootstrap datepicker -->
<script src="<?php echo base_url('assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>

<!-- SweetAlert Plugin Js -->
<script src="<?php echo base_url('assets/admin/plugins/sweetalert/sweetalert.min.js')?>"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>"></script>

<!-- Forms Validations Plugin -->
<script src="<?php echo base_url('assets/js/jquery.validate.min.js')?>"></script>

<!-- InputMask -->
<!-- <script src="<?php echo base_url('assets/admin/plugins/input-mask/jquery.inputmask.js')?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/input-mask/jquery.inputmask.date.extensions.js')?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/input-mask/jquery.inputmask.extensions.js')?>"></script>
-->
<script src="<?php echo base_url('assets/admin/plugins/input-mask/jquery.inputmask.bundle.js')?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url('assets/admin/dist/js/demo.js')?>" type="text/javascript"></script> -->
<script src="<?php echo base_url('assets/js/user.js')?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/orgchart/js/jquery.mockjax.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/orgchart/js/jquery.orgchart.js')?>"></script>

</body>
</html>
