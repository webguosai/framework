<?php

namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

class Translatedlabs
{
    protected $apiUrl = 'https://api.translatedlabs.com/language-identifier/identify';

    /**
     * https://translatedlabs.com/%E8%AF%AD%E8%A8%80%E8%AF%86%E5%88%AB%E5%99%A8
     * @param $query
     * @return mixed
     * @throws Exception
     */
    public function language($query)
    {
        $data = [
            'etnologue'  => true,
            'text'       => $query,
            'uiLanguage' => 'zh',
        ];

        return $this->request($data)['code'];
    }

    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function request($data)
    {
        $response = (new HttpClient(['timeout' => 5]))->post($this->apiUrl, $data);

        if ($response->ok()) {
            return $response->json();
        }

        throw new Exception($response->getErrorMsg());
    }
}
