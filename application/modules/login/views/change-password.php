<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
           <h1 class="normal_text">Account Recovery - Stage 2</h1>

          <?php

          $showform = 1;

          if( isset( $validation_errors ) )
          {
            echo '
              <div >
                <p class="normal_text">
                  The following error occurred while changing your password:
                </p>
                <ul>
                  ' . $validation_errors . '
                </ul>
                <p class="normal_text">
                  PASSWORD NOT UPDATED
                </p>
              </div>
            ';
          }
          else
          {
            $display_instructions = 1;
          }

          if( isset( $validation_passed ) )
          {
            echo '
              <div >
                <p class="normal_text">
                  You have successfully changed your password.
                </p>
                <p class="normal_text">
                  You can now <a href="/' . LOGIN_PAGE . '">login</a>
                </p>
              </div>
            ';

            $showform = 0;
          }
          if( isset( $recovery_error ) )
          {
            echo '
              <div >
                <p class="normal_text">
                  No usable data for account recovery.
                </p>
                <p class="normal_text">
                  Account recovery links expire after
                  ' . ( (int) config_item('recovery_code_expiration') / ( 60 * 60 ) ) . '
                  hours.<br />You will need to use the
                  <a href="/examples/recover">Account Recovery</a> form
                  to send yourself a new link.
                </p>
              </div>
            ';

            $showform = 0;
          }
          if( isset( $disabled ) )
          {
            echo '
              <div >
                <p class="normal_text">
                  Account recovery is disabled.
                </p>
                <p>
                  You have exceeded the maximum login attempts or exceeded the
                  allowed number of password recovery attempts.
                  Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . '
                  minutes, or contact us if you require assistance gaining access to your account.
                </p>
              </div>
            ';

            $showform = 0;
          }
          if( $showform == 1 )
          {
            if( isset( $recovery_code, $user_id ) )
            {
              if( isset( $display_instructions ) )
              {
                if( isset( $username ) )
                {
                  echo '<p class="normal_text">
                    Your login user name is <i>' . $username . '</i><br />
                    Please write this down, and change your password now:
                  </p>';
                }
                else
                {
                  echo '<p class="normal_text">Please change your password now:</p>';
                }
              }

              ?>
                <div id="form">
                  <?php echo form_open(); ?>
                    <fieldset>
                      <p class="normal_text">Step 2 - Choose your new password</p>



                      <div class="controls">
                        <div class="main_input_box">
                              <span class="recover_pass_field ">Password</span>
                               <?php
                                // EMAIL ADDRESS *************************************************


                                  $input_data = array(
                                    'name'       => 'passwd',
                                    'id'         => 'passwd',
                                    'class'      => 'form_input ',
                                    'max_length' => config_item('max_chars_for_password')
                                  );
                                  echo form_password($input_data);
                              ?>
                          </div>
                          <div class="main_input_box">
                                <span class="recover_pass_field ">Confirm Password</span>
                                 <?php
                                  // EMAIL ADDRESS *************************************************


                                    $input_data = array(
                                      'name'       => 'passwd_confirm',
                                      'id'         => 'passwd_confirm',
                                      'class'      => 'form_input password',
                                      'max_length' => config_item('max_chars_for_password')
                                    );
                                    echo form_password($input_data);
                                ?>
                            </div>



                      </div>
                    </fieldset>

                      <div class="form-actions text-center">
                            <?php
                              // RECOVERY CODE *****************************************************************
                                echo form_hidden('recovery_code',$recovery_code);

                                // USER ID *****************************************************************
                                echo form_hidden('user_identification',$user_id);

                                // SUBMIT BUTTON **************************************************************
                                $input_data = array(
                                  'name'  => 'form_submit',
                                  'id'    => 'to-login',
                                  'class'    => ' btn btn-success ',
                                  'value' => 'Change Password'
                                );
                                echo form_submit($input_data);
                            ?>
                    </div>
                  </form>
                </div>
              <?php
            }
          }
          ?>
        </div>

        <script src="<?php echo base_url(); ?>public/backend/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>public/backend/js/elspress.login.js"></script>
    </body>
</html>
