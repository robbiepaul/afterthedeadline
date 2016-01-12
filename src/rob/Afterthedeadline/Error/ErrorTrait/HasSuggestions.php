<?php namespace RobbieP\Afterthedeadline\Error\ErrorTrait;


trait HasSuggestions
{
    public function getSuggestions()
    {
        return  $this->suggestions['option'];
    }
}