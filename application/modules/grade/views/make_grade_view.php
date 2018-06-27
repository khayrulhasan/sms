<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Make Attendance</a>
    </div>
    <h1>Make Attendance</h1>
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
          <div class="widget-title">
            <h5>Attendance Sheet</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL <i class="icon icon-sort right"></i></th>
                  <th>Class Name <i class="icon icon-sort right"></i></th>
                  <th>Student Name <i class="icon icon-sort right"></i></th>
                  <th>Roll No <i class="icon icon-sort right"></i></th>
                  <th>Attend</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($students);
                $i=1;
                if( isset($students) )
                {
                  foreach ($students as $student)
                  {
                    $class = get_class_by_id($student->class_id);
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="pro_model"><?php echo ( isset($class->class_name) ) ? $class->class_name : '-'; ?></td>
                      <td class="pro_category"><?php echo $student->name; ?></td>
                      <td class="pro_category"><?php echo $student->id; ?></td>
											<td class="action taskOptions">
                        <input class="make_attendance" <?php echo ( student_is_present($student->id, $this->uri->segment(5)) ) ? 'checked="checked"' : ''; ?> attendance-date="<?php echo $this->uri->segment(5); ?>" student-id="<?php echo $student->id; ?>" student-class="<?php echo $student->class_id; ?>" type="checkbox" name="make_attendance" value="1" />
                      </td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
