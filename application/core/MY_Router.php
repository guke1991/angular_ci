<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    class MY_Router extends CI_Router {
        
        function _validate_request($segments){
            if (count($segments) == 0)
                return $segments;

            if (file_exists(APPPATH . 'controllers/' . $segments[0] . EXT))
                return $segments;

            if (is_dir(APPPATH . 'controllers/' . $segments[0])){
                $dir = '';
                do {
                    if (strlen($dir) > 0)
                        $dir .= '/';

                    $dir .= $segments[0];
                    $segments = array_slice($segments, 1);
                } while (count($segments) > 0 && is_dir(APPPATH . 'controllers/' . $dir . '/' . $segments[0]));
           
                $this->set_directory($dir);

                if (count($segments) > 0 && ! file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . $segments[0] . EXT))
                    array_unshift($segments, $this->default_controller);

                if (count($segments) > 0){
                    if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . $segments[0] . EXT))
                        $this->directory = '';
                } else {
                    if (strpos($this->default_controller, '/') !== FALSE){
                        $x = explode('/', $this->default_controller);

                        $this->set_class($x[0]);
                        $this->set_method($x[1]);
                    } else {
                        $this->set_class($this->default_controller);
                        $this->set_method('index');
                    }

                    if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . $this->default_controller . EXT)){
                        $this->directory = '';
                        return array();
                    }
                }

                return $segments;
            }

            if (!empty($this->routes['404_override'])){
                $x = explode('/', $this->routes['404_override']);

                $this->set_class($x[0]);
                $this->set_method(isset($x[1]) ? $x[1] : 'index');

                return $x;
            }

            show_404($segments[0]);
        }

        function set_directory($dir){
            $this->directory = str_replace(array('.'), '', $dir) . '/';
        }


    }