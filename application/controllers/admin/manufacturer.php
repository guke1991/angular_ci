<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturer extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('manufacturer_model');
        $this->load->model('category_model');
    }
    public function index()
    {
        $this->layout->renderPage('manufacturer', 'list', null);
    }
    public function add()
    {
        $data = array(
            'categories' => $this->category_model->get(0, null, null, array(
                    'sql' => 'cat.parent_id is null',
                    'params' => array()))
        );
        $this->layout->renderPage('manufacturer','add', $data, 'Добавить производителя');
    }

    public function edit($id)
    {
        if(empty($id) || !is_numeric($id)){
            show_404();
        }
        $data = array(
            'categories' => $this->category_model->get(0, null, null, array(
                    'sql' => 'cat.parent_id is null',
                    'params' => array())),
            'manufacturer' => $this->manufacturer_model->getByField('m.id',$id)
        );
        if(!$data['manufacturer']){
            show_404();
        }
        $this->layout->renderPage('manufacturer','edit', $data, 'Изменить производителя');

    }
}


