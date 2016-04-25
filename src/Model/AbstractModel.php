<?php

namespace Shokai\Model;

abstract class AbstractModel
{
    const ID            = 'id';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    
    protected $defaults = [];
    protected $data = [];

    public function __construct(array $params = [])
    {
        if (empty($this->defaults)) {
            $this->data = $params;
        } else {
            $this->data = array_merge($this->defaults, $params);
        }
    }

    public function get($name, $default = null)
    {
        return isset($this->data[$name]) ? $this->data[$name] : $default;
    }

    public function set($name, $value)
    {
        return $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            return $this->$name = $value;
        }
        return $this->data[$name] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data = [])
    {
        $this->data = array_merge($this->data, $data);
    }

    public function setId($id)
    {
        $this->data['id'] = $id;
    }

    public function getId()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function getDateTime($name)
    {
        return new \DateTime($this->data[$name]);
    }

    public function setDateTime($name, \DateTime $dt)
    {
        return $this->data[$name] = $dt->format('Y-m-d H:i:s');
    }
}
