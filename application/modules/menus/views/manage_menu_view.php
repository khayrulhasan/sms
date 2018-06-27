<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Manage Menus</a> </div>
    <h1>Menu Management</h1>
  </div>
  <div class="container-fluid">
    <?php
    if( $this->session->flashdata('success_message') ){
      echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
    }
    elseif( $this->session->flashdata('error_message') ){
      echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
    }

    if( validation_errors() ){
      echo validation_errors('<div class="alert alert-danger fade in">', '</div>');
    }
    ?>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">
            <h5>All Pages</h5>
          </div>
          <div class="widget-content">
            <?php
						$attributes = array('class' => 'add-menu-page');
						echo form_open_multipart('menus/add_menu', $attributes);
						?>
              <div class="control-group">
                <p>
                  <label class="control-label">Select Page</label>
                  <div class="controls">
                    <select id="pageSelect" name="pageSelect">
                      <option data-permalink="" value=" " selected="selected">SELECT</option>
                      <?php
                      $pages = get_pages();
                      if( isset($pages) )
                      {
                        foreach( $pages as $page )
                        {
                          ?>
                          <option data-permalink="<?php echo base_url('frontend/pages').'/'.$page->permalink; ?>" value="<?php echo $page->id; ?>"><?php echo $page->title; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </p>

                <p>
                  <label class="control-label">Select Parent</label>
                  <div class="controls">
                    <select id="setMenuParent" name="setMenuParent">
                      <option value=" ">SELECT</option>
                    </select>
                  </div>
                </p>

                <p>
                  <label class="control-label" for="permalink">Permalink</label>
                  <div class="controls">
                    <input type="text" class="span11" id="permalink" name="permalink" placeholder="http://" />
                  </div>
                </p>

                <p>
                    <button type="submit" class="btn btn-success submitMenu" disabled="disabled">Add New Menu</button>
                </p>

              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="span6">
        <div class="widget-box">
          <div class="widget-title">
            <h5>Edit Menu</h5>
          </div>
          <div class="widget-content">
            <p>
            <?php
            $attr = array(
              'table_name'          => 'sms_menu',
              'menu_cat_ID'         =>  1,
              'ul_class'            => "",
              'ul_ID'               => "nav",
              'ul_attr'             => '',
              'li_class'            => "item-list",
              'li_if_submenu_after' => "<i class='fa fa-angle-down'></i>",
              'li_if_submenu_class' => "",
              'ul_submenu_class'    => "",
              'ul_submenu_ID'       => "secondary",
            );
            echo $this->menu->generateMenuManagement($attr);
            ?>
          </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
