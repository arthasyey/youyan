<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mem {

	private $_memCo;
	public $mem;
	public $memClass;

	public function __construct() {

		include(APPPATH.'config/database'.EXT);
		if(!isset($mem) || count($mem) == 0) {
			show_error('No database connection settings were found in the database config file.');
		}

		$this->_memCo = $mem;
		
		$dbConfArr = array();
		foreach($this->_memCo as $val) {
			$dbConfArr[] = array($val['host'], $val['port'], $val['weight']);
		}
		
		$this->mem = $this->connect($dbConfArr);
	}

	public function __destruct() {
		
	}

	public function connect($dbConfArr) {
		if(class_exists('Memcached')) {
			$mem = new Memcached;
			$mem->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);	// 设置环形哈希算法
			$mem->setOption(Memcached::OPT_NO_BLOCK, true);	// 设置非阻塞传输模式
			$mem->setOption(Memcached::OPT_POLL_TIMEOUT, 200);	// 设置连接超时
			$mem->addServers($dbConfArr);
			$this->memClass = 'Memcached';
			return $mem;
		} else if(class_exists('Memcache')) {
			$mem = new Memcache;
			foreach($dbConfArr as $val) {
				$mem->addServer($val[0], $val[1]);
			}
			$this->memClass = 'Memcache';
			return $mem;
		}
	}

	public function add($key, $value, $expire = 0) {
		if($this->memClass == 'Memcached') {
			return $this->mem->add(trim($key), $value, $expire);
		} else if($this->memClass == 'Memcache') {
			return $this->mem->add(trim($key), $value, false, $expire);
		}
	}
	
	public function set($key, $value, $expire = 0) {
		if($this->memClass == 'Memcached') {
			return $this->mem->set(trim($key), $value, $expire);
		} else if($this->memClass == 'Memcache') {
			return $this->mem->set(trim($key), $value, false, $expire);
		}
	}
	
	public function get($key) {
		if(MEM_STATUS == false) {
			return false;
		} else {
			return $this->mem->get(trim($key));
		}
	}
	
	public function delete($key, $time = 0) {
		return $this->mem->delete(trim($key), $time);
	}

}