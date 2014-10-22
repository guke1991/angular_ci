<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region_model extends CI_Model
{

    private $select = array(
        'r.id',
        'r.name'
    );

    public function getByField($fieldName, $value)
    {
        $this->db->select($this->select);
        $query = $this->db->get_where('region as r', array($fieldName => $value));
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
        $this->db->from('region as r');
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

    public function countAll()
    {
        $this->db->count_all('region');
    }
}