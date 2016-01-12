<?php
/**
 * Created by PhpStorm.
 * User: robbiepaul
 * Date: 20/04/15
 * Time: 16:51
 */

namespace RobbieP\Afterthedeadline;

class Client {

    protected $adapter;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->adapter = new \GuzzleHttp\Client();
        $this->response = new Response();
    }

    public function get($url, $params)
    {
        $body = [
            'query' => $params
        ];
        $response = $this->adapter->get($url, $body);

        $this->response->setResponse($response);

        return $this->response;
    }

    public function post($url, $params)
    {
        $body = [
            'body' => $params
        ];
        $response = $this->adapter->post($url, $body);
        return $response;
    }

}