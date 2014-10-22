<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
 */

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Product extends REST_Controller
{
    function one_get()
    {
        $id = $this->get('id');
        if(!$id){
            $this->response(NULL, 400);
        }
        $this->load->model('product_model');
        $product = $this->product_model->getByField('p.id',$id);
        if($product){
            $this->response($product, 200);
        } else{
            $this->response(array('error' => 'product could not be found'), 404);
        }
    }
    function many_get()
    {
        $this->load->model('product_model');
        $products = $this->product_model->get();
        if($products){
            $this->response($products, 200);
        }else{
            $this->response(array('error' => 'products could not be found'), 404);
        }
    }

    function create_post()
    {
        $errors = array(
            'title' => '',
            'model' => '',
            'price' => '',
            'amount' => '',
            'system' => ''
        );
        $this->load->model('product_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', '"Название"',
            'required|trim|is_unique[product.title]|min_length[3]');
        $this->form_validation->set_rules('model', '"Модель"',
            'required|trim');
        $this->form_validation->set_rules('price', '"Цена"',
            'required|trim|numeric');
        $this->form_validation->set_rules('amount', '"Кол-во"',
            'required|trim|integer');
        if ($this->form_validation->run()) {
            $data = array(
                'title' => $this->post('title'),
                'model' => $this->post('model'),
                'price' => $this->post('price'),
                'amount' => $this->post('amount'),
                'manufacturer_id' => $this->post('manufacturer'),
                'specs' => $this->post('specs'),
                'description' => $this->post('description'),
            );

            if(!empty($_FILES)){
                $config['upload_path'] = 'assets/uploads/product/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['encrypt_name'] = true;

                $config_resize['image_library'] = 'GD2';
                $config_resize['create_thumb'] = false;
                $config_resize['maintain_ratio'] = true;
                $config_resize['width'] = 75;
                $config_resize['height'] = 50;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config_resize['source_image'] = 'assets/uploads/product/' . $file_name;
                    $config_resize['new_image'] = 'assets/uploads/product/thumbs/' . $file_name;
                    $this->load->library('image_lib', $config_resize);
                    $this->image_lib->resize();
                    $data['image'] = $file_name;
                } else {
                    $errors['image'] = $this->upload->display_errors();
                }
            }

            if ($this->product_model->create($data)) {
                $this->response(array('status' => 'success','errors' => $errors));
            } else {
                $errors['system'] = 'Не удалось создать';
                $this->response(array('status' => 'failed','errors' => $errors));
            }
        } else {
            $errors['title'] = form_error('title');
            $errors['model'] = form_error('model');
            $errors['price'] = form_error('price');
            $errors['amount'] = form_error('amount');
            $this->response(array('status' => 'failed','errors' => $errors));
        }
    }

    function update_post()
    {
        $errors = array(
            'name' => '',
            'system' => ''
        );
        $id = $this->post('id');
        $data = array(
            'name' => $this->post('name'),
            'category_id' =>$this->post('category')
        );
        if(!$id){
            $errors['system'] = 'Не верный id';
            $this->response(array('status' => 'failed','errors' => $errors));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', '"Название"',
            'required|trim|min_length[3]|case_sensitive[manufacturer&'. $id .'&name]');
        if ($this->form_validation->run()) {
            if ($this->manufacturer_model->update($id,$data)){
                $this->response(array('status' => 'success','errors' => $errors));
            } else {
                $errors['system'] = 'Не удалось изменить';
                $this->response(array('status' => 'failed','errors' => $errors));
            }
        } else {
            $errors['name'] = form_error('name');
            $this->response(array('status' => 'failed','errors' => $errors));
        }
    }
}