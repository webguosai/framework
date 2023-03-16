<?php

namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

/**
 * 谷歌翻译云接口
 * 文档：https://cloud.google.com/translate/docs/reference/rest/v2/translate
 * 注意需要科学上网
 *
 * 演示：
new Google([
    'key'  => 'AIzaSyC1pvAVod6kZa5g8LOhArHrAchbLHEXUd0',
    'http' => [
        'proxyIps' => ['127.0.0.1:9528']
    ]
]);
 */
class Google
{
    protected $apiUrl = 'https://translation.googleapis.com/language/translate/v2';
    protected $options = [
        'key' => '',
        'http' => [
            'proxyIps' => ['']
        ],
    ];

    public function __construct($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * 翻译
     * https://cloud.google.com/translate/docs/reference/rest/v2/translate
     *
     * @param string $query 翻译的内容
     * @param string $to 要翻译的语言 (zh-CH,en)
     * @param string $from 翻译内容的语言，auto = 自动检测
     * @return mixed
     * @throws Exception
     */
    public function translate($query, $to, $from = '')
    {
        $data = [
            'q'      => $query,
            'source' => $from,
            'target' => $to,
        ];
        return $this->request('', $data)['data']['translations'][0]['translatedText'];
    }

    /**
     * 请求
     *
     * @param $path
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    protected function request($path, $data = [])
    {
        $data['key'] = $this->options['key'];
        $response = (new HttpClient($this->options['http']))->get($this->apiUrl . $path, $data);

        if ($response->ok()) {
            return $response->json();
        }
        throw new Exception($response->getErrorMsg());
    }
}
