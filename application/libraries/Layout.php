<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Layout
 */
class Layout {
    /**
     * Page title
     * @var string
     */
    private $_title = 'My Site';
    /**
     * Page scripts array( array('attr'=>'val','atr2'=>'val2'), )
     * @var array
     */
    private $_script = array();
    /**
     * Page links array( array('attr'=>'val','atr2'=>'val2'), )
     * @var array
     */
    private $_link = array();
    /**
     * Page metas array( array('attr'=>'val','atr2'=>'val2'), )
     * @var array
     */
    private $_meta = array();
    /**
     * Controller Instance
     * @var CI_Controller
     */
    private $_CI;
    /**
     * Current side of site
     * @var string
     */
    private $_siteSide = 'admin';
    /**
     * Layout theme
     * @var string
     */
    private $_themeName = 'main';
    /**
     * Layout parts array('header','footer',)
     * @var array
     */
    private $_parts = array();
    /**
     * Data for Layout parts
     * @var array
     */
    private $_partsData = array();
    /**
     * Any options array('key'=>'val',)
     * @var array
     */
    private $_options = array();

    /**
     * Params when manually load lib (siteSide,themeName)
     * @param null $params
     */
    public function __construct($params = null){
        $this->_CI = &get_instance();
        if(!is_null($params) && is_array($params)){
            if(isset($params['siteSide']) && is_string($params['siteSide'])){
                $this->_siteSide = $params['siteSide'];
            }
            if(isset($params['themeName']) && is_string($params['themeName'])){
                $this->_themeName = $params['themeName'];
            }
        }
        $this->setParts(array('header','footer'));
        $this->_loadConfig();
    }

    /**
     * Load tags from config file
     * @param string $configPath
     * @param string $moduleName
     * @param string $viewName
     */
    private function _loadConfig($configPath = '',$moduleName = '',$viewName = ''){
        if(!empty($configPath)){
            $this->_CI->config->load($configPath);
        }else if(!empty($moduleName) && !empty($viewName)){
            $this->_CI->config->load('../views/'.$this->_siteSide.'/modules/'.$moduleName.'/config/config');
        }else{
            $this->_CI->config->load('../views/'.$this->_siteSide.'/layout/'.$this->_themeName.'/config/config');
        }
        if(!empty($moduleName) && !empty($viewName)){
            $links = $this->_CI->config->item('links',$viewName);
            $scripts = $this->_CI->config->item('scripts',$viewName);
            $meta = $this->_CI->config->item('metas',$viewName);
            $options =  $this->_CI->config->item('options',$viewName);
            $title =  $this->_CI->config->item('title',$viewName);
        }else{
            $links = $this->_CI->config->item('links');
            $scripts = $this->_CI->config->item('scripts');
            $meta = $this->_CI->config->item('metas');
            $layoutParts = $this->_CI->config->item('layoutParts');
            $options =  $this->_CI->config->item('options');
            $title =  $this->_CI->config->item('title');
        }

        if($links && !empty($links)){
            foreach($links as $attributes){
                $this->addTag('link',$attributes);
            }
        }
        if($scripts && !empty($scripts)){
            foreach($scripts as $attributes){
                $this->addTag('script',$attributes);
            }
        }
        if($meta && !empty($meta)){
            foreach($meta as $attributes){
                $this->addTag('meta',$attributes);
            }
        }
        if($options && !empty($options)){
            foreach($options as $name => $val){
                $this->setOption($name,$val);
            }
        }
        if(isset($layoutParts) && $layoutParts && !empty($layoutParts)){
            $this->setParts($layoutParts);
        }
        if($title && !empty($title)){
            $this->setTitle($title);
        }
    }

    /**
     * Set Layout parts
     * @param array $parts
     * @return bool
     */
    public function setParts($parts = array()){
        if(!empty($parts) && is_array($parts)){
            $this->_parts = $parts;
            foreach($this->_parts as $part){
                $this->_partsData[$part] = array();
            }
        }else{
            return false;
        }
        return true;
    }

    /**
     * Set data for Layout part
     * @param string $partName 'header','footer',
     * @param array $data
     * @return bool
     */
    public function setPartData($partName,$data = array()){
        if(!empty($data) && is_array($data) && in_array($partName,$this->_parts)){
            $this->_partsData[$partName] = $data;
        }else{
            return false;
        }
        return true;
    }

    /**
     * Set option
     * @param string $name
     * @param $val
     */
    public function setOption($name,$val){
        $this->_options[$name] = $val;
    }

    /**
     * Get Option
     * @param string $name
     * @return bool
     */
    public function getOption($name){
        if(isset($this->_options[$name])){
            return $this->_options[$name];
        }else{
            return false;
        }
    }

    /**
     * Set page title
     * @param string $title
     */
    public function setTitle($title){
       if(!empty($title) && is_string($title)){
           $this->_title = $title;
       }
   }

    /**
     * get title
     * @return string
     */
    public function getTitle(){
        return $this->_title;
    }


