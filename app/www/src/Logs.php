<?php
namespace Root\Www;

class Logs 
{   
    private $memcached;
    private $key = 'lists_log';

    public function __construct() 
    {  
        $this->init();
    }

    private function init()
    {
        $this->memcached = new \Memcached;
        $this->memcached->addServer('mcrouter', 11211);
    }

    private function set($key, $value)
    {
        $this->memcached->set($key, $value);
    }

    private function get($key)
    {
        return $this->memcached->get($key);
    }

    public function addRow($str)
    {
        $list = $this->get($this->key);
        if(!$list) 
            $list = [];
        $row = 'HOSTNAME:&nbsp;'.$_SERVER['HOSTNAME'].'&nbsp;&nbsp;IP_USER:&nbsp;'.$_SERVER['REMOTE_ADDR'].'&nbsp;&nbsp;'.$str;    
        array_push($list, $row);
        $this->set($this->key, $list);
    }

    public function getList()
    {
        return $this->get($this->key);
    }
}
