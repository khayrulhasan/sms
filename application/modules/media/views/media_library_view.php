<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Library</a> </div>
    <h1>Media Library</h1>
  </div>
  <div class="container-fluid">
  <!-- start library content -->
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
            <h5>Gallery</h5>
          </div>
          <div class="widget-content">
            <ul class="thumbnails">
                <?php if(is_array($result) && sizeof($result)>0){
                  foreach ($result as $thumb_image) {
                    //$full_image =  explodeX(array('_thumb','.'), $single_image);
                    $thumb_preg =  preg_split("(_thumb.)", $thumb_image);
                    $full_image =  $thumb_preg[0].'.'.$thumb_preg[1];
                   ?>
                  <li class="span2">
                   <a> <img src="<?php echo base_url().'uploads/'.$thumb_image; ?>" alt="" ></a>
                   <div class="actions">
                     <a data-full-img="<?php echo base_url().'uploads/'.$full_image; ?>" class="lightbox_trigger" href="<?php echo base_url().'uploads/'.$thumb_image; ?>">
                       <i class="icon-search"></i>
                     </a>
                     <a onclick="return confirm('Are you want to sure delete this image ?');" data-full-img="<?php echo base_url().'uploads/'.$full_image; ?>" class="" href="<?php echo base_url() ?>dashboard/media/library/delete/<?php echo $thumb_preg[0] ; ?>">
                       <i class="icon-remove"></i>
                     </a>
                   </div>
                 </li>
              <?php
            } }
              ?>
            </ul>
            <div class="pagination">
              <div class="showing">
                <?php echo $paginglinks; ?>
              </div>
              <div class="pag_pagination">
                <?php echo $pagination; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End library content -->

    <!-- start upload media image -->
    <div class="buttons"> <a id="add-event" data-toggle="modal" href="#modal-add-event" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add new image</a>
      <div class="modal hide" id="modal-add-event">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3>Add a new image</h3>
        </div>
        <div class="modal-body">
          <div class="control-group ">
            <div class="upload_product_image">
              <label class="control-label">Select Image:</label>
              <div class="controls">

                <?php
                $data	=	array(
                  'class'				=>	'span9 product_image',
                  'id'					=>	'multiple_file',
                  'name'				=>	'userfile[]',
                  'value'				=>	set_value('userfile'),
                  'multiple'		=>	'multiple'
                  );
                echo form_upload($data);
                //echo '<button type="submit" class="btn btn-primary do_upload">add</button>';
                echo form_error('product_image');
                ?>
              </div>

              <input type="hidden" class="product_image_url" name="product_image" value="<?php echo ( isset($product->image) ) ? $product->image : set_value('product_image'); ?>" />
            </div>
            <div class="">
              <div class="img_preview">
                <?php
                $imgs = ( isset($product->image) ) ? $product->image : set_value('product_image');
                if( !empty($imgs) )
                {
                  $img_lists = '';
                  $imgs = explode(',', $imgs);
                  foreach ($imgs as $img)
                  {
                    $img_lists .= '<li><img src="'. base_url('uploads/'. $img) .'" alt="image" /><button type="button" class="btn btn-danger remove-product-img" data-link="uploads/'. $img .'" name="button">x</button></li>';
                  }
                  echo ( ! empty( $img_lists ) ) ? '<ul class="upload_img_lists">' . $img_lists . '</ul>' : $img_lists;
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"> <a href="<?php echo base_url(); ?>dashboard/media/library" class="btn" data-dismiss="modal">Cancel</a> <a href="<?php echo base_url(); ?>dashboard/media/library" id="add-event-submit" class="btn btn-primary">Add Image</a> </div>
      </div>
    </div>
    <!-- end media image -->
  </div>
</div>
