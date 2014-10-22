<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('manufacturer_model');
    }
    public function index()
    {
        $data['products'] = $this->product_model->get();
        $this->layout->renderPage('product', 'list', $data);
    }
    public function add()
    {
        $data['manufacturers'] = $this->manufacturer_model->get();
        $this->layout->renderPage('product','add', $data, 'Добавить продукт');
    }

    public function edit($id)
    {
        if(empty($id) || !is_numeric($id)){
            show_404();
        }
        $data['categories'] = $this->category_model->get(0, null, null, array('sql' => 'cat.parent_id is null', 'params' => array()));
        $data['manufacturer'] = $this->manufacturer_model->getByField('m.id',$id);
        if(!$data['manufacturer']){
            show_404();
        }
        $errors = array(
            'name' => '',
            'system' => ''
        );
        if($this->input->is_ajax_request())
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', '"Название"',
                'required|trim|min_length[3]|case_sensitive[manufacturer&'. $id .'&name]');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $category = $this->input->post('category');
                if ($this->manufacturer_model->update($id,array('name'=> $name,'category_id'=> $category)))
                {
                    $errors = 'success';
                    echo json_encode($errors);
                } else {
                    $errors['system'] = 'Не удалось изменить';
                    echo json_encode($errors);
                }
            } else {
                $errors['name'] = form_error('name');
                echo json_encode($errors);
            }
        } else {
            $this->layout->renderPage('manufacturer','edit', $data, 'Изменить производителя');
        }
    }

    public function api_update()
    {
        $error = '';
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');

            $id = $this->input->post('pk');
            $fieldName = $this->input->post('name');
            $fieldValue = $this->input->post('value');

            $this->form_validation->set_rules('name', '"Название"',
                'required|trim|min_length[3]|case_sensitive[manufacturer&' . $id . '&name]');
            if ($this->form_validation->run()) {

                if ($this->manufacturer_model->update($id, array($fieldName => $fieldValue))) {
                    //$error = 'success';
                    //echo json_encode($error);
                } else {
                    $error = 'Не удалось изменить';
                    echo json_encode($error);
                }
            } else {
                $error = form_error('name');
                echo json_encode($error);
            }
        } else {
            show_404();
        }
    }

}


