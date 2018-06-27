
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#"><?php echo ( isset($student_history) ) ? 'Update student' : 'Add student' ?></a>
    </div>
    <h1><?php echo ( isset($student_history) ) ? 'Update Student' : 'Add Student' ?></h1>
  </div>

  <div class="container-fluid">
		<?php

		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		if( isset($student_history) )
		{
			// echo "<pre>"; var_dump($student_history);
			foreach ($student_history as $student);
		}
		// echo $student->category;
		?>
		<?php //echo validation_errors(); ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($student_history) ) ? 'Update Student: ' : 'Add Student: '; ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('student/add', $attributes);
  						?>

              <div class="control-group">

                <div class="span6">
    							<label class="control-label">Name :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'name span8',
    									'name'				=>	'name',
    									'placeholder'	=>	'Student Name',
    									'value'				=>	( isset($student->name) ) ? $student->name : set_value('name'),
    									);
    								echo form_input($data);
    								echo form_error('name');
    								?>
                  </div>
    						</div>
                  <div class="span6">
                    <label class="control-label">Email Address:</label>
                    <div class="controls">
                    <select name="user_id" class="span8">
                    <?php
                      // when update select prevous value
                        foreach ($student_from_user_table as $key=>$value) {

                          $selected = ( isset($student->user_id) ) ? ($student->user_id == $value->user_id ) ? 'selected' : '' : '';

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
                  <label class="control-label">Father's Name :</label>
                  <div class="controls">
                    <?php
                    $data	=	array(
                      'class'				=>	'father_name span8',
                      'name'				=>	'father_name',
                      'placeholder'	=>	'Student Father\'s Name',
                      'value'				=>	( isset($student->father_name) ) ? $student->father_name : set_value('father_name'),
                      );
                    echo form_input($data);
                    echo form_error('father_name');
                    ?>
                  </div>
                </div>

                <div class="span6">
                  <label class="control-label">Mother's Name :</label>
                  <div class="controls">
                    <?php
                    $data	=	array(
                      'class'				=>	'mother_name span8',
                      'name'				=>	'mother_name',
                      'placeholder'	=>	'Student Mother\'s Name',
                      'value'				=>	( isset($student->mother_name) ) ? $student->mother_name : set_value('mother_name'),
                      );
                    echo form_input($data);
                    echo form_error('mother_name');
                    ?>
                  </div>
                </div>

              </div>

              <div class="control-group">

                <div class="span6">
    							<label class="control-label">Date of Birth :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'date_of_birth datepicker span8',
    									'name'				=>	'date_of_birth',
                      'data-date'   =>  date("y-m-d"),
                      'data-date-format'				=>	'yyyy-mm-dd',
                      'placeholder'	=>	'yyyy-mm-dd',
    									'value'				=>	( isset($student->date_of_birth) ) ? $student->date_of_birth : set_value('date_of_birth'),
    									);
    								echo form_input($data);
    								echo form_error('date_of_birth');
    								?>
                  </div>
    						</div>

                <div class="span6">
    							<label class="control-label">NID / Birth Certificate :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'nid_bs span8',
    									'name'				=>	'nid_bs',
    									'placeholder'	=>	'NID / Birth Certificate Number',
    									'value'				=>	( isset($student->nid_bs) ) ? $student->nid_bs : set_value('nid_bs'),
    									);
    								echo form_input($data);
    								echo form_error('nid_bs');
    								?>
                  </div>
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
    									if( isset($student_history) )
                      {
    										echo form_dropdown('gender', $options, $student->gender, 'class="span8"');
    									}
                      else
                      {
    										echo form_dropdown('gender', $options, set_value('gender'), 'class="span8"');
    									}
                      echo form_error('gender');
                      ?>
									</div>
								</div>

                <div class="span6">
									<label class="control-label ">Class :</label>
									<div class="controls">
                    <?php
                      $options = get_class_name();
                      if( isset($student_history) )
                      {
                        echo form_dropdown('class_id', $options, $student->class_id, 'class="span8"');
                      }
                      else
                      {
                        echo form_dropdown('class_id', $options, set_value('class_id'), 'class="span8"');
                      }
                      echo form_error('class_id');
                    ?>
									</div>
								</div>

							</div>

              <div class="control-group">

                <div class="span6">
									<label class="control-label ">Group :</label>
									<div class="controls">
											<?php
                      $options	=	array(
                        'Science'   => 'Science',
                        'Arts'      => 'Arts',
                        'Commerce'  => 'Commerce'
                      );
                      if( isset($student_history) )
                      {
                        echo form_dropdown('group', $options, $student->group, 'class="span8"');
                      }
                      else
                      {
                        echo form_dropdown('group', $options, set_value('group'), 'class="span8"');
                      }
                      echo form_error('group');




											// if( ! empty($class_lists) ){
											// 	echo '<option value="0">Empty</option>';
											// 	foreach ($class_lists as $class) {
                      //     $selected = ( isset($student->group) ) ? ( $student->group == $class->group ) ? 'selected' : '' : '';
                      //
											// 		echo '<option value="'. $class->group .'" '. $selected .'>' . $class->group . '</option>';
											// 	}
											// }
											// else {
											// 	echo '<option value="0" selected>Empty</option>';
											// }
											?>
										<?php echo form_error('group'); ?>
									</div>
								</div>

                <div class="span6">
                  <label class="control-label">Contact Number :</label>
                  <div class="controls">
                    <?php
                    $data	=	array(
                      'class'				=>	'contact_number span8',
                      'name'				=>	'contact_number',
                      'placeholder'	=>	'Contact Number',
                      'value'				=>	( isset($student->contact_number) ) ? $student->contact_number : set_value('contact_number'),
                      );
                    echo form_input($data);
                    echo form_error('contact_number');
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
  									'name'				=>	'address',
  									'placeholder'	    =>	'Present / Permanent Address',
  									'value'				=>	( isset($student->address) ) ? $student->address : set_value('address'),
  									);
  								echo form_textarea($data);
  								echo form_error('address');
  								?>
  							</div>
  					  </div>


              <div class="form-actions ">
								<?php echo ( isset($student_history) ) ? '<input type="hidden" name="student_id" value="'. $student->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($student_history) ) ? 'update_student_btn' : 'add_student_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($student_history) ) ? 'Update' : 'Add'; ?>" />
							</div>


            </form>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>

</div>
