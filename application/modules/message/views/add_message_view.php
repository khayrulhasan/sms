<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add Message</a> </div>
		<h1><?php echo ( isset($message_history) ) ? 'Update Existing Message ' : 'Add New Message ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php
		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}


		if( isset($message_history) )
			{
				foreach ($message_history as $message);
			}
		?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($message_history) ) ? 'Update Message : ' : 'Add New Message : ' ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('message/add_message', $attributes);
						?>
						<div class="control-group ">
							<label class="control-label">Message Title :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'span11',
									'name'				=>	'message_title',
									'placeholder'		=>	'Message Title',
									'value'				=>	( isset($message_history) ) ? $message->title : set_value('message_title'),
									);
								echo form_input($data);
								echo form_error('message_title');
								?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Message Description :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'textarea_editor span11',
									'name'				=>	'message_description',
									'placeholder'	    =>	'Message Description',
									'value'				=>	( isset($message_history) ) ? $message->description : set_value('message_description'),
									);
								echo form_textarea($data);
								echo form_error('message_description');
								?>
							</div>
						</div>
							 
							<div class="control-group ">
								<div class="pro_left_input span6">
									<label class="control-label">Author Image :</label>
									<div  class="controls">
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
										<input type="hidden" name="edited_file_name" value="<?php echo ( isset($message->image) ) ? $message->image : '';?>"/> 

										<?php if(isset($message->image)): ?>
										<div class="image_prev">
											<img style='width: 50px;height: 30px;padding-top: 8px;' src="<?php echo base_url()."public/frontend/images/teachers/". $message->image; ?>" alt="Image">
										</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="pro_right_input span6">
									<label class="control-label">Author type:</label>
									<div class="controls">
										<?php
										$options	=	array(
											'0'         		=> 'Empty',
											'Head Teacher'      => 'Head Teacher',
											'Teacher'         	=> 'Teacher',
											'Student'         	=> 'Student',
										);
										echo form_dropdown('author_type', $options, set_value('author_type'), 'class="span6"');
										echo form_error('author_type');
										?>
									</div>
								</div>
							</div>

							<div class="form-actions ">
									<?php echo ( isset($message_history) ) ? '<input type="hidden" name="message_id" value="'. $message->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($message_history) ) ? 'update_message_btn' : 'add_message_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($message_history) ) ? 'Update Message' : 'Add Message'; ?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
