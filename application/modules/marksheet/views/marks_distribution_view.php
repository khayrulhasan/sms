
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    </div>
    <h1>Mark Distribution</h1>
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
            <h5>Total Mark distribution</h5>
          </div>
          <div class="widget-content nopadding">
              <?php
                $attributes = array('class' => 'form-horizontal', 'style' => 'overflow: scroll');
                echo form_open_multipart('marksheet/add_or_update/', $attributes);
              ?>
              <?php if(!empty($asign_class)){ ?>
              <div class="control-group ">
                <div class="span4">
                  <label class="control-label"> Select Class : &nbsp </label>
                  <div class="controls">
                    <?php
                      foreach ($asign_class as $value) {
                      $options[$value->class_id] = get_class_name($value->class_id);
                      }
                      if( isset($search_data['class_id']) )
                      {
                        echo form_dropdown('class_id', $options, $search_data['class_id'], 'class="span7 ajax_trigger_p"');
                      }
                      else
                      {
                        echo form_dropdown('class_id', $options, set_value('class_id'), 'class="span7 ajax_trigger_p"');
                      }
                    ?>
                  </div>
                </div>

                <?php //var_dump($get_subject) ?>

                <div class="span4">
                  <label class="control-label span4 ">Select Subject :</label>
                  <div class="controls">

                  <?php
                       foreach ($get_subject as $subject) {
                      $asign_subject[$subject->subject_id] = $subject->subject_name;
                      }
                      if( isset($search_data['subject_id']) )
                      {
                        echo form_dropdown('subject_id', $asign_subject, $search_data['subject_id'], 'class="span8" id="subject_ajax_output"');
                      }
                      else
                      {
                        echo form_dropdown('subject_id', $asign_subject, set_value('subject_id'), 'class="span8" id="subject_ajax_output"');
                      }
                   ?>
                  </div>
                </div>

                <div class="span1">
                  <div class="controls span2">
                    <input class="btn btn-primary" type="submit" name="submit" value="Go">
                  </div>

                </div>
                <div class="span3">
                  <?php echo (form_error('class_id'))?form_error('class_id'):form_error('subject_id');?>
                </div>
              </div>
              <?php }else{
                      $this->session->set_flashdata('error_message', 'You Don\'t Have assign any Class. Please Assign a class with a teacher');
                    } ?>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>1st term Exam</th>
                    <th>2nd term Exam</th>
                    <th>Final Exam</th>
                    <th>Class Test</th>
                    <th>Quiz Test</th>
                    <th>Lab Test</th>
                    <th>Attendence</th>
                    <th>Extra Curricular</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>

                <?php


                  if(!empty($marks_dist[0]->id)){
                    echo '<input type="hidden" value="'.$marks_dist[0]->id.'" name="mark_id">';
              echo '<tr class="marks_distribution">
               <td><input type="number" value="'.$marks_dist[0]->first_ex.'" name="first_ex" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->second_ex.'" name="second_ex" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->final_ex.'" name="final_ex" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->class_test.'" name="class_test" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->quiz_test.'" name="quiz_test" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->lab_test.'" name="lab_test" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->attendence.'" name="attendence" id=""></td>
                  <td><input type="number" value="'.$marks_dist[0]->extra_curi.'"name="extra_curi" id=""></td>
                  <td><input class="btn btn-success btn-mini" type="submit" name = "update_mark_dist" value="Update"></td>
                </tr>';
                    }elseif($marks_dist == 'new'){
                      echo '<tr class="marks_distribution">
                      <td><input type="number" value="" id="first_ex" name="first_ex"></td>
                      <td><input type="number" value="" id="second_ex" name="second_ex"></td>
                      <td><input type="number" value="" id="final_ex" name="final_ex"></td>
                      <td><input type="number" value="" id="class_test" name="class_test"></td>
                      <td><input type="number" value="" id="quiz_test" name="quiz_test"></td>
                      <td><input type="number" value="" id="lab_test" name="lab_test"></td>
                      <td><input type="number" value="" id="attendence" name="attendence"></td>
                      <td><input type="number" value=""id="extra_curi" name="extra_curi"></td>
                      <td><input class="btn btn-success btn-mini" type="submit" name="save_mark_dist" value="Save"></td>
                    </tr>';

                    }
                 ?>

                </tbody>

              </table>



            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
