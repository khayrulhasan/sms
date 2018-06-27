
<div id="content-container" class="page-container">
  <div id="content" class="clearfix">
    <h1 class="widget-title">All News & Event</h1>
      <div class="news-group clearfix">
        <?php if(get_news_event()): ?>
        <?php foreach (get_news_event() as $key => $value):?>
        <article class="news-container static-page" style="width: 20%;">
          <figure>
            <img style="height:200px;width: 100%;" src="<?php echo base_url('public/frontend/images/events')."/".$value->image;?>" data-retina="images/events/event1.jpg" alt="">
          </figure>
          <a href="#" class="link-comment">4</a>
          <header>
            <p><a href="<?php echo base_url('frontend/news-event')."/".$value->id; ?>" rel="category tag"><?php echo $value->title; ?></a></p>
            <time datetime="2013-11-12">
              <?php 
                $date = date_create($value->create_at);
                echo date_format($date,'M d, Y'); 
              ?>
             </time>
          </header>
          <p style="font-size: 12px;"><?php echo $value->description; ?></p>
        </article>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </div>
</div>  

