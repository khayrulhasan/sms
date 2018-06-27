<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Add Category</a> </div>
		<h1><?php echo ( isset($cat_history) ) ? 'Update Category: ' : 'Add New Category: ' ?></h1>
	</div>
	<div class="container-fluid">

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
						<h5><?php echo ( isset($cat_history) ) ? 'Update Category: ' : 'Add Category: ' ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('category/add_category', $attributes);
						?>

						<div class="control-group ">
							<label class="control-label">Category Name :</label>
							<div class="controls">
								<?php
								$data	=	array(
									'class'				=>	'span10',
									'name'				=>	'category_name',
									'placeholder'	=>	'Category Name',
									'value'				=>	( isset($cat_history->cat_name) ) ? $cat_history->cat_name : set_value('category_name'),
									);
								echo form_input($data);
								echo form_error('category_name');
								?>
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label">Category Parent :</label>
							<div class="controls">
								<select class="product_cat_class span10" name="category_parent">
									<?php
									if( ! empty($cat_lists) ){
										echo '<option value="0">Empty</option>';
										foreach ($cat_lists as $cat) {
											$selected = ( isset($cat_history) ) ? ( $cat_history->parent == $cat->id ) ? 'selected' : '' : '';
											echo '<option value="'. $cat->id .'" '. $selected .'>' . $cat->cat_name . '</option>';
										}
									}
									else {
										echo '<option value="0" selected>Empty</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="control-group ">
							<label class="control-label">Short Description :</label>
							<div class="controls">
									<?php
									$data	=	array(
										'class'				=>	'span10',
										'name'				=>	'cat_description',
										'placeholder'	    =>	'Category Short Description',
										'value'				=>	( isset($cat_history->cat_description) ) ? $cat_history->cat_description : set_value('cat_description'),
										);
									echo form_textarea($data);
									echo  form_error('cat_description');
									?>
								</select>
							</div>
						</div>
							<br />
							<div class="form-actions ">
								<?php echo ( isset($cat_history) ) ? '<input type="hidden" name="category_id" value="'. $cat_history->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($cat_history) ) ? 'update_category_btn' : 'add_category_btn' ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($cat_history) ) ? 'Update' : 'Add' ?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
