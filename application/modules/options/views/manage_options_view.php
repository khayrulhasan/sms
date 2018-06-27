<?php
$options = get_dashboard_options();
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="#">Manage Options</a>
    </div>
    <h1>OPTIONS FOR THE GENERAL SETTINGS</h1>
    <hr>
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
        <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open_multipart('dashboard/options/update_options', $attributes);
        ?>
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-cog"></i> </span>
              <h5>General Settings</h5>
            </div>
            <div class="widget-content nopadding">
              <div class="control-group">
                <label class="control-label">Site Title</label>
                <div class="controls">
                  <input type="text" name="site_title" placeholder="You can input anything…" class="span11" value='<?php echo ( isset( $options['dashboard_site_title'] ) ) ? $options['dashboard_site_title'] : ''; ?>'>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Copyright Text</label>
                <div class="controls">
                  <input type="text" name="copyright_text" placeholder="You can input anything…" class="span11" value='<?php echo ( isset( $options['dashboard_copyright_text'] ) ) ? $options['dashboard_copyright_text'] : ''; ?>'>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Admn Footer Text</label>
                <div class="controls">
                  <input type="text" name="admin_footer_text" placeholder="You can input anything…" class="span11" value='<?php echo ( isset( $options['dashboard_admin_footer_text'] ) ) ? $options['dashboard_admin_footer_text'] : ''; ?>'>
                </div>
              </div>
            </div>
          </div>

          <div class="accordion" id="collapse-group">
            <div class="accordion-group widget-box">
              <div class="accordion-heading">
                <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse"> <span class="icon"><i class="icon-ok"></i></span>
                  <h5>School Address</h5>
                  </a>
                </div>
              </div>
              <div class="collapse in accordion-body" id="collapseGOne">
                <div class="widget-content">
                  <textarea name="company_address" class="span12" rows="5"><?php echo ( isset( $options['dashboard_company_address'] ) ) ? $options['dashboard_company_address'] : ''; ?></textarea>
                </div>
              </div>
            </div>
            <div class="accordion-group widget-box">
              <div class="accordion-heading">
                <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse"> <span class="icon"><i class="icon-circle-arrow-right"></i></span>
                  <h5>Google Analytics</h5>
                  </a>
                </div>
              </div>
              <div class="collapse accordion-body" id="collapseGTwo">
                <div class="widget-content">
                  <textarea name="google_analytics" class="span12" rows="5"><?php echo ( isset( $options['dashboard_google_analytics'] ) ) ? $options['dashboard_google_analytics'] : ''; ?></textarea>
                </div>
              </div>
            </div>
            <div class="accordion-group widget-box">
              <div class="accordion-heading">
                <div class="widget-title"> <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse"> <span class="icon"><i class="icon-eye-open"></i></span>
                  <h5>Custome CSS</h5>
                  </a>
                </div>
              </div>
              <div class="collapse accordion-body" id="collapseGThree">
                <div class="widget-content">
                  <textarea name="custome_css" class="span12" rows="5"><?php echo ( isset( $options['dashboard_custome_css'] ) ) ? $options['dashboard_custome_css'] : ''; ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="option-save">
            <button type="submit" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
