<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add News & Event</a> </div>
		<h1><?php echo ( isset($news_event_history) ) ? 'Update Existing News & Event ' : 'Add News & Event ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php
		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}


		if( isset($news_event_history) )
			{
				foreach ($news_event_history as $news_event);
			}
		?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($news_event_history) ) ? 'Update News & Event : ' : 'Add News & Event : ' ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('news_event/add_news_event', $attributes);
						?>
						<div class="control-group ">
							<label class="control-label">News & Event Title :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'span11',
									'name'				=>	'news_event_title',
									'placeholder'	=>	'News & Event Title',
									'value'				=>	( isset($news_event_history) ) ? $news_event->title : set_value('news_event_title'),
									);
								echo form_input($data);
								echo form_error('news_event_title');
								?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">News & Event Description :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'textarea_editor span11',
									'name'				=>	'news_event_description',
									'placeholder'	    =>	'News & Event Description',
									'value'				=>	( isset($news_event_history) ) ? $news_event->description : set_value('news_event_description'),
									);
								echo form_textarea($data);
								echo form_error('news_event_description');
								?>
							</div>
							 
							<div class="control-group ">
								<div class="span5">
									<label class="control-label">News & Event Image :</label>
									<div class="controls">

										<?php
										$data	=	array(
											'class'				=>	'span9',
											'name'				=>	'image',
											'value'				=>	set_value('image'),
											);
										echo form_upload($data);
										//echo '<button type="submit" class="btn btn-primary do_upload">add</button>';
										echo form_error('image');
										?>
										<input type="hidden" name="edited_file_name" value="<?php echo ( isset($news_event->image) ) ? $news_event->image : '';?>"/> 
									</div>
									
								</div>

								<?php if(isset($news_event->image)): ?>
								<div class="span7">
									<img style='width: 50px;height: 30px;padding-top: 8px;' src="<?php echo base_url()."public/frontend/images/events/". $news_event->image; ?>" alt="Event Image">
								</div>
								<?php endif; ?>
							</div>

							<div class="form-actions ">
									<?php echo ( isset($news_event_history) ) ? '<input type="hidden" name="news_event_id" value="'. $news_event->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($news_event_history) ) ? 'update_news_event_btn' : 'add_news_event_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($news_event_history) ) ? 'Update News & Event' : 'Add News & Event'; ?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
