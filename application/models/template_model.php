<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model 
{

    private $select = array(
        'c.id',
        'c.name'
    );
    public function getByField($fieldName, $value)
    {
        $this->db->select($this->select);
        $query = $this->db->get_where('city as c', array($fieldName => $value));
        if ($query->num_rows > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    // Old version of get()
    public function get1($startPos = 0,$count = null,$filters = null,$like = null,$likeByField = null,$likeDir = null,$orderByField = null,$orderByDir = 'asc')
    {
        $this->db->select($this->select);
        if (!empty($filters) || !is_null($filters)) {
            foreach($filters as $key => $val){
                if($val == 'null' || $val == 'not null'){
                    $this->db->where($key.' IS '.$val);
                }else{
                    $this->db->where($key,$val);
                }
            }
        }
        if (!empty($like) || !is_null($like)) {
            $this->db->like($likeByField,$like,$likeDir);
        }
        if (!is_null($count)) {
            $this->db->limit($count, $startPos);
        }
        if (!is_null($orderByField)) {
            $this->db->order_by($orderByField,$orderByDir);
        }

        $this->db->from('city as c');

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function get($startPos = 0, $count = null, $select = null, $queryData = null)
    {
        if (!is_null($select)) {
            $this->select = array_merge($this->select, $select);
        }
        $this->db->select($this->select);
        $this->db->from('city as c');
        if (!is_null($queryData)) {
            $this->db->where($this->db->compile_binds($queryData['sql'],$queryData['params']) );
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
            if ($this->db->insert('city', $data)) {
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
            if ($this->db->update('city', $data)) {
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
        if ($this->db->delete('city')) {
            return true;
        } else {
            return false;
        }
	}

    public function countAll()
    {
        $this->db->count_all('city');
    }

}