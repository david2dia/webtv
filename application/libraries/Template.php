<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
    var $template_data = array();
                
    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    function setLoad($name, $value)
    {
        $this->set($name, $this->CI->load->view($value, null, TRUE)); 
    }
        
    function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
    {               
        $this->CI =& get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));             
        return $this->CI->load->view($template, $this->template_data, $return);
    }

    function parser($template = '', $view = '' , $view_data = array(), $return = FALSE)
    {
    $this->CI =& get_instance();
    $this->CI->load->library('parser');
    $this->set('contents', $this->CI->parser->parse($view, $view_data, TRUE)); 
    return $this->CI->parser->parse($template, $this->template_data, $return);
    }
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */