<?php

namespace Fileupload\Classes;

class Registry
{
	public $storage = array();

	public function set($key, $value)
	{
		$this->storage[$key] = $value;
	}
	public function get($key)
	{
		if (!empty($this->storage[$key])) return $this->storage[$key];
	}
	public function getAll()
	{
		return $this->storage;
	}

	public function clean()
	{
		$this->storage = array();
		return true;
	}
}
