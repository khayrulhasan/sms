<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		$this->is_logged_in();
  }

	public function index()
	{
		if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
      $this->require_min_level(1);

    $this->setup_login_form();
    $this->load->view('login');
	}

  /**
   * Log out
   */
  public function logout()
  {
      $this->authentication->logout();

      // Set redirect protocol
      $redirect_protocol = USE_SSL ? 'https' : NULL;
			$path = '';

			if( $this->session->flashdata('request_uri') )
			{
				$path = $this->session->flashdata('request_uri');
			}
			else {
				$path = $this->uri->segment(3);
			}

			if( $path === 'admin' ){
				redirect( site_url( LOGIN_PAGE . '?redirect=admin&logout=1', $redirect_protocol ), 'refresh' );
			}
			else{
				// redirect('admin', 'refresh');
				redirect( site_url( LOGIN_PAGE . '?redirect='.$path, $redirect_protocol ), 'refresh' );
			}
  }

  /**
   * User recovery form
   */
  public function recover()
  {
    // Load resources
    $this->load->model('login_model');

    /// If IP or posted email is on hold, display message
    if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
    {
        $view_data['disabled'] = 1;
    }
    else
    {
      // If the form post looks good
      if( $this->tokens->match && $this->input->post('email') )
      {
        if( $user_data = $this->login_model->get_recovery_data( $this->input->post('email') ) )
        {
          // Check if user is banned
          if( $user_data->banned == '1' )
          {
              // Log an error if banned
              $this->authentication->log_error( $this->input->post('email', TRUE ) );

              // Show special message for banned user
              $view_data['banned'] = 1;
          }
          else
          {
              /**
               * Use the authentication libraries salt generator for a random string
               * that will be hashed and stored as the password recovery key.
               * Method is called 4 times for a 88 character string, and then
               * trimmed to 72 characters
               */
              $recovery_code = substr( $this->authentication->random_salt()
                  . $this->authentication->random_salt()
                  . $this->authentication->random_salt()
                  . $this->authentication->random_salt(), 0, 72 );

              // Update user record with recovery code and time
              $this->login_model->update_user_raw_data(
                  $user_data->user_id,
                  array(
                      'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
                      'passwd_recovery_date' => date('Y-m-d H:i:s')
                  )
              );

              // Set the link protocol
              $link_protocol = USE_SSL ? 'https' : NULL;

              // Set URI of link
              $link_uri = 'login/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;

              $view_data['special_link'] = anchor(
                  site_url( $link_uri, $link_protocol ),
                  site_url( $link_uri, $link_protocol ),
                  'target ="_blank"'
              );

              $view_data['confirmation'] = 1;
          }
        }

        // There was no match, log an error, and display a message
        else
        {
          // Log the error
          $this->authentication->log_error( $this->input->post('email', TRUE ) );

          $view_data['no_match'] = 1;
      	}
      }
    }

    echo $this->load->view('login-recover', ( isset( $view_data ) ) ? $view_data : '', TRUE );
  }


    // --------------------------------------------------------------

    /**
     * Verification of a user by email for recovery
     *
     * @param  int     the user ID
     * @param  string  the passwd recovery code
     */
    public function recovery_verification( $user_id = '', $recovery_code = '' )
    {
        /// If IP is on hold, display message
        if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
        {
            $view_data['disabled'] = 1;
        }
        else
        {
            // Load resources
            $this->load->model('login_model');

            if(
                /**
                 * Make sure that $user_id is a number and less
                 * than or equal to 10 characters long
                 */
                is_numeric( $user_id ) && strlen( $user_id ) <= 10 &&

                /**
                 * Make sure that $recovery code is exactly 72 characters long
                 */
                strlen( $recovery_code ) == 72 &&

                /**
                 * Try to get a hashed password recovery
                 * code and user salt for the user.
                 */
                $recovery_data = $this->login_model->get_recovery_verification_data( $user_id ) )
            {
                /**
                 * Check that the recovery code from the
                 * email matches the hashed recovery code.
                 */
                if( $recovery_data->passwd_recovery_code == $this->authentication->check_passwd( $recovery_data->passwd_recovery_code, $recovery_code ) )
                {
                    $view_data['user_id']       = $user_id;
                    $view_data['username']     = $recovery_data->username;
                    $view_data['recovery_code'] = $recovery_data->passwd_recovery_code;
                }

                // Link is bad so show message
                else
                {
                    $view_data['recovery_error'] = 1;

                    // Log an error
                    $this->authentication->log_error('');
                }
            }

            // Link is bad so show message
            else
            {
                $view_data['recovery_error'] = 1;

                // Log an error
                $this->authentication->log_error('');
            }

            /**
             * If form submission is attempting to change password
             */
            if( $this->tokens->match )
            {
                $this->login_model->recovery_password_change();
            }
        }


        echo $this->load->view( 'change-password', $view_data, TRUE );
    }


		/*
		* Ajax Login
		*/
		public function ajax_attempt_login()
    {
        if( $this->input->is_ajax_request() )
        {
            // Allow this page to be an accepted login page
            $this->config->set_item('allowed_pages_for_login', array('login/ajax_attempt_login') );

            // Make sure we aren't redirecting after a successful login
            $this->authentication->redirect_after_login = FALSE;

            // Do the login attempt
            $this->auth_data = $this->authentication->user_status( 0 );

            // Set user variables if successful login
            if( $this->auth_data )
                $this->_set_user_variables();

            // Call the post auth hook
            $this->post_auth_hook();

            // Login attempt was successful
            if( $this->auth_data )
            {
                echo json_encode(array(
                    'status'   => 1,
                    'user_id'  => $this->auth_user_id,
                    'username' => $this->auth_username,
                    'level'    => $this->auth_level,
                    'role'     => $this->auth_role,
                    'email'    => $this->auth_email
                ));
            }

            // Login attempt not successful
            else
            {
                $this->tokens->name = 'login_token';

                $on_hold = (
                    $this->authentication->on_hold === TRUE OR
                    $this->authentication->current_hold_status()
                )
                ? 1 : 0;

                echo json_encode(array(
                    'status'  => 0,
                    'count'   => $this->authentication->login_errors_count,
                    'on_hold' => $on_hold,
                    'token'   => $this->tokens->token()
                ));
            }
        }

        // Show 404 if not AJAX
        else
        {
            show_404();
        }
				//echo "ok";
    }




}
