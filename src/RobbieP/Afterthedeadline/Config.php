<?php


namespace RobbieP\Afterthedeadline;


class Config {

    protected $key;
    protected $lang;

    /**
     * Config constructor.
     * @param $config
     */
    public function __construct($config)
    {
        if( is_string($config) ) {
            $this->key = $config;
            return;
        }
        $this->fill($config);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->{$key};
    }

    /**
     * @param $config
     * @throws \Exception
     */
    private function fill($config)
    {
        $data = (array) $config;
        foreach($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     * @throws \Exception
     */
    public function set($key, $value)
    {
        if(! property_exists($this, $key)) {
            throw new \Exception ('Invalid arguments');
        }
        $this->{$key} = $value;
    }

}