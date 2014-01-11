<?php

namespace Core\ToolsBundle\Helper;

use Core\ToolsBundle\Utilities\Url;

class HostHelper
{
    public static function getHost()
    {
        $url = new Url();
        
        return ($url->host);
    }
    
    public static function getSubdomain()
    {
        $url = new Url();
        
        return ($url->subdomain);
    }
    
    public static function getDomain()
    {
        $url = new Url();
        
        return ($url->domain);
    }
    
    public static function getTld()
    {
        $url = new Url();
        
        return ($url->tld);
    }

    public static function getIp()
    {        
        return ($_SERVER['REMOTE_ADDR']);
    }

    public static function getReferer()
    {        
        return ($_SERVER['HTTP_REFERER']);
    }
}
?>