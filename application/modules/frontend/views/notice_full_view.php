
<div id="content-container" class="page-container">
  <div id="content" class="clearfix">
    <h1 class="widget-title"><?php echo $notice[0]->notice_title; ?></h1>
    <p>
      <?php echo $notice[0]->description; ?>
    </p>
    <?php
    if( $notice[0]->upload )
    {
      echo '<hr><h2>Download Attachment:</h2><br>';
      echo '<a target="_blank" href="'.base_url('uploads/'.$notice[0]->upload).'"><button class="button-primary">Click here</button></a>';
    }
    ?>
  </div>
</div>
