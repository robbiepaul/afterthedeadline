<?php namespace RobbieP\Afterthedeadline\Error;


abstract class ErrorAbstract
{
    public $string;
    public $description;
        public $precontext;
    public $suggestions;
    public $type;

    /**
     * ErrorAbstract constructor.
     * @param $result
     */
    public function __construct($result)
    {
        $this->fill($result);
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
     * @param $result
     * @throws \Exception
     */
    private function fill($result)
    {
        $data = (array) $result;
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

    /**
     * @return array
     */
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