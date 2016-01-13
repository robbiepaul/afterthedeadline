<?php namespace RobbieP\Afterthedeadline\Error;

use RobbieP\Afterthedeadline\Error\ErrorTrait\HasInfo;
use RobbieP\Afterthedeadline\Error\ErrorTrait\HasSuggestions;

class Suggestion extends ErrorAbstract
{
    use HasSuggestions, HasInfo;

    /**
     * @return array
     */
    public function toArray()
    {
        //$this->getInfo();

        return [
            'string' => $this->string,
            'description' => $this->description,
            'precontext' => $this->precontext,
            'suggestions' => $this->getSuggestions()
        ];
    }

}