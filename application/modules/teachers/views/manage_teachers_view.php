<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Teachers</a>
    </div>
    <h1>Manage Teachers</h1>
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
            <h5>Teachers</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Full Name</th>
                  <th>Email Address</th>
                  <th>Address</th>
                  <th>Gender</th>
                  <th>Subject</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( isset($teachers) )
                {
                  foreach ($teachers as $teacher)
                  {

                    $subject  = get_subject_by_teacher_id( $teacher->id );
                    // echo "<pre>";
                    // var_dump($subject);exit;
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class=""><span class="in-progress"><?php echo $teacher->first_name. ' ' .$teacher->last_name ; ?></span></td>
                      <td class=""><?php echo get_user_by_id($teacher->user_id)->email; ?></td>
                      <td class=""><?php echo  $teacher->teacher_address; ?></td>
                      <td class=""><?php echo ( $teacher->gender == 0 ) ? 'Male' : 'Female'; ?></td>
                      <td class=""><?php echo ( isset($subject) ) ? $subject[0]->subject_name : '-'; ?></td>
											<td class="action taskOptions">
                        
                        <?php 
                        if($this->auth_level == 9 )
                        { 
                        ?>
                              <a href="<?php echo base_url()."dashboard/teachers/update/".$teacher->id; ?>"><button  class="btn btn-warning btn-mini">UPDATE</button></a>
                                <a onclick="return confirm('Are you sure to delete this teacher?');" href="<?php echo base_url()."dashboard/teachers/delete/".$teacher->id; ?>">
                              <button class="btn btn-danger btn-mini">DELETE</button>
                          <?php 
                          }
                          else
                          {

                            if($this->auth_user_id == $teacher->user_id)
                              { ?>
                                <a href="<?php echo base_url()."dashboard/teachers/update/".$teacher->id; ?>"><button  class="btn btn-warning btn-mini">UPDATE</button></a>
                                <a onclick="return confirm('Are you sure to delete this teacher?');" href="<?php echo base_url()."dashboard/teachers/delete/".$teacher->id; ?>"><button class="btn btn-danger btn-mini">DELETE</button>
                              <?php 
                              }
                              else
                              { 
                              ?>
                                <a href="#"><button disabled class="btn btn-warning btn-mini">UPDATE</button></a>  <a  href="#"><button class="btn btn-danger btn-mini">DELETE</button>
                              <?php 
                              } 
                            }
                          ?>
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
