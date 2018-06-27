<!DOCTYPE html>
<html lang="en">
<head>
<title>Bangladesh Public School Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap-responsive.min.css" />
<!-- kendo assetes
 start here-->
<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.3.1028/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.3.1028/styles/kendo.material.min.css" />
<link rel="stylesheet" href="//kendo.cdn.telerik.com/2016.3.1028/styles/kendo.material.mobile.min.css" />




 <!-- kendo assete end here -->
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/colorpicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/uniform.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/elspress-style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/elspress-media.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap-wysihtml5.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/c3.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/jquery.gritter.css" />
<link href="<?php echo base_url(); ?>public/backend/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>




<script src="<?php echo base_url(); ?>public/backend/js/jquery.min.js"></script>
<!-- <kendo> -->
<link rel="stylesheet" href="http://cdn.kendostatic.com/2013.2.626/styles/kendo.common.min.css" />
<link rel="stylesheet" href="http://cdn.kendostatic.com/2013.3.1324/styles/kendo.default.min.css" />
<!-- <kendo> -->

<!-- <kendo> -->
<script src="http://cdn.kendostatic.com/2013.2.626/js/kendo.all.min.js"></script>
<!-- <kendo> -->



 
 





</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="#">Bangladesh Public School Admin</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"><?php if( isset( $auth_user_id ) ){ echo "&nbsp;".$auth_username; } else echo "Welcome User"; ?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url('dashboard/profile'); ?>"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>

          <?php
            $link_protocol = USE_SSL ? 'https' : NULL;
            if( isset( $auth_user_id ) ){
              echo "<li><a href='".base_url()."login/logout'><i class='icon-key'></i> Log Out</a></li>";
            }
          ?>

      </ul>
    </li>
    <?php
    if( $auth_role === 'admin' )
    {
      echo '<li class=""><a title="" href="'.base_url("dashboard/options/").'"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>';
    }

		$link_protocol = USE_SSL ? 'https' : NULL;
		if( isset( $auth_user_id ) ){
		  echo "<li><a href='".base_url()."login/logout/admin'><i class='icon icon-share-alt'></i> Log Out</a></li>";
		}
	  ?>
    <li class=""><a title="" href="<?php echo base_url('home'); ?>" target="_blank"><i class="icon icon-play"></i> <span class="text">Visit Site</span></a></li>
  </ul>
</div>

<!--start-top-serch-->
<!-- <div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->

<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-reorder"></i> &nbsp; Menu</a>
  <ul>

    <?php
    if( $auth_role === 'admin' )
    {
      include('admin_sidebar.php');
    }
    else if( $auth_role === 'teacher' )
    {
      include('teacher_sidebar.php');
    }
    ?>

  </ul>
</div>
