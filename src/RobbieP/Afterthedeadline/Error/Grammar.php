<?php

namespace RobbieP\Afterthedeadline\Error;

use RobbieP\Afterthedeadline\Error\ErrorTrait\HasInfo;

class Grammar extends ErrorAbstract
{
    use HasInfo;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'string'      => $this->string,
            'description' => $this->description,
            'precontext'  => $this->precontext,
            'url'         => $this->url,
        ];
    }
}
