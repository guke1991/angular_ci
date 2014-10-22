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

class User extends REST_Controller
{
    function one_get()
    {
        $id = $this->get('id');
        if(!$id){
            $this->response(NULL, 400);
        }
        $this->load->model('user_model');
        $user = $this->user_model->getByField('u.id',$id);
        if($user){
            $this->response($user, 200);
        } else{
            $this->response(array('error' => 'user could not be found'), 404);
        }
    }
    function many_get()
    {
        $this->load->model('user_model');
        $users = $this->user_model->get(0,null,true);
        if($users){
            $this->response($users, 200);
        }else{
            $this->response(array('error' => 'users could not be found'), 404);
        }
    }

    function create_post()
    {

    }

    function update_post()
    {

    }
}