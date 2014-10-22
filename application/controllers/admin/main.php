<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

    public function index()
    {
//        $userData = array(
//            'email' => '222',
//            'password' => '222',
//            'role_id' => 2,
//            'created_date' => date('y-m-d')
//        );
//        $userInfoData = array(
//            'first_name' => '222',
//            'last_name' => '222',
//            'phone' => 2,
//            'address_line1' => '222',
//            'city_id' => 8,
//            'region_id' => 8
//        );
//        $this->load->model('user_model');
//        $this->user_model->update(6, $userData, $userInfoData);

//        $this->layout->renderPartial('main','login_modal');

        $ordersProductsData = array(
            array(
                'product_id' => 1,
                'count' => 1,
            ),
            array(
                'product_id' => 3,
                'count' => 1,
            )
        );
        $this->load->model('order_model');
        $this->load->model('product_model');
        //$data['orders'] = $this->order_model->update(5, null, $ordersProductsData);
        //$data['products'] = $this->product_model->get();
        $this->layout->renderPage('main', 'index', null, 'Title');

//        $this->load->model('user_model');
//        $data = $this->user_model->get(1, 2, false, array('MIN(u.id) as minimum'),
//            array('sql' => 'u.role_id IN ('.implode(',', array(1, 2)).') GROUP BY u.id', 'params' =>array()));
//        $this->layout->renderPage('main', 'index', null, 'Title');
//        var_dump($data);
    }
}


