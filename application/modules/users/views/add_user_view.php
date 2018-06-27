<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#"><?php echo ( isset($user_history) ) ? 'Update User ' : 'Add New User ' ?></a> </div>
		<h1><?php echo ( isset($user_history) ) ? 'Update User ' : 'Add New User ' ?></h1>
	</div>
	<div class="container-fluid">
		<?php
		$attributes = array('class' => 'form-horizontal');
		echo form_open_multipart('dashboard/users/add-user', $attributes);
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
						<h5><?php echo ( isset($user_history) ) ? 'Update User ' : 'Add New User ' ?></h5>
					</div>
					<div class="widget-content nopadding">

						<div class="control-group ">
							<label class="control-label">User Name :</label>
							<div class="controls">
								<?php
								$user_name	=	array(
									'class'				=>	'span10',
									'name'				=>	'user_name',
									'placeholder'	=>	'User Name',
									'value'				=>	( isset($user_history->username) ) ? $user_history->username : set_value('user_name'),
								);
								echo form_input($user_name);
								echo form_error('user_name');
								?>
							</div>
						</div>
						<div class="control-group ">
							<div class="pro_left_input span6">
								<label class="control-label">User Email :</label>
								<div class="controls">
									<?php
									if(isset($user_history->email)){
										$user_email	=	array(
											'readonly'			=>	'readonly',
											'class'				=>	'span8',
											'name'				=>	'user_email',
											'placeholder'		=>	'User Email',
											'value'				=>	$user_history->email,
										);

									}else{
										$user_email	=	array(
											'class'				=>	'span8',
											'name'				=>	'user_email',
											'placeholder'		=>	'User Email',
											'value'				=>	set_value('user_email'),
										);
									}
									echo form_input($user_email);
									echo form_error('user_email');
									?>
								</div>
							</div>
							<div class="pro_right_input span6">
								<label class="control-label ">User's Access Level:</label>
								<div class="controls">
									<?php
									$options	=	array(
										'1'         	=> 'Student',
										'5'           	=> 'Teacher',
										'9'         	=> 'Adminastrator',
									);
									if(isset($user_history) ){
										echo form_dropdown('access_level', $options, $user_history->auth_level, 'class="span7"');
									}else{
										echo form_dropdown('access_level', $options, set_value('access_level'), 'class="span7"');
									}

									echo form_error('access_level');
									?>
								</div>
							</div>
						</div>
						<?php
						if(!isset($user_history)){
							?>
							<div class="control-group">
								<div class="pro_left_input span6">
									<label class="control-label ">User Password :</label>
									<div class="controls  ">
										<?php
										$user_pass	=	array(
											'class'				=>	'span8',
											'name'				=>	'user_pass',
											'placeholder'	    =>	'User Password',
										);
										echo form_password($user_pass);
										echo form_error('user_pass');
										?>
									</div>
								</div>
								<div class="pro_right_input span6">
									<label class="control-label ">User Confirm Password :</label>
									<div class="controls">
										<?php

										$con_pass	=	array(
											'class'			=>	"span7",
											'name'			=>	'con_pass',
											'placeholder'	=>	'Confirm Password',
										);
										echo form_password($con_pass);
										echo form_error('con_pass');
										?>
									</div>
								</div>
							</div>

							<?php
						}
						if(isset($user_history->banned)){
							if($this->auth_user_id != $user_history->user_id){
								?>
								<div class="control-group">
									<div class="pro_right_input span6">
										<label class="control-label ">User Status:</label>
										<div class="controls">
											<?php
											$options	=	array(
												'0'         	=> 'Active',
												'1'         	=> 'Suspend',
											);
											echo form_dropdown('user_banned', $options, $user_history->banned, 'class="span7"');
											echo form_error('user_banned');
											?>
										</div>
									</div>
								</div>
								<?php
							}
						}
						?>
						<div class="form-actions ">
							<?php echo ( isset($user_history) ) ? '<input type="hidden" name="user_id" value="'. $user_history->user_id .'" />' : ''; ?>
							<input name="<?php echo ( isset($user_history) ) ? 'update_user_btn' : 'add_user_btn' ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($user_history) ) ? 'Update' : 'Add' ?>" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
