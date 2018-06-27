<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Booklist</a>
    </div>
    <h1>Manage Booklist</h1>
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
            <h5>Booklist</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Class</th>
                  <th>Book</th>
                  <th>Title</th>
                  <th>Writter</th>
                  <th>Copyright</th>
                  <th>Publisher</th>
                  <th>Added By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                if( isset($booklists) )
                {
                  foreach ($booklists as $book)
                  {
                    $subject  = get_subject_by_id( $book->subject_id );
                    $added_by = get_user_by_id( $book->user_id );
                    ?>
                    <tr>
                      <td class="sl_number text-center"><?php echo $i++; ?></td>
                      <td class="pro_model"><span class="in-progress"><?php echo get_class_name($book->class_id); ?></span></td>
                      <td class="pro_image"><?php echo ( isset($subject) ) ? $subject->subject_name : '-'; ?></td>
                      <td class="pro_category"><?php echo $book->book_title; ?></td>
                      <td class="pro_category"><?php echo $book->book_writter; ?></td>
                      <td class="pro_category"><?php echo $book->copyright; ?></td>
                      <td class="pro_category"><?php echo $book->publisher; ?></td>
                      <td class="pro_category"><?php echo ( isset($added_by) ) ? $added_by->username : '-'; ?></td>
											<td class="action taskOptions">

                        <?php if(update_method_access_denied('booklist',$book->id,9)==FALSE){ ?>
                        <a href="">
                          <button disabled class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a href="">
                          <button disabled class="btn btn-danger btn-mini">DELETE</button>
                        </a>
                        <?php }else{ ?>
                            <a href="<?php echo base_url()."dashboard/booklist/update/".$book->id; ?>">
                              <button class="btn btn-warning btn-mini">UPDATE</button>
                            </a>
                            <a onclick="return confirm('Are you sure to delete this booklist?');" href="<?php echo base_url()."dashboard/booklist/delete/".$book->id; ?>">
                              <button class="btn btn-danger btn-mini">DELETE</button>
                            </a>
                        <?php } ?>
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
