<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Student</a>
    </div>
    <h1>Manage Student</h1>
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
            <h5>Student</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Full Name</th>
                  <th>Father's Name</th>
                  <th>Mother's Name</th>
                  <th>Contact Number</th>
                  <th>Date-of-Birth</th>
                  <th>NID / BS</th>
                  <th>Address</th>
                  <th>Gender</th>
                  <th>Class</th>
                  <th>Group</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($student);
                $i=1;
                if( isset($student) )
                {
                  foreach ($student as $std)
                  {
   
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="full_name"><span class="in-progress"><?php echo $std->name; ?></span></td>
                      <td class="father_name"><?php echo $std->father_name; ?></td>
                      <td class="mother_name"><?php echo $std->mother_name; ?></td>
                      <td class="contact_number"><?php echo $std->contact_number; ?></td>
                      <td class="date_of_birth"><?php echo $std->date_of_birth; ?></td>
                      <td class="nid_bs"><?php echo $std->nid_bs; ?></td>
                      <td class="address"><?php echo $std->address; ?></td>
                      <td class="gender"><?php echo ( $std->gender == 0 ) ? 'Male' : 'Female'; ?></td>
                      <td class="class_name"><?php echo  get_class_name($std->class_id); ?></td>
                      <td class="group"><?php echo $std->group; ?></td>
											<td class="action taskOptions">
                        <a href="<?php echo base_url()."dashboard/student/update/".$std->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this student?');" href="<?php echo base_url()."dashboard/student/delete/".$std->id; ?>">
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
