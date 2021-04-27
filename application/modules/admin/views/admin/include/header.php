<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Dashboard</title>
    <!--favicon-->
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <!-- Vector CSS -->
    <link href="<?=base_url()?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- simplebar CSS-->
    <link href="<?=base_url()?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="<?=base_url()?>assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="<?=base_url()?>assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="<?=base_url()?>assets/css/app-style.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
	.alert{
		padding: 12 !important;
	}
</style>
</head>

<body>

    <!-- Start wrapper-->
    <div id="wrapper">
        <?php 
		$user=$this->session->userdata('loginporter');

        // var_dump($porter);
        // die;
 ?>
        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="<?=base_url('admin/dashboard')?>">
                   <!--  <img src="<?=base_url()?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon"> -->
                    <h5 class="logo-text">Admin Dashboard</h5>
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol">
                <!-- <li class="sidebar-header">MAIN NAVIGATION</li> -->
                <li>
                   <a href="<?=base_url('admin/dashboard')?>"><i class="fa fa-dashcube"></i>Dashboard</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/category')?>"><i class="fa fa-dashcube"></i>Categories Management</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/lab_test')?>"><i class="fa fa-dashcube"></i>Lab Test Management</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/test_packages')?>"><i class="fa fa-dashcube"></i>Test Packages Management</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/labs')?>"><i class="fa fa-dashcube"></i>Lab's Management</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/manage_user')?>"><i class="fa fa-dashcube"></i>User Management</a>
                </li>              
                <li>
                   <a href="<?=base_url('admin/coupon')?>"><i class="fa fa-dashcube"></i>Manage Coupon</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/notification')?>"><i class="fa fa-dashcube"></i>Manage Notification</a>
                </li>
                <!-- <li>
                    <a href="#" class="waves-effect">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Orders Management</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="<?=base_url('admin/orders_request')?>"><i class="fa fa-circle-o-notch"></i>Orders Request</a></li>
                        <li><a href="<?=base_url('admin/ongoing_orders')?>"><i class="fa fa-circle-o-notch"></i>On-going Orders</a></li>
                        <li><a href="<?=base_url('admin/complete_orders')?>"><i class="fa fa-circle-o-notch"></i>Past Orders</a></li>
                    </ul>
                </li> -->
                <li>
                    <a href="<?=base_url('admin/manage_faq')?>"><i class="fa fa-dashcube"></i>FAQ's</a>
                </li>
                <li>
                    <a href="<?=base_url('admin/about_us')?>"><i class="fa fa-dashcube"></i>About us</a>
                </li>
                <li>
                    <a href="<?=base_url('admin/term_and_condition')?>"><i class="fa fa-dashcube"></i>Term And Condition</a>
                </li>
                <li>
                   <a href="<?=base_url('admin/setting')?>"><i class="fa fa-dashcube"></i>Setting</a>
                </li>   
                </li>
                <li><a href="<?=base_url('admin/logout')?>" onclick="return confirm('Are you sure want to exit')"><i class="fa fa-sign-out"></i>Logout</a>
                </li>
                    
            </ul>

        </div>
        <!--End sidebar-wrapper-->



        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top gradient-scooter">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                        <span class="user-profile">
                            <?php

                            if(!empty($userprofile->profile))
                            {
                                ?>
                                    <img src="<?=base_url('assets/store_id_proof/').$userprofile->profile?>">
                                <?php
                               
                            }
                            else
                            {
                            ?>
                                <img src="<?=base_url()?>assets/images/u.jpg" class="img-circle" alt="user avatar">
                            <?php
                            }

                            ?>
                                
                            </span>
                        </a>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                    <div class="avatar">
                                            <?php

                                            if(!empty($userprofile->profile))
                                            {
                                                ?>
                                                <img class="align-self-start mr-3" src="<?=base_url('assets/store_id_proof/').$userprofile->profile?>" alt="user avatar">
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <img src="<?=base_url()?>assets/images/u.jpg" class="img-circle" alt="user avatar">
                                                <?php
                                            }

                                            ?>                                            
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title"><?=@$userprofile->username?></h6>
                                            <p class="user-subtitle"><?=@$userprofile->email?></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="<?=base_url('admin/update_profile')?>"><i class="icon-wallet mr-2"></i>Profile</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="<?=base_url('update_profile')?>"><i class="icon-settings mr-2"></i>Setting</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="<?=base_url('logout')?>" onclick="return confirm('Are you sure want to exit')"><i
                                        class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>

            </nav>
        </header>
