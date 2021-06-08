<?php

namespace App\UseCases\API;

use Exception;

abstract class RequestData
{
    private $ch;
    private $url;
    private $username;
    private $password;
    private $data;
    private $headers;
    private $response;

    public function __construct(
    ) {
        $this->headers = [];
    }

    protected abstract function decideURLCall($value);

    protected abstract function formatData($data, $headers, $value, $type = 0);

    public function execute($value, $type = 0)
    {
        $this->url = $this->decideURLCall($value);
        return $this->setCurlConnection()
                    ->setHeaderFunctiion()
                    ->returnAPIData()
                    ->formatData($this->data, $this->headers, $value, $type);
    }

    protected function setCurlConnection()
    {
        $this->ch = curl_init();
        $this->username = env('API_USERNAME');
        $this->password = env('API_PASSWORD');
        curl_setopt($this->ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));

        return $this;
    }

    protected function setHeaderFunctiion()
    {
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) {
                    return $len;
                }
                $this->headers[strtolower(trim($header[0]))][] = trim($header[1]);
                return $len;
            }
        );

        return $this;
    }

    protected function returnAPIData()
    {
        $this->response = curl_exec($this->ch);
        $this->data = json_decode($this->response);
        $info  = curl_getinfo($this->ch);
        if ($info['http_code'] !== 200) {
            throw new Exception('Boostorder Product List API Failed while calling url: '.$this->url.' with error code: '.$info['http_code'], $info['http_code']);
        }
        return $this;
    }
}
