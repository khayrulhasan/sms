<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Class</a>
    </div>
    <h1>Manage Class</h1>
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
            <h5>Class</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Class Name<i class="icon icon-sort right"></i></th>
                  <!-- <th>Class Code</th> -->
                  <th>Teacher</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($class);
                $i=1;
                if( isset($class) )
                {
                  foreach ($class as $cls)
                  {
                    $teacher = get_teacher_name_by_id( $cls->teacher_id );
                    $teacher_name = ( isset($teacher) ) ? $teacher->first_name .' '. $teacher->last_name : '-';
                    // var_dump($teacher);exit;
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td ><span><?php echo get_class_name($cls->class_id); ?></span></td>
                      <td ><?php echo $teacher_name; ?></td>
                      <td ><?php echo $cls->note; ?></td>
											<td class="action taskOptions">
                        <a href="<?php echo base_url()."dashboard/class/update/".$cls->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this class?');" href="<?php echo base_url()."dashboard/class/delete/".$cls->id; ?>">
                          <button class="btn btn-danger btn-mini">DELETE</button>
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
