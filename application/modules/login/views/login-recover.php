<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bangladesh Public School Login</title><meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/elspress-login.css" />
  <link href="<?php echo base_url(); ?>public/backend/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
    <body>


          <div id="loginbox">
              <!-- Start Recovery from and error validation code -->

              <?php
              if( isset( $disabled ) )
              {
                echo '
                  <div class="block-container">
                    <p class="normal_text head-text">
                      Account Recovery is Disabled.
                    </p>
                    <p class="normal_text">
                      If you have exceeded the maximum login attempts, or exceeded
                      the allowed number of password recovery attempts, account recovery
                      will be disabled for a short period of time.
                      Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . '
                      minutes, or contact us if you require assistance gaining access to your account.
                    </p>
                  </div>
                ';
              }
              else if( isset( $banned ) )
              {
                echo '
                  <div class="block-container">
                    <p class="normal_text head-text">
                      Account Locked.
                    </p>
                    <p class="normal_text">
                      You have attempted to use the password recovery system using
                      an email address that belongs to an account that has been
                      purposely denied access to the authenticated areas of this website.
                      If you feel this is an error, you may contact us
                      to make an inquiry regarding the status of the account.
                    </p>
                  </div>
                ';
              }
              else if( isset( $confirmation ) )
              {
                echo '
                  <div >
                    <p class="normal_text">
                      Congratulations, you have created an account recovery link.
                    </p>
                    <p class="normal_text">
                      "We have sent you an email with instructions on how
                      to recover your account."
                    </p>
                    <!--p class="normal_text">
                      This is the account recovery link:
                    </p>
                    <p>' . $special_link . '</p-->
                  </div>
                ';
              }
              else if( isset( $no_match ) )
              {
                echo '
                  <div>
                    <p class="normal_text" style="color:red;">
                      Email not matched or invalid email.
                    </p>
                  </div>
                ';

                $show_form = 1;
              }
              else
              {
                echo '
                  <p class="normal_text">
                    If you\'ve forgotten your password and/or username,
                    enter the email address used for your account,
                    and we will send you an e-mail
                    with instructions on how to access your account.
                  </p>
                ';

                $show_form = 1;
              }
              if( isset( $show_form ) )
              {
                ?>

                    <?php echo form_open(); ?>
                      <?php
                          /*
                          $attributes = array('class' => 'form-vertical','id'=>'recoverform');
                          echo form_open('login/recover', $attributes);*/

                      ?>
                      <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
                             <?php
                              // EMAIL ADDRESS *************************************************


                              $input_data = array(
                                'name'    => 'email',
                                'id'    => 'email',
                                'class'   => 'form_input',
                                'maxlength' => 255,
                                'placeholder' => 'E-mail address',

                              );
                              echo form_input($input_data);
                            ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <span class="pull-left"><a href="<?php echo site_url(); ?>login/login" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                        <span class="pull-right">
                            <?php
                            // SUBMIT BUTTON **************************************************************
                            $input_data = array(
                              'name'  => 'submit',
                              'class'  => 'btn btn-info',
                              'id'    => 'submit_button',
                              'value' => 'Recovery'
                            );
                            echo form_submit($input_data);
                          ?>
                    </div>
                  </form>

                <?php
              }
                ?>


        </div>

        <script src="<?php echo base_url(); ?>public/backend/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>public/backend/js/elspress.login.js"></script>
    </body>
</html>
