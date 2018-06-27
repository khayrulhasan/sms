<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Pages</a> </div>
    <h1>Manage Pages</h1>
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
            <h5>Page List</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table data-table table-bordered">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Page Title</th>
                  <th>Page Position</th>
                  <th>Created At</th>
                  <th>Last Update</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( isset($page_list) ){
                  foreach ($page_list as $page) {
                    ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td style="text-align:left;"><span class="in-progress"><?php echo $page->title; ?></span></td>
                      <td><?php echo $page->position; ?></td>
                      <td><?php echo date('F d, Y h:mA', strtotime($page->created_at));?></td>
                      <td><?php echo ($page->update_at=='0000-00-00') ? '' : date('F d, Y h:mA', strtotime($page->update_at));?></td>
                      <td>
                        <!-- <a target="_blank" href="<?php echo base_url()."page/".$page->permalink; ?>">
                          <button class="btn btn-success btn-mini">VIEW</button>
                        </a> -->
                        <a href="<?php echo base_url()."dashboard/pages/update/".$page->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this Page?');" href="<?php echo base_url()."dashboard/pages/delete/".$page->id; ?>">
                        <button class="btn btn-danger btn-mini">DELETE</button></td>
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
