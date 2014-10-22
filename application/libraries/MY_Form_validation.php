<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Layout
 */
class MY_Form_validation extends CI_Form_validation
{
    function __construct() {
        parent::__construct();
    }
    public function case_sensitive($value,$params)
    {
        $this->CI->load->model('manufacturer_model'); // решить вопрос
        list($tableName, $id, $fieldName) = explode('&', $params);
        if($this->CI->manufacturer_model->is_unique($tableName,$id,$fieldName,$value))
        {
            return TRUE;
        } else {
            $this->set_message('case_sensitive', "Поле должно быть уникальным");
            return FALSE;
        }
    }
}