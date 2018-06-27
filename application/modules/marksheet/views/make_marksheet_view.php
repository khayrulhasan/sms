
<div id="content">

  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    </div>
    <h1>Make Marksheet</h1>
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
            <h5>Total Mark distribution</h5>
          </div>
          <div class="widget-content nopadding">
              <?php
                $attributes = array('class' => 'form-horizontal', 'style' => 'overflow: scroll');
                echo form_open_multipart('marksheet/add_or_update_marks/', $attributes);
              ?>
              <div class="control-group ">
                <div class="span4">
                  <label class="control-label span4 " style="text-align:right;margin-top: 3px;font-size: 12px"> Select Class : &nbsp </label>
                  <div class="controls">
                    <?php
                      $options[' '] = 'Select';
                      foreach ($asign_class as $value) {
                      $options[$value->class_id] = get_class_name($value->class_id);
                      }
                      if( isset($search_data['class_id']) )
                      {
                        echo form_dropdown('search_class_id', $options, $search_data['class_id'], 'class="span8 ajax_trigger_p"');
                      }
                      else
                      {
                        echo form_dropdown('search_class_id', $options, set_value('search_class_id'), 'class="span8 ajax_trigger_p"');
                      }
                    ?>
                  </div>
                </div>
                <div class="span4">
                  <label class="control-label span4" style = "margin-top: 3px;font-size: 12px;">Select Subject :</label>
                  <div class="controls">
                    <?php
                    // echo '<pre>', var_dump($get_subject);exit;
                      $asign_subject[' '] = 'Select';
                      foreach ($get_subject as $get_subject_n)
                      {
                        foreach ($get_subject_n as $subject)
                        {
                          $asign_subject[$subject->subject_id] = $subject->subject_name;
                        }
                      }

                      if( isset($search_data['subject_id']) )
                      {
                        echo form_dropdown('search_subject_id', $asign_subject, $search_data['subject_id'], 'class="span8" id="subject_ajax_output"');
                      }
                      else
                      {
                        echo form_dropdown('search_subject_id', $asign_subject, set_value('search_subject_id'), 'class="span8" id="subject_ajax_output"');
                      }
                     ?>
                  </div>
                </div>
                <div class="span1">
                  <div class="controls span12">
                    <input class="btn btn-primary" type="submit" name="submit" value="Go">
                  </div>

                </div>
                <div class="span3">
                  <?php echo (form_error('class_id'))?form_error('class_id'):form_error('subject_id');?>
                </div>
              </div>


              <?php
              if(!empty($th_field))
              {
                ?>
                <table class="table table-bordered ">
                <thead>
                  <tr>
                  <?php foreach ($th_field as $value) {
                    // var_dump($value->first_ex);exit;
                    echo '<th>SL</th>';
                    echo '<th>Student Name</th>';
                    echo (!empty($value->first_ex))?'<th>1st Term Exam('.$value->first_ex.')</th>':'';
                    echo (!empty($value->second_ex))?'<th>2nd Term Exam('.$value->second_ex.')</th>':'';
                    echo (!empty($value->final_ex))?'<th>Final Exam('.$value->final_ex.')</th>':'';
                    echo (!empty($value->class_test))?'<th>Class Test('.$value->class_test.')</th>':'';
                    echo (!empty($value->quiz_test))?'<th>Quiz Test('.$value->quiz_test.')</th>':'';
                    echo (!empty($value->lab_test))?'<th>Lab Test('.$value->lab_test.')</th>':'';
                    echo (!empty($value->attendence))?'<th>Attendence('.$value->attendence.')</th>':'';
                    echo (!empty($value->extra_curi))?'<th>Extra Curiculam('.$value->extra_curi.')</th>':'';
                    echo '<th>Total</th>';
                    echo '<th>Grade</th>';
                  ?>
                  </tr>
                </thead>
                <tbody>
                   <?php


                   if(is_array($students)){
                      $i=1;
                      foreach ($students as $student)
                      {
                        $student = (array) $student;
                        // var_dump((array) $student);exit;
                        //$marks = get_student_marks_by_subject_id($student->id,$search_data['class_id'],$search_data['subject_id']);
                        $total = isset( $student['total_mark'] ) ? $student['total_mark'] : 0;
                        if($total != 0)
                        {
                          echo ' <tr class="marks_distribution">';
                          echo '<input type="hidden" name="marks_id[]" value="'.$student['id'].'">';
                          echo '<input type="hidden" name="student_id[]" value="'.$student['student_id'].'">';
                          echo '<input type="hidden" name="subject_id[]" value="'.$search_data['subject_id'].'">';
                          echo '<input type="hidden" name="class_id[]" value="'.$search_data['class_id'].'">';
                          echo '<td>'.$i++.'</td>';
                          echo '<td>'.$student['name'].'</td>';
                          echo (!empty($value->first_ex))?'<td><input type="number" max="'.$th_field[0]->first_ex.'" name="first_ex[]" value="'.$student['first_ex'].'"></td>':'';
                          echo (!empty($value->second_ex))?'<td><input type="number" max="'.$th_field[0]->second_ex.'" name="second_ex[]" value="'.$student['second_ex'].'"></td>':'';
                          echo (!empty($value->final_ex))?'<td><input type="number" max="'.$th_field[0]->final_ex.'" name="final_ex[]" value="'.$student['final_ex'].'"></td>':'';
                          echo (!empty($value->class_test))?'<td><input type="number" max="'.$th_field[0]->class_test.'" name="class_test[]" value="'.$student['class_test'].'"></td>':'';
                          echo (!empty($value->quiz_test))?'<td><input type="number" max="'.$th_field[0]->quiz_test.'" name="quiz_test[]" value="'.$student['quiz_test'].'"></td>':'';
                          echo (!empty($value->lab_test))?'<td><input type="number" max="'.$th_field[0]->lab_test.'" name="lab_test[]" value="'.$student['lab_test'].'"></td>':'';
                          echo (!empty($value->attendence))?'<td><input type="number" max="'.$th_field[0]->attendence.'" name="attendence[]" value="'.$student['attendence'].'"></td>':'';
                          echo (!empty($value->extra_curi))?'<td><input type="number" max="'.$th_field[0]->extra_curi.'" name="extra_curi[]" value="'.$student['extra_curi'].'"></td>':'';
                          echo '<td>'.$total.'</td>';
                          echo '<td>'.gpa_by_obtained_marks($total)[0]->letter_grade.'</td>';
                          echo '</tr>';
                        }
                        else
                        {
                          echo ' <tr class="marks_distribution">';
                          echo '<input type="hidden" name="marks_id[]" value="0">';
                          echo '<input type="hidden" name="student_id[]" value="'.$student["id"].'">';
                          echo '<input type="hidden" name="subject_id[]" value="'.$search_data['subject_id'].'">';
                          echo '<input type="hidden" name="class_id[]" value="'.$search_data['class_id'].'">';
                          echo '<td>'.$i++.'</td>';
                          echo '<td>'.$student["name"].'</td>';
                          echo (!empty($value->first_ex))?'<td><input type="number" max="'.$th_field[0]->first_ex.'" name="first_ex[]" value=""></td>':'';
                          echo (!empty($value->second_ex))?'<td><input type="number" max="'.$th_field[0]->second_ex.'" name="second_ex[]" value=""></td>':'';
                          echo (!empty($value->final_ex))?'<td><input type="number"max="'.$th_field[0]->final_ex.'"  name="final_ex[]" value=""></td>':'';
                          echo (!empty($value->class_test))?'<td><input type="number "max="'.$th_field[0]->class_test.'"  name="class_test[]" value=""></td>':'';
                          echo (!empty($value->quiz_test))?'<td><input type="number" max="'.$th_field[0]->quiz_test.'" name="quiz_test[]" value=""></td>':'';
                          echo (!empty($value->lab_test))?'<td><input type="number" max="'.$th_field[0]->lab_test.'" name="lab_test[]" value=""></td>':'';
                          echo (!empty($value->attendence))?'<td><input type="number" max="'.$th_field[0]->attendence.'" name="attendence[]" value=""></td>':'';
                          echo (!empty($value->extra_curi))?'<td><input type="number" max="'.$th_field[0]->extra_curi.'" name="extra_curi[]" value=""></td>':'';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '</tr>';
                        }//end isset marks

                      }//end foreach student
                   }
                   elseif($students != 'init'){
                     echo "<table class='table'><tr><td>No student found</td></tr></table>";
                    //$this->session->set_flashdata('error_message', 'No student found');
                   }//end student isset


                } //end foreach th_field
                ?>



                </tbody>
              </table>


               <div class="form-actions ">
                <input name="Save_student_marks" class="btn btn-success" type="submit" value="Save Marks" />
              </div>
              <?php }else{
                //$this->session->set_flashdata('error_message', 'No Marks Distribution Found. Please Make a Marks Distribution First.');
                echo "<table class='table'><tr><td>No Marks Distribution Found. Please Make a Marks Distribution First.</td></tr></table>";
              }//if not empty th_field
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
