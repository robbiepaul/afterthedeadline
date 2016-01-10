<?php namespace RobbieP\Afterthedeadline\Error;

use RobbieP\Afterthedeadline\Error\ErrorTrait\HasInfo;

class Grammar extends ErrorAbstract
{
    use HasInfo;

    public function toArray()
    {
        //$this->getInfo();

        return [
            'string' => $this->string,
            'description' => $this->description,
            'precontext' => $this->precontext
        ];
    }


}