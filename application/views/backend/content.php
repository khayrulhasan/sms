
<div id="content">

  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>

  </div>

  <div class="container-fluid">

    <?php
    if( $this->auth_level >= 9 )
    {
      ?>
      <!-- Quick Links -->
      <div class="quick-actions_homepage">
        <ul class="quick-actions">
          <li class="bg_lb span2"> <a href="<?php echo base_url('dashboard/notice/manage'); ?>"> <i class="icon-table"></i> <span class="label label-important"><?php echo get_total_data('notice'); ?></span> Notice </a> </li>
          <li class="bg_lg span2"> <a href="<?php echo base_url('dashboard/class/manage'); ?>"> <i class="icon-bookmark"></i><span class="label label-important"><?php echo get_total_data('class'); ?></span> Class</a> </li>
          <li class="bg_ly span2"> <a href="<?php echo base_url('dashboard/booklist/manage'); ?>"> <i class="icon-book"></i><span class="label label-success"><?php echo get_total_data('booklist'); ?></span> Book Lists </a> </li>
          <li class="bg_lo span2"> <a href="<?php echo base_url('dashboard/teachers/manage'); ?>"> <i class="icon-user-md"></i><span class="label label-success"><?php echo get_total_data('teachers'); ?></span> Teachers</a> </li>
          <li class="bg_ls span2"> <a href="<?php echo base_url('dashboard/student/manage'); ?>"> <i class="icon-group"></i><span class="label label-success"><?php echo get_total_data('student'); ?></span> Student</a> </li>
          <li class="bg_lr span2"> <a href="<?php echo base_url('dashboard/users/manage-user'); ?>"> <i class="icon-user"></i><span class="label label-success"><?php echo get_total_data('users'); ?></span> User Account</a> </li>
        </ul>
      </div>
      <!-- END -->
      <?php
    }
    else
    {
      echo '<div class="quick-actions_homepage"></div>';
    }
    ?>

    <div class="row-fluid attand-chart">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Statistics</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span4 border-right">
              <div id="attandPieChart"></div>
            </div>
            <div class="span4 border-right">
              <div id="passDonutChart"></div>
            </div>
            <div class="span4">
              <div id="scoreChart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
