<?php
class CIdip extends Controller {

    function CIdip()
    {
        parent::Controller();
    }

    function recover_get_array($query_string = '')
    {
        $query_string = urldecode($query_string);
        
        $_SERVER['QUERY_STRING'] = $query_string;
        $get_array = array();
        parse_str($query_string,$get_array);
        foreach($get_array as $key => $val) {
            $_GET[$key] = $this->input->xss_clean($val);
            $_REQUEST[$key] = $this->input->xss_clean($val);
        }
    }
    
    function test()
    {
    	echo 'test'; 
    }
}
?> 