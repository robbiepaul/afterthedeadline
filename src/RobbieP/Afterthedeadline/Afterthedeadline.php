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

    /**
     * Afterthedeadline constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->config = new ATDConfig($data);
    }

    /**
     * @param $text
     * @param array $params
     * @return $this
     */
    public function checkDocument($text, $params = [])
    {
        $this->text = $text;
        $this->setParams($params);
        $response = $this->endpoint('checkDocument');
        $this->results = $response->get();
        return $this;
    }

    /**
     * @param $text
     * @param array $params
     * @return $this
     */
    public function checkGrammar($text, $params = [])
    {
        $this->text = $text;
        $this->setParams($params);
        $response = $this->endpoint('checkGrammar');
        $this->results = $response->get();
        return $this;
    }

    /**
     * @param $text
     * @param array $params
     * @return $this
     */
    public function stats($text, $params = [])
    {
        $params['data'] = $text;
        $this->setParams($params);
        $response = $this->endpoint('stats');
        $this->stats = $response->get();
        return $this;
    }

    /**
     * @param $error
     * @return mixed
     */
    protected function info($error)
    {
        return $error->getInfo();
    }

    /**
     * @return array|bool
     */
    public function getResults()
    {
        if(! empty( $this->results ) ) {
            return $this->results;
        }
        return false;
    }

    /**
     * @param array $results
     * @return FormatText
     */
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

    /**
     * @param string $endpoint
     * @return string
     */
    protected function url($endpoint = '')
    {
        return 'http://' .$this->getLanguage() . $this->url . '/' . $endpoint;
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if( is_null($this->client) ) {
            $this->client = new Client();
        }
        return $this->client;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getApiKey()
    {
        if( ! $this->hasApiKey() ) {
            throw new \Exception("No API key provided");
        }
        return $this->config->get('key');
    }

    /**
     * @return string
     */
    protected function getLanguage()
    {
        if( $this->hasLanguage() && ($lang = $this->config->get('lang') !== 'en') ) {
            return $lang . '.';
        }
    }


    /**
     *  French - fr.service.afterthedeadline.com
     *  German - de.service.afterthedeadline.com
     *  Portuguese - pt.service.afterthedeadline.com
     *  Spanish - es.service.afterthedeadline.com
     *
     * @param $lang
     * @return $this
     * @throws \Exception
     */
    public function setLanguage($lang)
    {
        if(strlen($lang) !== 2) {
            throw new \Exception("setLanguage only accepts the 2 letter country code");
        }
        $this->config->set('lang', strtolower($lang));
        return $this;
    }

    /**
     * @return bool
     */
    protected function hasApiKey()
    {
        return $this->hasConfigValue('key');
    }

    /**
     * @return bool
     */
    protected function hasLanguage()
    {
        return $this->hasConfigValue('lang');
    }

    /**
     * @param $key
     * @return bool
     */
    protected function hasConfigValue($key)
    {
        return ! empty( $this->config->get($key) );
    }

    /**
     * @param $params
     * @throws \Exception
     */
    private function setParams($params)
    {
        if(!empty($this->text)) $this->params['data'] = self::filterText($this->text);
        $this->params['key'] = $this->getApiKey();
        $this->params = array_merge($this->params, $params);
    }

    /**
     * @param $string
     * @return Response
     */
    private function endpoint($string)
    {
        return $this->getClient()->get($this->url($string), $this->params);
    }

    /**
     * Gets rid of @usernames and #hashtags
     *
     * @param $text
     * @return mixed
     */
    public static function filterText($text)
    {
        $text = preg_replace('/[#@](\w+)/i', '', $text);
        return $text;
    }


}
