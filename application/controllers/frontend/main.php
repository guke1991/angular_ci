<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->layout = new Layout(array('siteSide' => 'admin','themeName' => 'main'));
    }
    public function index()
    {
//        $data['modals'] = array(
//            $this->layout->renderPartial('user','login_modal',null,true),
//            $this->layout->renderPartial('user','register_modal',null,true)
//        );

        //$this->layout->renderPartial('main','login_modal');
        $this->layout->renderPage('main', 'index', null, 'Title');
//        $this->layout->renderPage('main','index',null,'Title');
    }
}


