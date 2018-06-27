<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Notice</a>
    </div>
    <h1>Manage Notice</h1>
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
            <h5>Notice</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Title<i class="icon icon-sort right"></i></th>
                  <th>Upload</th>
                  <th>Description</th>
                  <th>Publish Date</th>
                  <th>Added By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($notice);
                $i=1;
                if( isset($notice) )
                {
                  foreach ($notice as $notis)
                  {
                    $added_by  = get_user_by_id( $notis->added_by );
                    $upload    = $notis->upload;

                    $img = '';
                    if( ! empty( $notis->upload ) )
                    {
                      $file = explode('.', $notis->upload);
                      if( in_array('pdf', $file) )
                        $img = base_url('public/backend/img/'.'pdf.png');
                      elseif ( in_array('docx', $file) ) {
                        $img = base_url('public/backend/img/'.'doc.png');
                      }
                      elseif ( in_array('doc', $file) ) {
                        $img = base_url('public/backend/img/'.'doc.png');
                      }
                      elseif ( in_array('xlsx', $file) ) {
                        $img = base_url('public/backend/img/'.'xls.png');
                      }
                      elseif ( in_array('xls', $file) ) {
                        $img = base_url('public/backend/img/'.'xls.png');
                      }
                      elseif ( in_array('csv', $file) ) {
                        $img = base_url('public/backend/img/'.'csv.png');
                      }
                      else{
                        $img = base_url("uploads/".$notis->upload);
                      }
                    }
                    //echo $img;
                    $img = ( ! empty($img) ) ? '<img width="30" height="30" src="'. $img .'" alt="image" />' : '-';
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="pro_model"><span class="in-progress"><?php echo $notis->notice_title; ?></span></td>
                      <td class="pro_category"><?php echo $img; ?></td>
                      <td class="pro_category"><?php echo substr( $notis->description, 0, 50 )."..."; ?></td>
                      <td class="pro_category"><?php echo $notis->date; ?></td>
                      <td class="pro_category"><?php echo $added_by->username; ?></td>
											<td class="action taskOptions">
                        <a href="<?php echo base_url()."dashboard/notice/update/".$notis->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this notice?');" href="<?php echo base_url()."dashboard/notice/delete/".$notis->id; ?>">
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
