<?php namespace RobbieP\Afterthedeadline\Error\ErrorTrait;

trait HasInfo
{
    public $url;
    public $hint_html;
    public $hint_text;

    public function getInfo()
    {
        try {
            $this->hint_html = preg_replace( "/\r|\n/", "", @file_get_contents($this->url) );
            $this->hint_text = strip_tags($this->hint_html);
        } catch (\Exception $e) {
            sleep(1);
            $this->getInfo();
        }
    }
}