
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#"><?php echo ( isset($class_history) ) ? 'Update class' : 'Add class' ?></a>
    </div>
    <h1><?php echo ( isset($class_history) ) ? 'Update Class' : 'Add Class' ?></h1>
  </div>

  <div class="container-fluid">
		<?php

		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		if( isset($class_history) )
		{
			// echo "<pre>"; var_dump($class_history);
			foreach ($class_history as $class);
		}
		// echo $class->category;
		?>
		<?php //echo $class->class_id; ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($class_history) ) ? 'Update Class: ' : 'Add Class: '; ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('dashboard/class/add', $attributes);
  						?>
              <div class="control-group">
                <div class="span6">
                  <label class="control-label">Class :</label>
                  <div class="controls">

                    <?php
                      $options = get_class_name();
                      if( isset($class_history) )
                      {
                        echo form_dropdown('class_id', $options, $class->class_id, 'class="span9"');
                      }
                      else
                      {
                        echo form_dropdown('class_id', $options, set_value('class_id'), 'class="span9"');
                      }
                      echo form_error('class_id');
                    ?>

                  </div>
                </div>

                <div class="span6">
                  <label class="control-label">Teacher :</label>
                  <div class="controls">
               

                    <select name="teacher_id" class="span10">
                      <?php
                      if( ! empty($teachers) ){
                        echo '<option value="0">Empty</option>';
                        foreach ($teachers as $teacher) {
                          $teacher_name = $teacher->first_name .' '. $teacher->last_name.' ('.get_subject($teacher->subject_id)[0]->subject_name.')';
                          $selected = ( isset($class->teacher_id) ) ? ( $class->teacher_id == $teacher->id ) ? 'selected' : '' : '';

                          echo '<option value="'. $teacher->id .'" '. $selected .'>' . $teacher_name . '</option>';
                        }
                      }
                      else {
                        echo '<option value="0" selected>Empty</option>';
                      }
                      ?>
                    </select>
                    <?php echo form_error('teacher_id'); ?>
                  </div>
                </div>
              </div>

              <div class="control-group">
  							<label class="control-label">Note :</label>
  							<div class="controls">
  								<?php
  								$data	=	array(
  									'class'				=>	'textarea_editor span11',
  									'name'				=>	'note',
  									'placeholder'	    =>	'Class Description goes here...',
  									'value'				=>	( isset($class->note) ) ? $class->note : set_value('note'),
  									);
  								echo form_textarea($data);
  								echo form_error('note');
  								?>
  							</div>
  					  </div>


              <div class="form-actions ">
								<?php echo ( isset($class_history) ) ? '<input type="hidden" name="class_table_id" value="'. $class->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($class_history) ) ? 'update_class_btn' : 'add_class_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($class_history) ) ? 'Update' : 'Add'; ?>" />
							</div>


            </form>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>

</div>
