<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    public function is_unique($tableName,$id,$fieldName,$value)
    {
        $current = $this->db->get_where($tableName,array('id' => $id));
        $current = $current->row_array();
        if ($value !== $current[$fieldName]) {
            $this->db->where_not_in('id', array($id));
            $result = $this->db->get_where($tableName, array($fieldName => $value));
            if ($result->num_rows() > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
}