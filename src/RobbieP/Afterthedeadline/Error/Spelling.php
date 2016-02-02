<?php

namespace RobbieP\Afterthedeadline\Error;

use RobbieP\Afterthedeadline\Error\ErrorTrait\HasSuggestions;

class Spelling extends ErrorAbstract
{
    use HasSuggestions;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'string'      => $this->string,
            'description' => $this->description,
            'precontext'  => $this->precontext,
            'suggestions' => $this->getSuggestions(),
        ];
    }
}
