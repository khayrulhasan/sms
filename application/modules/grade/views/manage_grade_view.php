<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Grade</a>
    </div>
    <h1>Manage Grade</h1>
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
            <h5>Grade</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL <i class="icon icon-sort right"></i></th>
                  <th>Class Name <i class="icon icon-sort right"></i></th>
                  <th>Subject <i class="icon icon-sort right"></i></th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($classes);
                $i=1;
                if( isset($classes) )
                {
                  foreach ($classes as $class)
                  {
                    $is_attendance_made_today = is_attendance_made_today($class->class_id);
                    // var_dump($is_attendance_made_today);exit();
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="pro_model"><?php echo get_class_name($class->class_id); ?></td>
                      <td class="pro_category">
                        <select name="subject_name" class="span12">
    											<?php
    											if( ! empty($subjects) ){
    												echo '<option value="0">Empty</option>';
    												foreach ($subjects as $subject) {
                              echo '<option value="'. $subject->subject_id .'">' . $subject->subject_name . '</option>';
    												}
    											}
    											else {
    												echo '<option value="0" selected>Empty</option>';
    											}
    											?>
    										</select>
                      </td>
											<td class="action taskOptions">
                        <a class="action-link" href="<?php echo base_url()."dashboard/grade/mark_sheet/".$class->class_id; ?>">
                          <button class="btn btn-primary btn-mini" onclick="return checkSetData('<?php echo '#set_date_field_'.$i; ?>');">Make Grade</button>
                        </a>
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
