
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#"><?php echo ( isset($booklist_history) ) ? 'Update booklist' : 'Add booklist' ?></a>
    </div>
    <h1><?php echo ( isset($booklist_history) ) ? 'Update Booklist' : 'Add Booklist' ?></h1>
  </div>

  <div class="container-fluid">
		<?php

		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		if( isset($booklist_history) )
		{
			// echo "<pre>"; var_dump($booklist_history);
			foreach ($booklist_history as $booklist);
		}

		?>
		<?php //echo validation_errors(); ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($booklist_history) ) ? 'Update Booklist: ' : 'Add Booklist: '; ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('booklist/add', $attributes);
  						?>
              <div class="control-group">
								<div class="span6">
									<label class="control-label ">Book :</label>
									<div class="controls">
                    <select name="subject_name" class="span7">
                      <?php if(update_method_access_denied('booklist',$book->id,9)==FALSE){ 
                            echo '<option value="0">Empty</option>';
                          foreach (get_all_subject($this->auth_user_id) as $key => $value) {
                            $selected = ( isset($value->subject_id) ) ? ( $value->subject_id == $value->subject_id ) ? 'selected' : '' : '';

                            echo '<option value="'. $value->subject_id .'" '. $selected .'>' . $value->subject_name . '</option>';
                           }
                         }else{ 
                            echo '<option value="0">Empty</option>';
                            foreach (get_all_subject() as $key => $value) {
                              $selected = ( isset($value->subject_id) ) ? ( $value->subject_id == $value->subject_id ) ? 'selected' : '' : '';

                            echo '<option value="'. $value->subject_id .'" '. $selected .'>' . $value->subject_name . '</option>';
                              } 
                        }?>
										</select>
										<?php echo form_error('subject_name'); ?>
									</div>
								</div>

								<div class=" span6">
									<label class="control-label ">Class :</label>
									<div class="controls">
                    <?php
                      $options = get_class_name();
                      if( isset($booklist_history) )
                      {
                        echo form_dropdown('class_id', $options, $booklist->class_id, 'class="span7"');
                      }
                      else
                      {
                        echo form_dropdown('class_id', $options, set_value('class_id'), 'class="span7"');
                      }
                      echo form_error('class_id');
                    ?>
									</div>
								</div>
							</div>

              <div class="control-group">
                <div class="span12">
    							<label class="control-label">Book Title :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'span10 book_title',
    									'name'				=>	'book_title',
    									'placeholder'	=>	'Book Title',
    									'value'				=>	( isset($booklist->book_title) ) ? $booklist->book_title : set_value('book_title'),
    									);
    								echo form_input($data);
    								echo form_error('book_title');
    								?>
                  </div>
    						</div>
  						</div>


              <div class="control-group">
                <div class="span12">
    							<label class="control-label">Writter :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'span10 book_writter',
    									'name'				=>	'book_writter',
    									'placeholder'	=>	'Book Writter',
    									'value'				=>	( isset($booklist->book_writter) ) ? $booklist->book_writter : set_value('book_writter'),
    									);
    								echo form_input($data);
    								echo form_error('book_writter');
    								?>
                  </div>
    						</div>
  						</div>


              <div class="control-group">
                <div class="span6">
    							<label class="control-label">Copyright :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'span7 copyright',
    									'name'				=>	'copyright',
    									'placeholder'	=>	'Copyright',
    									'value'				=>	( isset($booklist->copyright) ) ? $booklist->copyright : set_value('copyright'),
    									);
    								echo form_input($data);
    								echo form_error('copyright');
    								?>
                  </div>
    						</div>

                <div class="span6">
    							<label class="control-label">Publisher :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'span7 publisher',
    									'name'				=>	'publisher',
    									'placeholder'	=>	'Book Publisher',
    									'value'				=>	( isset($booklist->publisher) ) ? $booklist->publisher : set_value('publisher'),
    									);
    								echo form_input($data);
    								echo form_error('publisher');
    								?>
                  </div>
    						</div>

  						</div>

              <div class="form-actions ">
								<?php echo ( isset($booklist_history) ) ? '<input type="hidden" name="booklist_id" value="'. $booklist->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($booklist_history) ) ? 'update_booklist_btn' : 'add_booklist_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($booklist_history) ) ? 'Update' : 'Add'; ?>" />
							</div>


            </form>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>

</div>
