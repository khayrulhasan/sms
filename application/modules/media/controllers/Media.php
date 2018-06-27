<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    // verify_min_level
    if( ! $this->verify_min_level(6) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
    $this->load->model('media_model');
  }

  public function index( $offset = 0 ) {

    $picture = preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/"));

    $thumb_image = array_filter($picture, function($v) {return stristr($v, '_thumb');});
     $per_page = 12;
     $offset = ($this->uri->segment(4) != '' ? $this->uri->segment(4):0);
     $config['total_rows'] = count($thumb_image);
     $config['per_page']= $per_page;
     $config['first_link'] = 'First';
     $config['last_link'] = 'Last';
     $config['uri_segment'] = 4;
     $config['base_url']= base_url().'/dashboard/media/index';
     $config['suffix'] = http_build_query($_GET, '', "&");
     $this->pagination->initialize($config);
     $this->data['paginglinks'] = $this->pagination->create_links();
     $this->data['per_page'] = $this->uri->segment(4);
     if($this->data['paginglinks']!= '') {
       $pagelink = 'Showing '.((($this->pagination->cur_page-1)*$this->pagination->per_page)+1).' to '.($this->pagination->cur_page*$this->pagination->per_page).' of '.count($thumb_image);//.$this->pagination->total_rows
     }
       $attr           =   array(
         'meta_description'          =>  'WinOneDollar is a platform to bit and get product.',
          'result'          =>  array_slice($thumb_image, $offset, $per_page),
          'paginglinks'          =>  (isset($pagelink))?$pagelink:" ",
          'pagination'          =>  $this->pagination->create_links(),
       );
       $this->layouts->set_title('Media library');
       $this->layouts->view_dashboard(
         'media_library_view',          // container content data
         'backend/header',              //  Load header
         'backend/footer',              //  Load footer
         '',                            //  no layouts
         $attr                          //  pass global parametter
       );
    }

  //for image delete
  public function delete()
  {
    $image_name = xss_clean( $this->uri->segment(5));
    $images =  preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/"));
    foreach($images as $img)
    {
      $imgn =explode('.', $img);
      if($imgn[0]==$image_name){
        @unlink('./uploads/'.$img);
        @unlink('./uploads/'.$imgn[0].'_thumb.'.$imgn[1]);

      }
    }
    redirect('dashboard/media/library');
  }


  //for image upload
  public function do_upload()
  {
    if( $this->input->is_ajax_request() )
    {
      // if the image is delete request
      //var_dump($this->input->post());
      if( $this->input->post('imgName') ){
        $delete_img_name  = explode('/', $this->input->post('imgName'));
        $delete_img_name  = $delete_img_name[1];

        unlink($this->input->post('imgName'));
        $thumb = explode('.', $this->input->post('imgName'));
        $thumb = $thumb[0]. '_thumb.' .$thumb[1];
        unlink($thumb);


        $imgSet = explode(',', $this->input->post('imgSet'));
        $newImgSet = '';
        foreach ($imgSet as $img) {
          $newImgSet .= ( $img != $delete_img_name ) ? $img. "," : '';
        }
        $newImgSet = rtrim( $newImgSet, ',' );
        echo json_encode(array('status' => 1, 'msg' => 'deleted', 'newImgSet' => $newImgSet));
        return;
      }
      else{
        $status = "";
        $msg    = "";
        $url    = "";
        $img_lists = "";
        $file_element_name = 'file_data';

        if ($status != "error")
        {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpeg|jpg|png|JPEG|PNG|GIF|JPG';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $config['width']  = 500;
            $config['height'] = 500;

            $this->load->library('image_lib');
            $this->load->library('upload');

            $files   = $_FILES;
            // echo count($files['file_data']['name']); exit();
            $error = 0;
            $lim = count($files['file_data']['name']);
            for( $i = 0; $i < $lim; $i++ )
            {
              $_FILES['file_data']['name']      =   $files['file_data']['name'][$i];
              $_FILES['file_data']['type']      =   $files['file_data']['type'][$i];
              $_FILES['file_data']['tmp_name']  =   $files['file_data']['tmp_name'][$i];
              $_FILES['file_data']['error']     =   $files['file_data']['error'][$i];
              $_FILES['file_data']['size']      =   $files['file_data']['size'][$i];

              $this->upload->initialize($config);

              if ( $this->upload->do_upload($file_element_name) )
              {
                $data = $this->upload->data();

                $status = 1;
                $msg    = "File successfully uploaded";
                $url    .= $data['file_name'] . ",";
                $img_lists .= '<li><img src="'. base_url('uploads/'. $data['file_name']) .'" alt="image" /><button type="button" class="btn btn-danger remove-product-img" data-link="uploads/'. $data['file_name'] .'" name="button">x</button></li>';

                // resize image
                $config['source_image'] = './uploads/'. $data['file_name'];

                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $this->image_lib->clear();

              }
              else
              {
                $status = 'error';
                $error++;
              }
            }

            // checking error thread
            if ( $error > 0 )
            {
              $status = 'error';
              $msg = $this->upload->display_errors('', '');

              unlink($data['full_path']);
              $status = "error";
              $msg = "Something went wrong to process this file, please try again.";
            }
            @unlink($_FILES[$file_element_name]);
        }
        $img_lists = ( ! empty( $img_lists ) ) ? '<ul class="upload_img_lists">' . $img_lists . '</ul>' : $img_lists;
        $url = rtrim( $url, ',' );
        echo json_encode(array('status' => $status, 'msg' => $msg, 'url' => $url, 'lists' => $img_lists));
      }
    }
    else{
      show_404();
    }
  }
}
