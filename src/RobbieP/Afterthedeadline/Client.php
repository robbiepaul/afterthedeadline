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

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->adapter = new \GuzzleHttp\Client();
        $this->response = new Response();
    }

    /**
     * @param $url
     * @param $params
     * @return Response
     */
    public function get($url, $params)
    {
        $body = [
            'query' => $params
        ];
        $response = $this->adapter->get($url, $body);

        $this->response->setResponse($response);

        return $this->response;
    }

    /**
     * @param $url
     * @param $params
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    public function post($url, $params)
    {
        $body = [
            'body' => $params
        ];
        $response = $this->adapter->post($url, $body);
        return $response;
    }

}