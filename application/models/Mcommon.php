<?php

require_once(APPPATH . "models/IncludeModels.php");

class Mcommon extends MY_Model
{

    function _construct()
    {
        parent::_construct();
    }

    public function base64EncodeStr($key)
    {
        return base64_encode(base64_encode(base64_encode($key)));
    }

    public function base64DecodeStr($key)
    {
        return base64_decode(base64_decode(base64_decode($key)));
    }

    public function setCookieData($cookieName, $value)
    {
        $cookie = array(
            'name'   => $cookieName,
            'value'  => $value,
            'expire' =>  86500,
            'secure' => false
        );
        $this->input->set_cookie($cookie);
    }

    public function getCookieData($cookieName)
    {
        return $this->input->cookie($cookieName, false);
    }

    public function getCurrentFullURL()
    {
        $CI =& get_instance();
        $url = $CI->config->site_url($CI->uri->uri_string());
        $full_url = $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;

        return $full_url;
    }

}