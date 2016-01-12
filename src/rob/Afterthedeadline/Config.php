<?php


namespace RobbieP\Afterthedeadline;


class Config {

    protected $key;
    protected $lang;

    public function __construct($config)
    {
        if( is_string($config) ) {
            $this->key = $config;
            return;
        }
        $this->fill($config);
    }

    public function get($key)
    {
        return $this->{$key};
    }

    private function fill($config)
    {
        $data = (array) $config;
        foreach($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set($key, $value)
    {
        if(! property_exists($this, $key)) {
            throw new \Exception ('Invalid arguments');
        }
        $this->{$key} = $value;
    }

}