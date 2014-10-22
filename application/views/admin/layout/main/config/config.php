<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['title'] = 'My Site';
$config['metas'] = array(
    array('charset' => 'utf-8')
);
$config['links'] = array(
    array('href' => '/assets/library/Bootstrap/3.1.1/css/bootstrap.min.css'),
    array('href' => '/assets/css/admin/layout/main/style.css'),
    array('href' => '/assets/css/common/style.css'),
);
$config['scripts'] = array(
    array('src' => '/assets/library/Jquery/2.1.1.min.js'),
    array('src' => '/assets/library/Bootstrap/3.1.1/js/bootstrap.min.js'),
);
$config['layoutParts'] = array('header','footer');

$config['header']['links'] = array(
    array('href' => '/assets/css/admin/layout/main/header.css'),
);

