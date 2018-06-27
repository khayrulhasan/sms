<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Sliders</a> </div>
    <h1>Manage Sliders</h1>
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
            <h5>Slider List</h5>
          </div>

          <div class="dataTables_filter" id="example_filter"><label>Search: <input type="text" aria-controls="example"></label></div>

          <div class="widget-content nopadding">

            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>SL #</th>
                  <th>Slider Title</th>
                  <th>Slider Description</th>
                  <th>Slider Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // echo "<pre>";
                // var_dump($sliders);
                $i=1;
                if( isset($sliders) )
                {
                  foreach ($sliders as $slider)
                  {
                    ?>
                    <tr>
                      <td class=" text-center"><?php echo $i++; ?></td>
                      <td ><span class="in-progress"><?php echo substrwords($slider->title); ?></span></td>
                      <td ><?php echo substrwords($slider->description, 50); ?></td>
                      <td><img style='width: 100px;height:30px;' src="<?php echo base_url()."public/frontend/images/slider/". $slider->image; ?>" alt="Slider Image"></td>
                      <td class="action taskOptions">
                        <a href="<?php echo base_url()."dashboard/sliders/update/".$slider->id; ?>">
                          <button class="btn btn-warning btn-mini">UPDATE</button>
                        </a>
                        <a onclick="return confirm('Are you sure to delete this slider?');" href="<?php echo base_url()."dashboard/sliders/delete/".$slider->id; ?>">
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
