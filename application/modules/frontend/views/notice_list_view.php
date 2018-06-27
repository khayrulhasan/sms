
<div id="content-container" class="page-container">
  <div id="content" class="clearfix">
    <h1 class="widget-title">All Notices</h1>
    <ul class="notices-lists">
      <?php
      if( count($notices) )
      {
        foreach ($notices as $notice) {
          echo '<li class="n-list"><a href="'.base_url('frontend/notices/'.$notice->id).'">'.$notice->notice_title.'</a></li>';
        }
      }
      ?>

    </ul>
  </div>
</div>
