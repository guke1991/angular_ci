<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    public function index()
    {
        $data['modals'] = array(
            $this->layout->renderPartial('user','full_info_modal',null,true),
        );
        $this->layout->setPartData('footer',$data);
        $this->layout->renderPage('user', 'list', null);
    }


}


