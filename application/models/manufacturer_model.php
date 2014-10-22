<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturer_model extends MY_Model
{

    private $select = array(
        'm.id',
        'm.name',
        'm.category_id',
        'cat.name as category_name'
    );

    public function getByField($fieldName,$value)
    {
        $this->db->select($this->select);
        $this->db->join('category as cat', 'm.category_id = cat.id', 'left');
        $query = $this->db->get_where('manufacturer as m', array($fieldName => $value));
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
        $this->db->join('category as cat', 'm.category_id = cat.id', 'left');
        $this->db->from('manufacturer as m');
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
            if ($this->db->insert('manufacturer', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function update($id, $data)
    {
        if (!empty($id) && $id > 0 && !empty($data) && is_array($data)) {
            $this->db->where('id', $id);
            if ($this->db->update('manufacturer', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('manufacturer')) {
            return true;
        } else {
            return false;
        }
    }

    public function countAll()
    {
        $this->db->count_all('manufacturer');
    }


}