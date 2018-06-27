<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bangladesh Public School | Login</title><meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/elspress-login.css" />
  <link href="<?php echo base_url(); ?>public/backend/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

  <div id="loginbox">
    <div class="control-group normal_text">
      <img src="<?php echo base_url(); ?>public/frontend/images/logo-footer.png" data-retina="images/logo-footer-retina.png" alt="Login">
    </div>
    <?php
    if( isset( $validation_errors ) )
    {
      echo '<p class="normal_text">The following error occurred while changing your password:</p>
          <ul>
            ' . $validation_errors . '
          </ul>
          <p class="normal_text">
            PASSWORD NOT UPDATED
          </p>
      ';
    }

    if( ! isset( $on_hold_message ) )
    {
      if( isset( $login_error_mesg ) )
      {
        echo '<p class="normal_text has-error">Invalid Username or Password.</p>';
      }

      if( $this->input->get('logout') )
      {
        echo '<p class="normal_text">You have successfully logged out.</p>';
      }

      // register success
      if( $this->session->flashdata('success_message') ){
        echo '<div class="alert alert-success fade in">'. $this->session->flashdata('success_message') . '</div>';
      }
      elseif( $this->session->flashdata('error_message') ){
        echo '<div class="alert alert-danger fade in">'. $this->session->flashdata('error_message') . '</div>';
      }

      ?>
      <?php echo form_open( $login_url, array( 'class' => 'form-vertical', 'id' => 'loginform' ) );  ?>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"></i></span>
                    <input type="text" name="login_string" placeholder="Username" required />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                    <input type="password" name="login_pass" placeholder="Password" required/>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="<?php echo site_url(); ?>login/recover" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
            <span class="pull-right"><input type="submit" class="btn btn-success" value="Login" /> </span>
        </div>
      </form>
    <?php
    }
    else{
      // EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
      echo '
        <div class="block-container">
          <p class="normal_text head-text">
            <strong>Excessive Login Attempts</strong>
          </p>
          <p class="normal_text">
            You have exceeded the maximum number of failed login<br />
            attempts that this website will allow.
          <p>
          <p class="normal_text">
            Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
          </p>
          <p class="normal_text">
            Please use the <a href="login/recover">Account Recovery</a> after ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes has passed,<br />
            or contact us if you require assistance gaining access to your account.
          </p>
        </div>
      ';
    }
    ?>
  </div>

  <script src="<?php echo base_url(); ?>public/backend/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>public/backend/js/elspress.login.js"></script>
</body>
</html>
