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

class Manufacturer extends REST_Controller
{
    function one_get()
    {
        $id = $this->get('id');
        if(!$id){
            $this->response(NULL, 400);
        }
        $this->load->model('manufacturer_model');
        $manufacturer = $this->manufacturer_model->getByField('m.id',$id);
        $this->response($manufacturer, 200);
    }
    function many_get()
    {
        $this->load->model('manufacturer_model');
        $manufacturers = $this->manufacturer_model->get(0,500);
        $this->response($manufacturers, 200);
    }

    function create_post()
    {
        $errors = array(
            'name' => '',
            'system' => ''
        );
        $this->load->model('manufacturer_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', '"Название"',
            'required|trim|is_unique[manufacturer.name]|min_length[3]');
        if($this->form_validation->run()){
            $data = array(
                'name' => $this->post('name'),
                'category_id' =>$this->post('category')
            );
            if($this->manufacturer_model->create($data))
            {
                $this->response(array('status' => 'success','errors' => $errors));
            } else {
                $errors['system'] = 'Не удалось создать';
                $this->response(array('status' => 'failed','errors' => $errors));
            }
        } else {
            $errors['name'] = form_error('name');
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