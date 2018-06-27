<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Users</a> </div>
    <h1>Manage Users</h1>
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
            <h5>User List</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table data-table table-bordered">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>User Name / User Id</th>
                  <th>User Email</th>
                  <th>User Access Level</th>
                  <th>User Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( isset($user_lists) ){
                  foreach ($user_lists as $user) {
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="user_name"><span class="in-progress"><?php echo $user->username; ?></span></td>
                      <td class="user_email"><?php echo $user->email; ?></td>
                      <td class="auth_level">
                        <?php
                        if($user->auth_level==1){
                          echo "Student";
                        }elseif($user->auth_level==5){
                          echo "Teacher";
                        }elseif($user->auth_level==9){
                          echo "Admin";
                        }
                        ?>
                      </td>
                      <td class="user_status">
                        <?php
                        if($user->banned==0){
                          echo "Active";
                        }elseif($user->banned==1){
                          echo "Suspend";
                        }
                        ?>
                      </td>
                      <td class="action taskOptions" style="text-align:right !important">
                        <a href="<?php echo base_url()."dashboard/users/update/".$user->user_id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <?php if ($this->auth_user_id == $user->user_id){
                          echo '<button class="btn btn-danger btn-mini">CURRENT USER</button>';
                        }else{
                          ?>

                          <a onclick="return confirm('Are you sure to delete this User?');" href="<?php echo base_url()."dashboard/users/delete/".$user->user_id; ?>">
                            <button class="btn btn-danger btn-mini">DELETE</button>
                            <?php
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
