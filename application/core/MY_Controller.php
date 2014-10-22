<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller {
    public  $user = false;
    function __construct() {
        parent::__construct();
        if ($this->uri->segment(1) !== 'admin') {
            $this->load->library('Layout',array('siteSide' => 'frontend','themeName' => 'main'));
            $data['modals'] = array(
                $this->layout->renderPartial('user','login_modal',null,true),
                $this->layout->renderPartial('user','register_modal',null,true)
            );
            $this->layout->setPartData('footer',$data);
        } else {
            $this->load->library('Layout',array('siteSide' => 'admin','themeName' => 'main'));
        }
    }

    protected function _fileupload($module, $input_names = array()) {
        $config['upload_path'] = 'assets/uploads/'.$module.'/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = true;

        $config_resize['image_library'] = 'GD2';
        $config_resize['create_thumb'] = false;
        $config_resize['maintain_ratio'] = true;
        $config_resize['width'] = 75;
        $config_resize['height'] = 50;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $data = array();
        if (!is_null($input_names) && !empty($input_names)) {
            foreach ($input_names as $input_name) {
                if ($this->upload->do_upload($input_name)) {
                    $upload_info = $this->upload->data();
                    $data[$input_name] = $upload_info['file_name'];
                    $config_resize['source_image'] = 'assets/uploads/' . $module . '/' . $upload_info['file_name'];
                    $config_resize['new_image'] = 'assets/uploads/' . $module . '/thumbs/' . $upload_info['file_name'];
                    $this->load->library('image_lib', $config_resize);
                    $this->image_lib->resize();
                } else {
                    $data[$input_name]['error'] = $this->upload->display_errors();
                }
            }
            return $data;
        } else {
            return false;
        }
    }

}