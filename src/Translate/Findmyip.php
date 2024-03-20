<?php

namespace Webguosai\Translate;

use Exception;
use Webguosai\HttpClient;

// 来源：https://www.52pojie.cn/thread-1903090-1-1.html
class Findmyip
{
    protected $options = [];

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function translate($query, $to, $from = 'auto')
    {
        $url = 'https://findmyip.net/api/translate.php';

        $data = [
            'text'        => $query,
            'source_lang' => $from,
            'target_lang' => $to,
        ];

        return $this->request($url, $data);
    }

    /**
     * 请求
     *
     * @param $path
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    protected function request($path, array $data = [])
    {
        $response = (new HttpClient())->get($path, $data);

        if ($response->ok()) {
            $json = $response->json();

            if ($json['code'] === 200) {
                return $json['data']['translate_result'];
            }
            throw new Exception($json['error']."[{$json['code']}]");
        }
        throw new Exception($response->getErrorMsg());
    }
}
