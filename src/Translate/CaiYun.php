<?php

namespace Webguosai\Translate;

class CaiYun
{
    protected $options = [
        'token' => '',
    ];
    protected $apiUrl = 'http://api.interpreter.caiyunai.com/v1/translator';

    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * 翻译
     * https://docs.caiyunapp.com/blog/2018/09/03/lingocloud-api/
     *
     * @param string $query
     * @param string $to
     * @param string $from zh|en|ja
     * @return mixed
     * @throws \Exception
     */
    public function translate($query, $to, $from = 'auto')
    {
        $data = json_encode([
            'source'     => $query,
            'trans_type' => "{$from}2{$to}",
            'request_id' => "demo",
            'detect'     => true,
        ]);

        return $this->request($data)['target'];
    }

    protected function request($data)
    {
        $headers  = [
            "x-authorization" => "token " . $this->options['token'],
        ];
        $response = (new \Webguosai\HttpClient(['timeout' => 5]))->post($this->apiUrl, $data, $headers);

        if ($response->ok()) {
            return $response->json();
        }

        throw new \Exception($response->getErrorMsg());
    }
}
