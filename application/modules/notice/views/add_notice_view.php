
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#"><?php echo ( isset($notice_history) ) ? 'Update notice' : 'Add notice' ?></a>
    </div>
    <h1><?php echo ( isset($notice_history) ) ? 'Update Notice' : 'Add Notice' ?></h1>
  </div>

  <div class="container-fluid">
		<?php

		if( $this->session->flashdata('success_message') ){
			echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
		}
		elseif( $this->session->flashdata('error_message') ){
			echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
		}
		if( isset($notice_history) )
		{
			// echo "<pre>"; var_dump($notice_history);
			foreach ($notice_history as $notice);
		}
		// echo $notice->category;
		?>
		<?php //echo validation_errors(); ?>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
						<h5><?php echo ( isset($notice_history) ) ? 'Update Notice: ' : 'Add Notice: '; ?></h5>
					</div>
					<div class="widget-content nopadding">
						<?php
						$attributes = array('class' => 'form-horizontal');
						echo form_open_multipart('notice/add', $attributes);
  						?>

              <div class="control-group">

                <div class="span11">
    							<label class="control-label">Title :</label>
    							<div class="controls">
    								<?php
    								$data	=	array(
    									'class'				=>	'notice_title span12',
    									'name'				=>	'notice_title',
                      'placeholder'	=>	'Notice Title',
    									'required'	  =>	'required',
    									'value'				=>	( isset($notice->notice_title) ) ? $notice->notice_title : set_value('notice_title'),
    									);
    								echo form_input($data);
    								echo form_error('notice_title');
    								?>
                  </div>
    						</div>

  						</div>


              <div class="control-group">

                <div class="span6">
                  <label class="control-label">Attach File : </label>
                  <div class="controls">
										<?php
										$data	=	array(
											'class'				=>	'span8 attach_file',
											'id'					=>	'file',
											'name'				=>	'userfile',
											'value'				=>	set_value('userfile')
											);
										echo form_upload($data);
										echo form_error('userfile');

                    // already uploaded
                    $img = '';
                    if( ! empty( $notice->upload ) )
                    {
                      $file = explode('.', $notice->upload);
                      if( in_array('pdf', $file) )
                        $img = base_url('public/backend/img/'.'pdf.png');
                      elseif ( in_array('docx', $file) ) {
                        $img = base_url('public/backend/img/'.'doc.png');
                      }
                      elseif ( in_array('doc', $file) ) {
                        $img = base_url('public/backend/img/'.'doc.png');
                      }
                      elseif ( in_array('xlsx', $file) ) {
                        $img = base_url('public/backend/img/'.'xls.png');
                      }
                      elseif ( in_array('xls', $file) ) {
                        $img = base_url('public/backend/img/'.'xls.png');
                      }
                      elseif ( in_array('csv', $file) ) {
                        $img = base_url('public/backend/img/'.'csv.png');
                      }
                      else{
                        $img = base_url("uploads/".$notice->upload);
                      }
                    }
                    //echo $img;
                    echo $img = ( ! empty($img) ) ? '<img width="30" height="30" src="'. $img .'" alt="image" />' : '-';

										?>
									</div>
                  <input type="hidden" name="edited_file_name" value="<?php echo ( isset($notice->upload) ) ? $notice->upload : ''; ?>">
                </div>

                <div class="span6">
                  <label class="control-label">Publish Date :</label>
                  <div class="controls">
                    <?php
                    $data	=	array(
                      'class'				=>	'datepicker',
                      'name'				=>	'date',
                      'data-date'   =>  date("y-m-d"),
                      'data-date-format'				=>	'yyyy-mm-dd',
                      'placeholder'	=>	'yyyy-mm-dd',
                      'value'				=>	( isset($notice->date) ) ? $notice->date : set_value('date'),
                      );
                    echo form_input($data);
                    echo form_error('date');
                    ?>
                  </div>
                </div>

              </div>

              <div class="control-group">
  							<label class="control-label">Description :</label>
  							<div class="controls">
  								<?php
  								$data	=	array(
  									'class'				=>	'textarea_editor span11',
  									'name'				=>	'description',
  									'placeholder'	    =>	'Notice Description goes here...',
  									'value'				=>	( isset($notice->description) ) ? $notice->description : set_value('description'),
  									);
  								echo form_textarea($data);
  								echo form_error('description');
  								?>
  							</div>
  					  </div>


              <div class="form-actions ">
								<?php echo ( isset($notice_history) ) ? '<input type="hidden" name="notice_id" value="'. $notice->id .'" />' : ''; ?>
								<input name="<?php echo ( isset($notice_history) ) ? 'update_notice_btn' : 'add_notice_btn'; ?>" class="btn btn-success" type="submit" value="<?php echo ( isset($notice_history) ) ? 'Update' : 'Add'; ?>" />
							</div>


            </form>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>

</div>
