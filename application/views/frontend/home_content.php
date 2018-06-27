


    <div id="slideshow-tabs">
        <div id="panel-tabs" class="clearfix">
            <ul class="nav-tabs-slideshow">
              <?php foreach ($sliders as $key => $value):?>
                <li><a href="#<?php echo $value->image; ?>"><strong><?php echo $value->title; ?></strong><br />
                    <span><?php echo $value->description; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php foreach ($sliders as $key => $value):?>
		<div class="ui-tabs-panel" id="<?php echo $value->image; ?>" style="background:url(<?php echo base_url('public/frontend/images/slider')."/".$value->image; ?>) no-repeat 50% 0">
            <div class="tabs-blur" style="background:url(<?php echo base_url('public/frontend/images/slider')."/".$value->image; ?>) no-repeat 50% 0">
            </div>
            <div class="tabs-container">
            </div>
        </div>
    	<?php endforeach; ?>
    </div>
    <div id="content-container">
        <div id="content" class="clearfix">
            <div id="banner-homepage">
                <a href="#"><img src="<?php echo base_url(); ?>public/frontend/images/img-2.jpg" alt="" /></a>
            </div>
            <div id="main-content">
            	<?php if(get_head_teacher_message()):?>
					<?php foreach (get_head_teacher_message() as $value):?>
	                <article id="intro">
	                    <h1><?php echo $value->title; ?></h1>
						<hr />
	                    <figure>
							<img src="<?php echo base_url('public/frontend/images/teachers')."/".$value->image;?>" alt="Chairman photo" />
						</figure>
	                    <p>	<?php echo $value->description; ?>

						</p>
	                </article>
	            	<?php endforeach; ?>
	            <?php endif; ?>

                <div id="sidebar-homepage-newsEvent" class="sidebar-homepage">
					<h1>News & Events 	<a href="<?php echo base_url('frontend/news_events	') ?>">Read More</a></h1>
					<hr />
					<div class="news-group clearfix">
						<?php if(get_news_event()): ?>
						<?php foreach (get_news_event(3) as $key => $value):?>
						<article class="news-container static-page">
							<figure>
								<img style ="height: 200px; width: 100%;"src="<?php echo base_url('public/frontend/images/events')."/".$value->image;?>" data-retina="images/events/event1.jpg" alt="">
							</figure>
							<a href="#" class="link-comment">4</a>
							<header>
								<p><a href="<?php echo base_url('frontend/news-event')."/".$value->id; ?>" rel="category tag"><?php echo substrwords($value->title,30); ?></a></p>
								<time datetime="2013-11-12">
									<?php 
								 		$date = date_create($value->create_at);
								 		echo date_format($date,'M d, Y'); 
								 	?>
								 </time>
							</header>
							<p><?php echo substrwords($value->description, 100); ?></p>
						</article>
						<?php endforeach; ?>
						<?php endif; ?>

					</div>
                </div>


			<div id="tabs-content-bottom">
                <div class="ui-tabs-panel clearfix" id="panel-1">
                    <ul id="nav-sidebar-bottom" class="clearfix">
                        <li><a href="#" class="clearfix">
                            <figure><img src="<?php echo base_url(); ?>public/frontend/images/icon-sidebar-1.png" alt="Contact Us" /></figure>
                            <strong class="title-nav-sidebar">Contact Us Now</strong>
                            <strong>Phone:</strong> +62 384856, +62 5456789 <strong>Fax:</strong> +62 45677896
                            </a>
						</li>
                        <li><a href="#" class="clearfix">
                            <figure><img src="<?php echo base_url(); ?>public/frontend/images/icon-sidebar-2.png" alt="Location" /></figure>
                            <strong class="title-nav-sidebar">Location</strong>
                            Click here to get direction to our campus location by bus or train
                            </a>
						</li>
                        <li><a href="#" class="clearfix">
                            <figure><img src="<?php echo base_url(); ?>public/frontend/images/icon-sidebar-3.png" alt="Location" /></figure>
                            <strong class="title-nav-sidebar">Live Chat</strong>
                            Talk with our Customer Service or our student and alumni
                            </a>
						</li>
                        <li><a href="#" class="clearfix">
                            <figure><img src="<?php echo base_url(); ?>public/frontend/images/icon-sidebar-2.png" alt="Location" /></figure>
                            <strong class="title-nav-sidebar">Location</strong>
                            Click here to get direction to our campus location by bus or train
                            </a>
						</li>
                    </ul>
                </div>

            </div>

			</div>

            <div id="sidebar-homepage-right" class="sidebar-homepage">

				<aside class="widget-container">
					<div class="widget-wrapper clearfix">
						<?php echo (get_two_message())?'<h3 class="widget-title">Message</h3>':''; ?>
							<ul class="menu news-sidebar message-teachers">
							<?php if(get_two_message()): ?>
								<?php foreach (get_two_message() as $single_message):?>
									<li class="clearfix">
										<img src="<?php echo base_url('public/frontend/images/teachers')."/".$single_message->image;?>" class="imgframe alignleft" />
										<h4><a href="#"><?php echo $single_message->title; ?></a></h4>
										<span class="date-news">
											<?php 
										 		$date = date_create($single_message->create_at);
										 		echo date_format($date,'M d, Y'); 
										 	?>
									 	</span>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>
							</ul>
					</div>
				</aside>


				<aside class="widget-container">
					<div class="widget-wrapper clearfix">
						<h3 class="widget-title">Notice</h3>
						<ul class="menu event-sidebar notice">
							<?php
							$notices = get_all_data('notice', 5);
							foreach ($notices as $notice) {
								$publish_date = $notice->date;
								$short_description = substrwords($notice->description);
								date_default_timezone_set("Asia/Dhaka");
								$time = strtotime($notice->date);
								echo '
								<li class="clearfix">
									<div class="event-date-widget">
										<strong>'.date('d', $time).'</strong>
										<span>'.date('M', $time).'</span>
									</div>
									<div class="event-content-widget">
										<article>
											<h4><a href="'.base_url('frontend/notices/'.$notice->id).'">'.$notice->notice_title.'</a></h4>
											<p>'.date('F d, Y', $time).'<br />
												'.$short_description.'
											</p>
											<em>'.get_username_by_id($notice->added_by).'</em>
										</article>
									</div>
								</li>
								';
							}
							?>

							<a href="<?php echo base_url('frontend/notices'); ?>" class="read-more">Read More</a>
						</ul>
					</div>
				</aside>

				<?php 
				// For Gallary Image Query from Uploads Directory
				$picture = preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/"));
				$all_image = array_filter($picture, function($v) {return stristr($v, '_thumb');}); 
				if($all_image){

				?>
                <aside id="gw_gallery-5" class="widget-container widget_gw_gallery">
					<div class="widget-wrapper clearfix">
						<h3 class="widget-title">Photo Gallery</h3>
						<script type="text/javascript">
							jQuery(document).ready(function($){
								$("#gw_gallery-5-slide").flexslider({
									animation: "slide",
									animationLoop: false,
									pauseOnAction: true
								});
							});
						</script>
						<div id="gw_gallery-5-slide" class="flexslider">
							<ul class="slides">
							 <?php foreach ($all_image as $thumb_image) { ?>
								<li>

									<div class="slides-image">
										<a href="<?php echo base_url('uploads')."/".$thumb_image;?>" data-rel="prettyPhoto[pp-gw_gallery-5]"><img src="<?php echo base_url('uploads')."/".$thumb_image;?>" alt="Beauty in Green"  data-retina="images/img-9-retina.jpg" /></a>
									</div>
									<!-- <h4><a href="<?php //echo base_url(); ?>public/frontend/images/img-9-retina.jpg" data-rel="prettyPhoto[pp-gw_gallery-5-slide]">Things you can bring on Library</a></h4> -->
								</li>
							<?php } ?>
							</ul>
						</div>
					</div>
				</aside>

				<?php } ?>



            </div>
        </div>
    </div>
