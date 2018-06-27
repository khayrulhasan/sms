<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Message</a> </div>
    <h1>Manage Message</h1>
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
            <h5>Message List</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Author</th>
                  <th>Message Title</th>
                  <th>Description</th>
                  <th>Author Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( isset($messages) )
                {
                  foreach ($messages as $message)
                  {
                    ?>
                    <tr>
                      <td class=" text-center"><?php echo $i++; ?></td>
                      <td><img style='width: 100px;height:30px;' src="<?php echo base_url()."public/frontend/images/teachers/". $message->image; ?>" alt="Image"></td>
                      <td ><span class="in-progress"><?php echo substrwords($message->title); ?></span></td>
                      <td ><?php echo substrwords($message->description); ?></td>
                      <td ><?php echo $message->message_owner; ?></td>
                      <td class="action taskOptions">
                        <a href="<?php echo base_url()."dashboard/message/update/".$message->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this Message?');" href="<?php echo base_url()."dashboard/message/delete/".$message->id; ?>">
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
