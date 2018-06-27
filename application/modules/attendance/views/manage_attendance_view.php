<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Attendance</a>
    </div>
    <h1>Manage Attendance</h1>
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
            <h5>Attendance</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL <i class="icon icon-sort right"></i></th>
                  <th>Class Name <i class="icon icon-sort right"></i></th>
                  <th>Date <i class="icon icon-sort right"></i></th>
                  <th>Attendance By <i class="icon icon-sort right"></i></th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( $this->auth_level >= 9 )
                {
                  foreach ((array)get_class_by_teacher_id() as $key=>$class)
                  {
                    $is_attendance_made_today = is_attendance_made_today($class->class_id);
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="pro_model"><?php echo get_class_name($class->class_id); ?></td>
                      <td class="pro_category"><input id="<?php echo 'set_date_field_'.$i; ?>" type="text" data-date="<?php echo date("y-m-d"); ?>" data-date-format="yyyy-mm-dd" name="attand_date" placeholder="Select Date" class="datepicker attend-date-select"></td>
                      <td class="pro_category"><?php echo ( $is_attendance_made_today ) ? $is_attendance_made_today->attendance_by : 'No Attendance Today' ; ?></td>
											<td class="action taskOptions">
                        
                        <a class="action-link" href="<?php echo base_url()."dashboard/attendance/attendance_sheet/".$class->class_id; ?>">
                          <button class="btn btn-primary btn-mini" onclick="return checkSetData('<?php echo '#set_date_field_'.$i; ?>');">Make Attendance</button>
                        </a>

                      </td>
                    </tr>
                    <?php
                      }
                    }
                    else
                    {
                    foreach ((array)get_class_by_teacher_id($this->auth_user_id) as $key => $value) {
                      $is_attendance_made_today = is_attendance_made_today($value->class_id);
                      ?>
                      <tr>
                        <td class="sl_number text-center"><?php echo $i++; ?></td>
                        <td class="pro_model"><?php echo $class->class_id; ?></td>
                        <td class="pro_category"><input id="<?php echo 'set_date_field_'.$i; ?>" type="text" data-date="<?php echo date("y-m-d"); ?>" data-date-format="yyyy-mm-dd" name="attand_date" placeholder="Select Date" class="datepicker attend-date-select"></td>
                        <td class="pro_category"><?php echo ( $is_attendance_made_today ) ? $is_attendance_made_today->attendance_by : 'No Attendance Today' ; ?></td>
                        <td class="action taskOptions">
                          
                          <a class="action-link" href="<?php echo base_url()."dashboard/attendance/attendance_sheet/".$value->class_id; ?>">
                            <button class="btn btn-primary btn-mini" onclick="return checkSetData('<?php echo '#set_date_field_'.$i; ?>');">Make Attendance</button>
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
