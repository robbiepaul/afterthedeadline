<?php namespace RobbieP\Afterthedeadline;


use LaLit\XML2Array;

class Response {

    protected $xml;

    /**
     * @param $response
     */
    public function setResponse($response)
    {
        if($response instanceof \GuzzleHttp\Message\Response) {
            $this->xml = ''.$response->getBody();
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        $array = XML2Array::createArray( $this->xml );
        if(isset($array['results']))  {
            $result = new Result($array['results']);
            return $result->toArray();
        }
        if(isset($array['stats']))  {
            return $array['stats'];
        }
        return $array;
    }

}