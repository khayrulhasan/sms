<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add Slider</a> </div>
		<h1><?php echo ( isset($slider_history) ) ? 'Update Existing Slider: ' : 'Add New Slider: ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php

		// echo "<pre>";
		// var_dump($slider_history);


		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}


		if( isset($slider_history) )
		{
			// echo "<pre>"; var_dump($notice_history);
			foreach ($slider_history as $slider);
		}
		?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($slider_history) ) ? 'Update Slider: ' : 'Add Slider: ' ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('sliders/add_slider', $attributes);
						?>
						<div class="control-group ">
							<label class="control-label">Slider Title :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'span11',
									'name'				=>	'slider_title',
									'placeholder'	=>	'Slider Title',
									'value'				=>	( isset($slider_history) ) ? $slider->title : set_value('slider_title'),
									);
								echo form_input($data);
								echo form_error('slider_title');
								?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Slider Description :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'textarea_editor span11',
									'name'				=>	'slider_description',
									'placeholder'	    =>	'Slider Description',
									'value'				=>	( isset($slider_history) ) ? $slider->description : set_value('slider_description'),
									);
								echo form_textarea($data);
								echo form_error('slider_description');
								?>
							</div>
							 
							<div class="control-group ">
								<div class="span5">
									<label class="control-label">Slider Image :</label>
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
										<input type="hidden" name="edited_file_name" value="<?php echo ( isset($slider->image) ) ? $slider->image : '';?>"/> 
									</div>
									
								</div>

								<?php if(isset($slider->image)): ?>
								<div class="span7">
									<img style='width: 50px;height: 30px;padding-top: 8px;' src="<?php echo base_url()."public/frontend/images/slider/". $slider->image; ?>" alt="Slider Image">
								</div>
								<?php endif; ?>
							</div>

							<div class="form-actions ">
									<?php echo ( isset($slider_history) ) ? '<input type="hidden" name="slider_id" value="'. $slider->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($slider_history) ) ? 'update_slider_btn' : 'add_slider_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($slider_history) ) ? 'Update Slider' : 'Add Slider'; ?>" />
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
