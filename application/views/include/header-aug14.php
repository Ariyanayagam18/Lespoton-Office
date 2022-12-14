<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <?php $setting = setting_all();?>
  
  <link rel="icon" href="<?php echo base_url((setting_all('favicon'))?'assets/images/'.setting_all('favicon'):'assets/images/favicon.ico');?>">
  <?php if ($this->router->method==="raceresults") { 
      $eventname = $result_data[0]->Event_name;
      $eventdate = $result_data[0]->Event_date;
      $clubname  = $result_data[0]->name;
      $displaytitle = $eventname." - ".$eventdate." - ( ".$clubname." ) "; 
    ?>
  <title><?php echo $displaytitle;?><?php //echo (setting_all('website'))?setting_all('website'):'Dasboard';?></title>
  <?php } else { ?>
  <title>Spotlight Centralized System<?php //echo (setting_all('website'))?setting_all('website'):'Dasboard';?></title>
  <?php } ?>

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">
  <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap.css');?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/skin-black-light.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/skin-black-light.css');?>">
    <!--  <link rel="stylesheet" href="<?php echo base_url('assets/css/blue.css');?>">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/buttons.dataTables.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/daterangepicker.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/St.css'); ?>" />
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

  </head>
    <body class="hold-transition skin-black-light sidebar-mini" data-base-url="<?php echo base_url(); ?>">
        <div class="wrapper">

          <header class="main-header">
            <a href="<?php echo base_url(); ?>" class="logo">
             <?php $logo =  (setting_all('logo'))?setting_all('logo'):'logo.png'; ?>
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini">
                   <!--<img src="<?php echo base_url().'assets/images/'.$logo; ?>" id="logo">-->
                   SP
              </span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg">
                <!--<img src="<?php echo base_url().'assets/images/'.$logo; ?>" id="logo">-->
                SPOTLIGHT
              </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Control Sidebar Toggle Button -->
                        <!-- <li>
                          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li> -->
                        <!-- User Account: style can be found in dropdown.less -->          

                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <?php 
                 $profile_pic =  'user.png';
                 if(isset($this->session->userdata('user_details')[0]->profile_pic) && file_exists('assets/images/'.$this->session->userdata('user_details')[0]->profile_pic))
                              {
                                 $profile_pic = $this->session->userdata('user_details')[0]->profile_pic;
                              }?>
                              <img src="<?php echo base_url().'assets/images/'.$profile_pic;?>"  class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php echo isset($this->session->userdata('user_details')[0]->name)?$this->session->userdata('user_details')[0]->name:'';?></span>
                          </a>
                          <ul class="dropdown-menu" role="menu" style="width: 164px;">
                              <li><a href="<?php echo base_url('user/profile');?>"><i class="fa fa-user mr10"></i>My Account</a></li>
                              <li class="divider"></li>
                              <li><a href="<?php echo base_url('user/logout');?>"><i class="fa fa-power-off mr10"></i> Sign Out</a></li>
                          </ul>
                        </li>
                    </ul>
                </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              
              <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <?php echo '<pre>';print_r($this->router); die; ?>
                <li class="<?=($this->router->method==="profile")?"active":"not-active"?>"> 
                <li class="<?=($this->router->method==="dashboard")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/dashboard"> <i class="fa fa-dashboard"></i> <span>Dashboard </span></a>
                    </li> 
                </li>                
                <?php $this->load->view("include/menu");?> 
                
                   <?php if($this->session->userdata('user_details')[0]->user_type =='admin' || $this->session->userdata('user_details')[0]->user_type =='Admin') { ?>
                    <li class="<?=($this->router->method==="userTable")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/userTable"> <i class="fa fa-users"></i> <span>Clubs </span></a>
                    </li> 
                    <?php } ?>

                    <li class="<?=($this->router->method==="fancier")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/fancier"> <i class="fa fa-user"></i> <span>Fanciers</span></a>
                    </li>   
                    <li class="<?=($this->router->method==="races")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/races"> <i class="fa fa-calendar"></i> <span>Races</span></a>
                    </li>

                <?php if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){ ?>    
                    <li class="<?=($this->router->class==="setting")?"active":"not-active"?>">
                        <a href="<?php echo base_url("setting"); ?>"><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    </li>
                 <?php } ?>

              </ul>
            </section>
            <!-- /.sidebar -->
          </aside>          
<style>
.progress-main-div1 {
    padding-top: 10px;
    background-color: rgb(232, 82, 15);
    position: fixed;
    bottom: 21px;
    z-index: 50;
    width: 50%;
    padding-bottom: 10px;
    color: white;
    text-align: center;
    margin-left: 34%;
    margin-bottom: 19px;
}
.progress-main-div1 a{
    color:#04046e;;
}
</style>
