
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#"><?php echo ( isset($teacher_history) ) ? 'Update teacher' : 'Add teacher' ?></a>
    </div>
    <h1><?php echo ( isset($teacher_history) ) ? 'Update Teacher' : 'Add Teacher' ?></h1>
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
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($teacher_history) ) ? 'Update Teacher: ' : 'Add Teacher: '; ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('teachers/add', $attributes);
  						?>
              <div class="control-group">
                <div class="span6">
                <label class="control-label">Email Address:</label>
                <div class="controls">
                    <select name="user_id" class="span9">
                    <?php
                      // when update select prevous value
                        foreach ($teacher_from_user_table as $key=>$value) {

                          $selected = ( isset($teacher_history->user_id) ) ? ($teacher_history->user_id == $value->user_id ) ? 'selected' : '' : '';

                          echo '<option value="'. $value->user_id .'" '. $selected .'>' . $value->email . '</option>';
                        }
                        echo form_error('user_id');
                      ?>
                      </select>
                </div>
                </div>
              </div>
              <div class="control-group">
                <div class="span6">
    							<label class="control-label">First Name :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'first_name span9',
    									'name'				=>	'first_name',
    									'placeholder'	=>	'Teacher First Name',
    									'value'				=>	( isset($teacher_history->first_name) ) ? $teacher_history->first_name : set_value('first_name'),
    									);
    								echo form_input($data);
    								echo form_error('first_name');
    								?>
                  </div>
    						</div>

                <div class="span6">
    							<label class="control-label">Last Name :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'last_name span9',
    									'name'				=>	'last_name',
    									'placeholder'	=>	'Teacher Last Name',
    									'value'				=>	( isset($teacher_history->last_name) ) ? $teacher_history->last_name : set_value('last_name'),
    									);
    								echo form_input($data);
    								echo form_error('last_name');
    								?>
                  </div>
    						</div>

  						</div>

              <div class="control-group">
  							<label class="control-label">Address:</label>
  							<div class="controls">
  								<?php
  								$data	=	array(
  									'class'				=>	'textarea_editor span10',
  									'name'				=>	'teacher_address',
  									'placeholder'	    =>	'Present / Permanent Address',
  									'value'				=>	( isset($teacher_history->teacher_address) ) ? $teacher_history->teacher_address : set_value('teacher_address'),
  									);
  								echo form_textarea($data);
  								echo form_error('teacher_address');
  								?>
  							</div>
  					  </div>

              <div class="control-group">

								<div class=" span6">
									<label class="control-label ">Gender :</label>
									<div class="controls">
											<?php
                      $options	=	array(
    										'0'  => 'Male',
    										'1'  => 'Female',
    									);
    									if( isset($teacher_history) )
                      {
    										echo form_dropdown('gender', $options, $teacher_history->gender, 'class="span9"');
    									}
                      else
                      {
    										echo form_dropdown('gender', $options, set_value('gender'), 'class="span9"');
    									}
                      echo form_error('gender');
                      ?>
									</div>
								</div>

                <div class="span6">
									<label class="control-label ">Subject :</label>
									<div class="controls">
                    <select name="subject_name" class="span9">
											<?php
											if( ! empty($subject_lists) ){
												echo '<option value="0">Empty</option>';
												foreach ($subject_lists as $subject) {
                          $selected = ( isset($teacher_history->subject_id) ) ? ( $teacher_history->subject_id == $subject->subject_id ) ? 'selected' : '' : '';

													echo '<option value="'. $subject->subject_id .'" '. $selected .'>' . $subject->subject_name . '</option>';
												}
											}
											else {
												echo '<option value="0" selected>Empty</option>';
											}
											?>
										</select>
										<?php echo form_error('subject_name'); ?>
									</div>
								</div>

							</div>


              <div class="form-actions ">
								<?php echo ( isset($teacher_history) ) ? '<input type="hidden" name="teacher_id" value="'. $teacher_history->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($teacher_history) ) ? 'update_teacher_btn' : 'add_teacher_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($teacher_history) ) ? 'Update' : 'Add'; ?>" />
							</div>
            </form>




				  </div>
			  </div>
		  </div>
	  </div>
  </div>

</div>
