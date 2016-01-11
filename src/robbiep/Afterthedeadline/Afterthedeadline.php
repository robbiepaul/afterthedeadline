<?php namespace RobbieP\Afterthedeadline;

use RobbieP\Afterthedeadline\Config as ATDConfig;

class Afterthedeadline
{
    protected $url = 'service.afterthedeadline.com';

    protected $config;
    protected $client;
    protected $params = [];
    protected $results = [];
    protected $stats = [];
    protected $text;

    public function __construct($data)
    {
        $this->config = new ATDConfig($data);
    }

    public function checkDocument($text, $params = [])
    {
        $this->text = $text;
        $this->setParams($params);
        $response = $this->endpoint('checkDocument');
        $this->results = $response->get();
        return $this;
    }

    public function checkGrammar($text, $params = [])
    {
        $this->text = $text;
        $this->setParams($params);
        $response = $this->endpoint('checkGrammar');
        $this->results = $response->get();
        return $this;
    }

    public function stats($text, $params = [])
    {
        $params['data'] = $text;
        $this->setParams($params);
        $response = $this->endpoint('stats');
        $this->stats = $response->get();
        return $this;
    }

    protected function info($error)
    {
        return $error->getInfo();
    }

    public function getResults()
    {
        if(! empty( $this->results ) ) {
            return $this->results;
        }
        return false;
    }

    public function getFormatted($results = [])
    {
        if(empty($results)) {
            $results = $this->getResults();
        }
        if(!empty($results)) {
            $formatted = new FormatText($this->text, $results);
            return $formatted;
        }

    }

    protected function url($endpoint = '')
    {
        return 'http://' .$this->getLanguage() . $this->url . '/' . $endpoint;
    }

    protected function getClient()
    {
        if( is_null($this->client) ) {
            $this->client = new Client();
        }
        return $this->client;
    }

    protected function getApiKey()
    {
        if( ! $this->hasApiKey() ) {
            throw new \Exception("No API key provided");
        }
        return $this->config->get('key');
    }

    protected function getLanguage()
    {
        if( $this->hasLanguage() ) {
            return $this->config->get('lang') . '.';
        }

    }

    protected function hasApiKey()
    {
        return $this->hasConfigValue('key');
    }

    protected function hasLanguage()
    {
        return $this->hasConfigValue('lang');
    }

    protected function hasConfigValue($key)
    {
        return ! empty( $this->config->get($key) );
    }

    private function setParams($params)
    {
        if(!empty($this->text)) $this->params['data'] = $this->text;
        $this->params['key'] = $this->getApiKey();
        $this->params = array_merge($this->params, $params);
    }

    private function endpoint($string)
    {
        return $this->getClient()->get($this->url($string), $this->params);
    }


}
