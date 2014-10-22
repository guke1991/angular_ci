<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{

    private $select = array(
        'p.id',
        'p.title',
        'p.model',
        'p.manufacturer_id',
        'p.price',
        'p.amount',
        'p.description',
        'p.specs',
        'p.image',
        'p.created_date',
        'p.updated_date',
        'm.name as manufacturer_name'
    );

    public function getByField($fieldName,$value)
    {
        $this->db->select($this->select);
        $this->db->join('manufacturer as m', 'm.id = p.manufacturer_id', 'left');
        $query = $this->db->get_where('product as p', array($fieldName => $value));
        if ($query->num_rows > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get($startPos = 0, $count = null, $select = null, $queryData = null)
    {
        if (!is_null($select)) {
            $this->select = array_merge($this->select, $select);
        }
        $this->db->select($this->select);
        $this->db->join('manufacturer as m', 'm.id = p.manufacturer_id', 'left');
        $this->db->from('product as p');
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

    public function create($data = array())
    {
        if (!empty($data) && !is_null($data) && is_array($data)) {
            if ($this->db->insert('product', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function update($product_id, $data)
    {
        if (!empty($id) && $id > 0 && !empty($data) && is_array($data)) {
            $this->db->where('id', $product_id);
            if ($this->db->update('product', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function delete($product_id)
    {
        $this->db->where('id', $product_id);
        if ($this->db->delete('product')) {
            return true;
        } else {
            return false;
        }
    }

    public function countAll()
    {
        $this->db->count_all('product');
    }
}