    /**
     * Add tag to layout
     * @param $tagType 'script','link','meta'
     * @param array $attributes array('src'=>'/blabla')
     * @return bool
     */
    public function addTag($tagType,$attributes){
        switch($tagType){
            case 'link':
                $flag = false;
                if(!empty($this->_link)){
                    foreach($this->_link as $linkAttr){
                        if((isset($linkAttr['href']) && isset($attributes['href']) )
                            && ($linkAttr['href'] == $attributes['href'])){
                            $flag = true;
                            break;
                        }
                    }
                    if(!$flag){
                        $this->_link[] = $attributes;
                    }
                }else{
                    $this->_link[] = $attributes;
                }

                break;
            case 'script':
                $flag = false;
                if(!empty($this->_script)){
                    foreach($this->_script as $scriptAttr){
                        if((isset($scriptAttr['src']) && isset($attributes['src']) )
                            && ($scriptAttr['src'] == $attributes['src'])){
                            $flag = true;
                            break;
                        }
                    }
                    if(!$flag){
                        $this->_script[] = $attributes;
                    }
                }else{
                    $this->_script[] = $attributes;
                }
                break;
            case 'meta':
                $flag = false;
                if(!empty($this->_meta)){
                    foreach($this->_meta as $metaAttr){
                        if((isset($metaAttr['name']) && isset($attributes['name']) )
                            && ($metaAttr['name'] == $attributes['name'])){
                            $flag = true;
                            break;
                        }
                    }
                    if(!$flag){
                        $this->_meta[] = $attributes;
                    }
                }else{
                    $this->_meta[] = $attributes;
                }
                break;
            default:
                return false;
                break;
        }
        return true;
    }

    /**
     * Get tags html
     * @return string
     */
    public function renderTags(){
        $html = '';
        $html .= '<title>'.$this->_title.'</title>';
        if(!empty($this->_link) && is_array($this->_link)){
            $html .= "\n\t";
            foreach($this->_link as $attributes){
                $attributesHtml = '';
                if(!empty($attributes) && is_array($attributes)){
                    foreach($attributes as $attrName => $attrVal){
                        if($attrName != 'rel' && $attrName != 'type'){
                            $attributesHtml .= $attrName.'='.$attrVal.' ';/////
                        }
                    }
                }
                $html .= '<link '.
                    'rel="'.(isset($attributes['rel'])?$attributes['rel'] : 'stylesheet').'"'.
                    'type="'.(isset($attributes['type'])?$attributes['type'] : 'text/css').'"'.
                    ' '.$attributesHtml.' />';
            }
        }
        if(!empty($this->_script) && is_array($this->_script)){
            $html .= "\n\t";
            foreach($this->_script as $attributes){
                $attributesHtml = '';
                if(!empty($attributes) && is_array($attributes)){
                    foreach($attributes as $attrName => $attrVal){
                        if($attrName != 'type'){
                            $attributesHtml .= $attrName.'='.$attrVal.' ';/////
                        }
                    }
                }
                $html .= '<script '.
                'type="'.(isset($attributes['type'])?$attributes['type'] : 'text/javascript').'"'.
                (isset($attributes['text']) ?(' >'.$attributes['text'].' </script>') : (' '.$attributesHtml.' ></script>'));

            }
        }
        if(!empty($this->_meta) && is_array($this->_meta)){
            $html .= "\n\t";
            foreach($this->_meta as $attributes){
                $attributesHtml = '';
                if(!empty($attributes) && is_array($attributes)){
                    foreach($attributes as $attrName => $attrVal){
                        $attributesHtml .= $attrName.'='.$attrVal.' ';/////
                    }
                    $html .= '<meta '.$attributesHtml.' />';
                }
            }
        }
        return $html;
    }

    /**
     * render view or return view (and add view tags to layout)
     * @param $moduleName
     * @param $viewName
     * @param null $data
     * @param bool $return view as string
     * @param bool $toLayout add tags to layout?
     * @return bool|void
     */
    public function renderPartial($moduleName,$viewName,$data = null,$return = false,$toLayout = true)
    {
        if(is_null($data)){
            $data = array();
        }
        if(is_array($data) && is_string($moduleName) && is_string($viewName)){
            $view = false;
            if($return){
                $view = $this->_CI->load->view($this->_siteSide.'/modules/'.$moduleName.'/'.$viewName,$data,$return);
                if($toLayout){
                    $this->_loadConfig('',$moduleName,$viewName);
                }

            }else{
                $this->_CI->load->view($this->_siteSide.'/modules/'.$moduleName.'/'.$viewName,$data,$return);

                return true;
            }
            return $view;
        }else{
            return false;
        }
    }

    /**
     * render content with layout
     * @param string $moduleName
     * @param string $viewName
     * @param null $contentData
     * @param string $title
     */
    public function renderPage($moduleName = '',$viewName = '',$contentData = null,$title = '')
    {
        if(is_null($contentData)){
            $data = array();
        }
        if(empty($moduleName) && empty($viewName)){
            $data['content'] = '';
        }else{
            $data['content'] = $this->_CI->load->view($this->_siteSide.'/modules/'.$moduleName.'/'.$viewName,$contentData,true);
            $this->_loadConfig('',$moduleName,$viewName);
        }
        if(!empty($this->_parts)){
            foreach($this->_parts as $part){
                $data[$part] = $this->_CI->load->view(''.$this->_siteSide.'/layout/'.$this->_themeName.'/'.$part,$this->_partsData[$part],true);
                $this->_loadConfig('../views/'.$this->_siteSide.'/layout/'.$this->_themeName.'/config/config','none',$part);// load scripts for layout part
            }
        }

        if(!empty($title)){
            $this->setTitle($title);
        }

        $data['tags'] = $this->renderTags();

        $this->_CI->load->view(''.$this->_siteSide.'/layout/'.$this->_themeName.'/template',$data);
    }
}