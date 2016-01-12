<?php namespace RobbieP\Afterthedeadline\Error;


abstract class ErrorAbstract
{
    public $string;
    public $description;
        public $precontext;
    public $suggestions;
    public $type;

    public function __construct($result)
    {
        $this->fill($result);
    }

    public function get($key)
    {
        return $this->{$key};
    }

    private function fill($result)
    {
        $data = (array) $result;
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

    public function toArray()
    {
        return [
            'string' => $this->string,
            'description' => $this->description,
            'precontext' => $this->precontext,
            'suggestions' => $this->suggestions,
        ];
    }

}