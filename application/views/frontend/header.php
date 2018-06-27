<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo ( isset($layout_title) ) ? $layout_title : 'School Management System - SMS'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  echo ( isset($meta_description) ) ? '<meta name="description" content="'. $meta_description .'">' : '';
  ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/frontend/style/style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/frontend/style/prettyPhoto.css" />
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700,300,900' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/frontend/style/ticker-style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/frontend/style/stylemobile.css" />
	<!-- <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>public/frontend/style/mobilenavigation.css" /> -->
	<script src="<?php echo base_url(); ?>public/frontend/script/modernizr.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>public/frontend/script/jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/frontend/script/jquery-ui.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>public/frontend/script/jquery.flexslider.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>public/frontend/script/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>public/frontend/script/jquery.retina.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>public/frontend/script/jquery.ticker.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function (){
		// news ticker
		$('#js-news').ticker();

        $(window).scroll(function () {
            if ($(document).scrollTop() <= 40) {
                $('#header-full').removeClass('small');
                $('.tabs-blur').removeClass('no-blur');
                $('#main-header').removeClass('small');
				$('#bottom-news-ticker').removeClass('disnone');

            } else {
                $('#header-full').addClass('small');
                $('.tabs-blur').addClass('no-blur');
                $('#main-header').addClass('small');
				$('#bottom-news-ticker').addClass('disnone');
            }
        });

        $("a[data-rel^='prettyPhoto']").prettyPhoto({
			default_width: 600,
			default_height: 420,
			social_tools: false
		});
        $('#slideshow-tabs').tabs({ show: { effect: "fade", duration: 200 }, hide: { effect: "fade", duration: 300 } });
        $('.slider-tabs.flexslider').flexslider({
            animation: "slide",
            pauseOnAction: true,
        });
		$('a[data-rel]').each(function() {
			$(this).attr('rel', $(this).data('rel'));
		});
		$('img[data-retina]').retina({checkIfImageExists: true});
		$(".open-menu").click(function(){
		    $("body").addClass("no-move");
		});
		$(".close-menu, .close-menu-big").click(function(){
		    $("body").removeClass("no-move");
		});
	});
	</script>
</head>

<body <?php echo (isset($body_class)) ? 'class="home"' : ''; ?>>

	<header id="main-header" class="clearfix">
        <div id="header-full" class="clearfix">
            <div id="header" class="clearfix">
                <a href="#nav" class="open-menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				</a>
                <a href="<?php echo base_url('/'); ?>" id="logo"><img src="<?php echo base_url(); ?>public/frontend/images/logo.png" data-retina="images/logo-retina.png" alt="School Fun - WordPress Theme" /></a>
                <aside id="header-content">
                    <ul id="nav-header">
                        <li><a href="<?php echo base_url('dashboard/teacher'); ?>">Teacher</a></li>
                        <?php 
                        	if($this->auth_user_id){
                        		echo '<li><a  href="'.base_url('login/logout').'" >Logout</a></li>';
                        	}else{
                        	
                        		echo '<li><a class="js-open-modal" href="#" data-modal-id="popup">Student</a></li>';
                        	}
                         ?>
                    </ul>
					<form method="post" action="#" id="searchform">
						<div>
							<input type="text" name="search" class="input" placeholder="Search..." />
							<input type="submit" name="submitsearch" class="button" value="Search" />
						</div>
					</form>			
                </aside>
            </div>
        </div>
        <nav id="nav" class="clearfix">
            <a href="#" class="close-menu-big">Close</a>
            <div id="nav-container">
                <a href="#" class="close-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
								<?php
		            $attr = array(
		              'table_name'          => 'sms_menu',
		              'menu_cat_ID'         =>  1,
		              'ul_class'            => "",
		              'ul_ID'               => "nav-main",
		              'ul_attr'             => '',
		              'li_class'            => "item-list",
		              'li_if_submenu_after' => "<i class='fa fa-angle-down'></i>",
		              'li_if_submenu_class' => "",
		              'ul_submenu_class'    => "",
		              'ul_submenu_ID'       => "secondary",
		            );
		            echo $this->menu->generateFrontendMenu($attr);
		            ?>
                <!-- <ul id="nav-main">
                    <li class="current-menu-item"><a href="index-2.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="event.html">Event</a></li>
                    <li><a href="testimonial.html">Testimonial</a></li>
                    <li><a href="team.html">Teacher</a></li>
                    <li><a href="#">Other</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul> -->
                <a href="#" id="button-registration">Get In Touch</a>
            </div>
        </nav>
			<div id="bottom-news-ticker">
				<ul id="js-news" class="js-hidden">
					<?php
					// echo "<pre>", var_dump(get_all_data('notice'));
					$notices = get_all_data('notice');
					foreach ($notices as $notice) {
						echo '<li class="news-item"><a href="'.base_url('frontend/notices/'.$notice->id).'">'.$notice->notice_title.'</a></li>';
					}
					?>
				</ul>
			</div>
    </header>



	<!-- For Login Modal -->
	<?php
	if( ! isset( $auth_user_id ) ){
	?>
	        <?php
	        if( ! isset( $on_hold_message ) ){
	          ?>
	 			<div id="popup" class="modal-box">  
				  <header>
				  		<a href="#" class="js-modal-close close">×</a>
				     <h1> Student Login</h1>
				  </header>
				  <div class="modal-body">
				  		    <?php echo form_open( 'login/ajax_attempt_login', array( 'class' => 'ajax-login-form ' ) ); ?>
			                    <input type="text" name="login_string" id="login_string" placeholder="Username">
			                    <input type="password" name="login_pass" id="login_pass" placeholder="Password">

			                	<input type="hidden" id="max_allowed_attempts" value="<?php echo config_item('max_allowed_attempts'); ?>" />
			                    <input type="hidden" id="mins_on_hold" value="<?php echo ( config_item('seconds_on_hold') / 60 ); ?>" />
			                    <input type="submit" class="login loginmodal-submit" name="submit" value="Login" id="submit_button"  />
			              </form>
				  </div>
				  <footer>
				      <!-- <a href="<?php // echo base_url('customers/register');?>">Register</a> - <a href="<?php // echo base_url('login/recover');?>">Forgot Password</a> -->
				  </footer>
				</div>
	          <?php
	        }
	        else{
	          // EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
	          echo '
	            <div class="block-container">
	              <p class="normal_text head-text">
	                <strong>Excessive Login Attempts</strong>
	              </p>
	              <p class="normal_text">
	                You have exceeded the maximum number of failed login<br />
	                attempts that this website will allow.
	              <p>
	              <p class="normal_text">
	                Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
	              </p>
	              <p class="normal_text">
	                Please use the <a href="login/recover">Account Recovery</a> after ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes has passed,<br />
	                or contact us if you require assistance gaining access to your account.
	              </p>
	            </div>
	          ';
	        }
	    }
	  ?>





