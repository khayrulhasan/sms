<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#"><?php echo ( isset($page_history) ) ? 'Update Page ' : 'Add New Page ' ?></a> </div>
		<h1><?php echo ( isset($page_history) ) ? 'Update Page ' : 'Add New Page ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php
		$attributes = array('class' => 'form-horizontal');
		echo form_open_multipart('dashboard/pages/add-page', $attributes);
		?>
		<?php
		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title">
						<h5><?php echo ( isset($page_history) ) ? 'Update Page ' : 'Add New Page ' ?></h5>
					</div>
					<div class="widget-content nopadding">
						<div class="control-group ">
							<label class="control-label">Page Title :</label>
							<div class="controls">
								<?php
								$page_title	=	array(
									'class'				=>	'span10',
									'name'				=>	'page_title',
									'placeholder'	=>	'Page Title',
									'value'				=>	( isset($page_history->title) ) ? $page_history->title : set_value('page_title'),
								);
								echo form_input($page_title);
								echo form_error('page_title');
								?>
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label">Page Description :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'textarea_editor span10',
									'name'				=>	'page_description',
									'placeholder'	    =>	'Page Description',
									'value'				=>	( isset($page_history->description) ) ? $page_history->description : set_value('page_description'),
									);
								echo form_textarea($data);
								echo form_error('page_description');
								?>
							</div>
						</div>
						<div class="control-group">
							<div class="pro_left_input span6">
								<label class="control-label ">Page Position :</label>
								<div class="controls">
									<?php
									$data	=	array(
										'class'				=>	'span8',
										'name'				=>	'page_position',
										'placeholder' =>	'Page Position',
										'value'				=>	( isset($page_history->position) ) ? $page_history->position : 0,
										);
									echo form_input($data);
									echo form_error('page_position');
									?>
								</div>
							</div>
							<!-- <div class="pro_right_input span6">
								<label class="control-label ">Featured Image :</label>
								<div class="controls">
									<div class="input-append">
										<?php
										/*$data	=	array(
											'class'				=>	'span8 product_image',
											'id'					=>	'multiple_file',
											'name'				=>	'userfile',
											'value'				=>	set_value('userfile'),
											);
										echo form_upload($data);
										echo form_error('product_image');*/
										?>
									</div>
									<?php //echo form_error('product_price'); ?>
								</div>
							</div> -->

						</div>

						<div class="form-actions ">
							<?php echo ( isset($page_history) ) ? '<input type="hidden" name="page_id" value="'. $page_history->id .'" />' : ''; ?>
							<input name="<?php echo ( isset($page_history) ) ? 'update_page_btn' : 'add_page_btn' ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($page_history) ) ? 'Update' : 'Add' ?>" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
