<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Change Passowrd</a> </div>
		<h1>Change Password</h1>
	</div>
	<div class="container-fluid">
		<?php
		$attributes = array('class' => 'form-horizontal');
		echo form_open_multipart('dashboard/users/update-password', $attributes);
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
						<h5>Change password by email address</h5>
					</div>
					<div class="widget-content nopadding">
						<div class="control-group">
							<label class="control-label">Email Address:</label>
							<div class="controls">
								<?php
								$data[0]="Empty";
								foreach($user_lists as $row)
								{
									$data[$row->user_id] = $row->email;
								}
								echo form_dropdown('user_id', $data, set_value('user_id'), 'class="span6"');
								echo form_error('user_id');
								?>
							</select>
							<?php echo form_error('product_category'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label ">User Password :</label>
						<div class="controls  ">
							<?php
							$user_pass	=	array(
								'class'				=>	'span6',
								'name'				=>	'user_pass',
								'placeholder'	    =>	'User Password',
								'value'	    =>	set_value('user_pass'),
							);
							echo form_password($user_pass);
							echo form_error('user_pass');
							?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label ">User Confirm Password :</label>
						<div class="controls">
							<?php
							$con_pass	=	array(
								'class'			=>	"span6",
								'name'			=>	'con_pass',
								'placeholder'	=>	'Confirm Password',
								'value'	    =>	set_value('con_pass'),
							);
							echo form_password($con_pass);
							echo form_error('con_pass');
							?>
						</div>
					</div>
					<div class="form-actions">
						<input name="update_pass_btn" class="btn btn-success" type="submit" value="Update" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
