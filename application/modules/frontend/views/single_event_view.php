
<div id="content-container" class="page-container">
  <?php foreach ($single_news_event as $value):?>
  <div id="content" class="clearfix">
  <img style = "height: 300px;margin-top: 100px;width: 40%;"src="<?php echo base_url('public/frontend/images/events')."/".$value->image;?>" alt="">
    <h1 class="widget-title"><?php  echo $value->title; ?></h1>
    <p> <?php echo $value->description; ?>    </p>
  </div>
<?php endforeach; ?>
</div>
