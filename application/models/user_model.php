<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $selectUser = array(
        'u.id',
        'u.email',
        'u.social',
        'u.role_id',
        'ur.name as role_name',
        'u.is_active',
        'u.created_date'
        );

    private $selectUserInfo = array(
        'ui.first_name',
        'ui.last_name',
        'ui.mid_name',
        'ui.phone',
        'ui.fax',
        'ui.company',
        'ui.address_line1',
        'ui.address_line2',
        'ui.is_sign',
        'r.name as region_name',
        'c.name as city_name'
        );

    private $selectNotice = array(
        'p.id',
        'p.title',
        'p.model',
        'p.price',
        'p.description',
        'p.specs',
        'p.image',
        'm.name as manufacturer_name'
    );

    public function getByField($fieldName, $value, $with_info = false)
    {
        if ($with_info) {
            $selectUserInfo = array_merge($this->selectUser, $this->selectUserInfo);
            $this->db->select($selectUserInfo);
            $this->db->join('user_role as ur', 'ur.id = u.role_id', 'left');
            $this->db->join('user_info as ui', 'ui.user_id = u.id', 'left');
            $this->db->join('region as r', 'r.id = ui.region_id', 'left');
            $this->db->join('city as c', 'c.id = ui.city_id', 'left');
        } else {
            $this->db->select($this->selectUser);
            $this->db->join('user_role as ur', 'ur.id = u.role_id', 'left');
        }
        $query = $this->db->get_where('user as u', array($fieldName => $value));
        if ($query->num_rows > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get($startPos = 0, $count = null, $with_info = false, $select = null, $queryData = null)
    {
        if (!is_null($select)) {
            $this->selectUser = array_merge($this->selectUser,$select);
        }

        if ($with_info) {
            $selectUserInfo = array_merge($this->selectUser, $this->selectUserInfo);
            $this->db->select($selectUserInfo);
            $this->db->join('user_info as ui', 'ui.user_id = u.id', 'left');
            $this->db->join('user_role as ur', 'ur.id = u.role_id', 'left');
            $this->db->join('region as r', 'r.id = ui.region_id', 'left');
            $this->db->join('city as c', 'c.id = ui.city_id', 'left');
        } else {
            $this->db->select($this->selectUser);
            $this->db->join('user_role as ur', 'ur.id = u.role_id', 'left');
        }
        $this->db->from('user as u');
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

    public function create($userData = null, $userInfoData = null)
    {
        if (is_null($userData) && is_null($userInfoData)) {
            return false;
        }
        $this->db->trans_start();
            if (!empty($userData) && !is_null($userData) && is_array($userData)) {
                $this->db->insert('user', $userData);
                $user_id = $this->db->insert_id();
            }
            if (!empty($userInfoData) && !is_null($userInfoData) && is_array($userInfoData)) {
                if (isset($user_id)) {
                    $userInfoData['user_id'] = $user_id;
                    $this->db->insert('user_info', $userInfoData);
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

    public function update($user_id, $userData = null, $userInfoData = null)
    {
        if (!is_numeric($user_id) && empty($user_id)) {
            return false;
        }
        $this->db->trans_start();
            if (!empty($userData) && !is_null($userData) && is_array($userData)) {
                $this->db->where('id', $user_id);
                $this->db->update('user', $userData);
            }
            if (!empty($userInfoData) && !is_null($userInfoData) && is_array($userInfoData)) {
                $this->db->where('user_id', $user_id);
                $this->db->update('user_info', $userInfoData);
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

    public function delete($user_id)
    {
        $this->db->where('id', $user_id);
        if ($this->db->delete('user')) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserNotices($userId)
    {
        $this->db->select($this->selectNotice);
        $this->db->join('notice as n', 'n.user_id = u.id', 'left');
        $this->db->join('product as p', 'p.id = n.product_id', 'left');
        $this->db->join('manufacturer as m', 'm.id = p.manufacturer_id', 'left');
        $query = $this->db->get_where('user as u', array('u.id' => $userId));
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function countAll()
    {
        $this->db->count_all('user');
    }

}