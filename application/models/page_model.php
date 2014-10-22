<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model
{

    private $select = array(
        'p.id',
        'p.title',
        'p.description',
        'p.keywords',
        'p.content'
    );

    public function getByField($fieldName, $value)
    {
        $this->db->select($this->select);
        $query = $this->db->get_where('page as p', array($fieldName => $value));
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
        $this->db->from('page as p');
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
            if ($this->db->insert('page', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function update($page_id, $data)
    {
        if (!empty($page_id) && $page_id > 0 && !empty($data) && is_array($data)) {
            $this->db->where('id', $page_id);
            if ($this->db->update('page', $data)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function delete($page_id)
    {
        $this->db->where('id', $page_id);
        if ($this->db->delete('page')) {
            return true;
        } else {
            return false;
        }
    }

    public function countAll()
    {
        $this->db->count_all('page');
    }
}