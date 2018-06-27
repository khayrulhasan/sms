<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Profile</a> </div>
		<h1>My Profile</h1>
	</div>
	<div class="container-fluid">
		<?php
		if( isset( $validation_errors ) ){
			echo '<div class="alert alert-danger fade in">'. $validation_errors . '</div>';
		}

		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		?>
		<div class="row-fluid">
			<div class="span9">
				<div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">Details</a></li>
              <li><a data-toggle="tab" href="#tab3">Update</a></li>
            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="tab1" class="tab-pane active profile-tab">

								<div class="span4">
									<h5>Username</h5>
									<span><?php echo (isset($profile->full_name)) ? $profile->full_name : $auth_username; ?></span>
								</div>

								<div class="span4">
									<h5>Email</h5>
									<span><?php echo $auth_email; ?></span>
								</div>

								<div class="span4">
									<h5>Contact Number</h5>
									<span><?php echo get_user_contact($auth_email); ?></span>
								</div>

								<div class="span4 new">
									<h5>Level</h5>
									<span><?php echo ( $user->auth_level == 9 ) ? 'Admin' : 'Teacher'; ?></span>
								</div>

								<div class="span4">
									<h5>Last Login</h5>
									<span><?php echo $user->last_login; ?></span>
								</div>

								<div class="span4">
									<h5>Created at</h5>
									<span><?php echo $user->created_at; ?></span>
								</div>

								<div class="span10 new">
									<h5>Address</h5>
									<span><?php echo get_user_address($auth_user_id); ?></span>
								</div>

								<div class="span10 new">
									<h5>BIO</h5>
									<span><?php echo (isset($profile->bio)) ? $profile->bio : 'Empty'; ?></span>
								</div>
            </div>
            <div id="tab3" class="tab-pane">
							<!-- update form -->
							<?php
							// $attributes = array('class' => 'form-horizontal')
							echo form_open('dashboard/profile/add_profile');
							?>
								<div class="control-group ">
									<label class="control-label">Name:</label>
									<div class="controls">
										<?php
										$name	=	array(
											'class'				=>	'span12',
											'name'				=>	'full_name',
											'placeholder'	=>	'Full Name',
											'value'				=>	( isset($profile->full_name) ) ? $profile->full_name : ''
										);
										echo form_input($name);
										echo form_error('full_name');
										?>
									</div>
								</div>

								<div class="control-group ">
									<label class="control-label">Contact:</label>
									<div class="controls">
										<?php
										$name	=	array(
											'class'				=>	'span12',
											'name'				=>	'contact',
											'placeholder'	=>	'Contact Number',
											'value'				=>	$profile->phone
										);
										echo form_input($name);
										echo form_error('contact');
										?>
									</div>
								</div>

								<div class="control-group ">
									<label class="control-label">Address:</label>
									<div class="controls">
										<?php
										$name	=	array(
											'class'				=>	'span12',
											'name'				=>	'address',
											'placeholder'	=>	'Address',
											'value'				=>	( isset($profile->address) ) ? $profile->address : ''
										);
										echo form_textarea($name);
										echo form_error('address');
										?>
									</div>
								</div>

								<div class="control-group ">
									<label class="control-label">BIO:</label>
									<div class="controls">
										<?php
										$name	=	array(
											'class'				=>	'span12',
											'name'				=>	'bio',
											'placeholder'	=>	'Say more about you...',
											'value'				=>	( isset($profile->bio) ) ? $profile->bio : ''
										);
										echo form_textarea($name);
										echo form_error('bio');
										?>
									</div>
								</div>

								<div class="control-group">
									<button class="btn btn-primary" type="submit" name="button">Update</button>
								</div>
							</form>


            </div>
          </div>
        </div>
			</div>

			<div class="span3">
				<div class="widget-box">
          <div class="widget-title">
						<span class="icon"><i class="fa icon-cloud"></i></span>
						<h5>Upload Image</h5>
					</div>

					<div class="widget-content">
						<div class="image-content">
							<?php echo get_user_avartar($auth_user_id); ?>
							<hr>
							<form action="<?php echo base_url('dashboard/profile/upload'); ?>" enctype="multipart/form-data" method="post" id="profileImageUploadform">
								<div class="control-group">
									<input type="file" name="image" required="required">
									<button class="btn btn-primary" type="submit">UPLOAD</button>
								</div>
							</form>
							<?php
							if( $this->session->flashdata('upload_failed') ){
								echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('upload_failed') . '</div>';
							}
							?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
