<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * layouts library for master template
 */
class layouts
{
  private $CI;
  private $layout_title = NULL;
  private $layout_content = NULL;

  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function set_title($title)
  {
    $this->layout_title = $title;
  }

  public function set_description($des)
  {
    $this->$layout_content = $des;
  }

  /**
  * This view is rander for admin panel structure
  * @param view name
  * @param layout name
  * @param passing data or value on the view
  * @param Default true for include header and footer and false for rander only view name.
  */
  public function view_backend($view_name, $layouts = array(), $parems = array(), $default = TRUE )
  {
    if( is_array($layouts) && count($layouts) >= 1 ){
      foreach ($layouts as $layouts_key => $layout) {
        $parems[$layouts_key] = $this->CI->load->view($layout, $parems, TRUE);
      }
    }

    if( $default ){
      // set header
      $header['layout_title'] = $this->layout_title;
      $this->CI->load->view('backend/header', $header);

      // render content view
      $this->CI->load->view($view_name, $parems);

      // set footer
      $this->CI->load->view('backend/footer');

    }
    else
      $this->CI->load->view($view_name, $parems);
  }



  /**
  * This view is rander for front page structure
  * @param view name
  * @param Header path
  * @param footer path
  * @param layout name
  * @param passing data or value on the view
  * @param Default true for include header and footer and false for rander only view name.
  */
  public function view_frontend($view_name, $header, $footer, $layouts = array(), $parems = array(), $default = TRUE )
  {
    if( is_array($layouts) && count($layouts) >= 1 ){
      foreach ($layouts as $layouts_key => $layout) {
        $parems[$layouts_key] = $this->CI->load->view($layout, $parems, TRUE);
      }
    }

    if( $default ){
      // set header
      $parems['layout_title'] = $this->layout_title;
      $this->CI->load->view($header, $parems);

      // render content view
      $this->CI->load->view($view_name, $parems);

      // set footer
      $this->CI->load->view($footer, $parems);
    }
    else
      $this->CI->load->view($view_name, $parems);
  }


  /**
  * This view is rander for front page structure
  * @param view name
  * @param Header path
  * @param footer path
  * @param layout name
  * @param passing data or value on the view
  * @param Default true for include header and footer and false for rander only view name.
  */
  public function view_dashboard($view_name, $header, $footer, $layouts = array(), $parems = array(), $default = TRUE )
  {
    if( is_array($layouts) && count($layouts) >= 1 ){
      foreach ($layouts as $layouts_key => $layout) {
        $parems[$layouts_key] = $this->CI->load->view($layout, $parems, TRUE);
      }
    }

    if( $default ){
      // set header
      $parems['layout_title'] = $this->layout_title;
      $this->CI->load->view($header, $parems);

      // render content view
      $this->CI->load->view($view_name, $parems);

      // set footer
      $this->CI->load->view($footer, $parems);
    }
    else
      $this->CI->load->view($view_name, $parems);
  }



}
