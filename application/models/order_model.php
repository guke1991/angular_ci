<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model
{

    private $selectOrder = array(
        'o.id',
        'o.user_id',
        'o.total_price',
        'o.created_date',
        'o.is_active',
        'cond.name as condition_name'
    );

    private $selectOrderUserinfo = array(
        'ui.first_name',
        'ui.mid_name',
        'ui.last_name',
        'ui.phone',
        'u.email',
        'r.name as region_name',
        'c.name as city_name'
    );

    private $selectOrderProduct = array(
        'p.id',
        'p.title',
        'p.model',
        'p.price',
        'op.count',
        'op.price',
        'p.description',
        'p.specs',
        'p.image',
        'm.name as manufacturer_name'
    );

    public function getByField($fieldName, $value, $with_userinfo = false)
    {
        if ($with_userinfo) {
            $selectOrderUserinfo = array_merge($this->selectOrder, $this->selectOrderUserinfo);
            $this->db->select($selectOrderUserinfo);
            $this->db->join('condition as cond', 'cond.id = o.condition_id', 'left');
            $this->db->join('user_info as ui', 'ui.user_id = o.user_id', 'left');
            $this->db->join('user as u', 'u.id = o.user_id', 'left');
            $this->db->join('region as r', 'r.id = ui.region_id', 'left');
            $this->db->join('city as c', 'c.id = ui.city_id', 'left');
        } else {
            $this->db->select($this->selectOrder);
            $this->db->join('condition as cond', 'cond.id = o.condition_id', 'left');
        }
        $query = $this->db->get_where('order as o', array($fieldName => $value));
        if ($query->num_rows > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get($startPos = 0, $count = null, $withOrderUserInfo = false, $select = null, $queryData = null)
    {
        if (!is_null($select)) {
            $this->selectOrder = array_merge($this->selectOrder, $select);
        }
        if ($withOrderUserInfo) {
            $selectOrderUserInfo = array_merge($this->selectOrder, $this->selectOrderUserinfo);
            $this->db->select($selectOrderUserInfo);
            $this->db->join('condition as cond', 'cond.id = o.condition_id', 'left');
            $this->db->join('user_info as ui', 'ui.user_id = o.user_id', 'left');
            $this->db->join('user as u', 'u.id = o.user_id', 'left');
            $this->db->join('region as r', 'r.id = ui.region_id', 'left');
            $this->db->join('city as c', 'c.id = ui.city_id', 'left');
        } else {
            $this->db->select($this->selectOrder);
            $this->db->join('condition as cond', 'cond.id = o.condition_id', 'left');
        }
        $this->db->from('order as o');
        if (!is_null($queryData)) {
            $this->db->where($this->db->compile_binds($queryData['sql'], $queryData['params']) );
        }
        if (!is_null($count)) {
            $this->db->limit($count, $startPos);
        }
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function create($orderData, $ordersProductsData)
    {
        if (is_null($orderData) && is_null($ordersProductsData)) {
            return false;
        }
        $this->db->trans_start();
            if (!empty($orderData) && !is_null($orderData) && is_array($orderData)) {
                $this->db->insert('order', $orderData);
                $order_id = $this->db->insert_id();
            }
            if (!empty($ordersProductsData) && !is_null($ordersProductsData) && is_array($ordersProductsData)) {
                if (isset($order_id)) {
                    $ordersProductsData['order_id'] = $order_id;
                    $this->db->insert('orders_products', $ordersProductsData);
                }
            }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function update($order_id, $orderData = null, $ordersProductsData = null)
    {
        if (!is_numeric($order_id) && empty($order_id)) {
            return false;
        }
        $this->db->trans_start();
            if (!empty($orderData) && !is_null($orderData) && is_array($orderData)) {
                $this->db->where('id', $order_id);
                $this->db->update('order', $orderData);
            }
            if (!empty($ordersProductsData) && !is_null($ordersProductsData) && is_array($ordersProductsData)) {
                $this->db->where('order_id', $order_id);
                $this->db->update_batch('orders_products', $ordersProductsData, 'product_id');
            }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete($order_id)
    {
        $this->db->where('id', $order_id);
        if ($this->db->delete('order')) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderProducts($orderId)
    {
        $this->db->select($this->selectOrderProduct);
        $this->db->join('orders_products as op', 'op.order_id = o.id', 'left');
        $this->db->join('product as p', 'p.id = op.product_id', 'left');
        $this->db->join('manufacturer as m', 'm.id = p.manufacturer_id', 'left');
        $query = $this->db->get_where('order as o', array('o.id' => $orderId));
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function countAll()
    {
        $this->db->count_all('order');
    }
}