<?php

namespace Webguosai\Ai;

use Webguosai\Helper\Arr;
use Webguosai\HttpClient;

/**
 * 百度语音识别
 * key获取地址：https://console.bce.baidu.com/ai/?_=1641611467179&fromai=1#/ai/speech/app/list
 * api:https://ai.baidu.com/ai-doc/IMAGEPROCESS/Ok3bclt78
 *
 */
class BaiduAi
{
    protected $apiKey;
    protected $secretKey;
    protected $client;
    public $access = [];
    public $token;
    public function __construct(string $apiKey, string $secretKey)
    {
        $this->apiKey    = $apiKey;
        $this->secretKey = $secretKey;

        $this->client = new HttpClient([
            'timeout' => 3
        ]);

        // TODO 这里需要使用缓存将token保存,token有效时长为 30天
        $this->token = $this->getToken();
    }

    /**
     * 语音转文字 asr
     * https://ai.baidu.com/ai-doc/SPEECH/ek38lxj1u
     *
     * @param string $path 本地路径或服务器路径(支持:wav/pcm/amr/m4a)
     * @return mixed
     * @throws \Exception
     */
    public function getText(string $path)
    {
        //文件格式
        $format = substr($path, -3); // 文件后缀 wav/pcm/amr 格式 极速版额外支持m4a 格式
        if (!Arr::in($format, ['wav', 'pcm', 'amr', 'm4a'])) {
            throw new \Exception('必须是wav/pcm/amr/m4a格式文件');
        }

        $audio = file_get_contents($path);

        $params = array(
            "dev_pid" => 1537,//  1537 表示识别普通话，使用输入法模型。
            //"lm_id" => $LM_ID,    //测试自训练平台开启此项
            "format"  => $format,
            "rate"    => 16000,//采样率
            "token"   => $this->token,
            "cuid"    => '123456PHP',
            "speech"  => base64_encode($audio),
            "len"     => strlen($audio),
            "channel" => 1,
        );

        $response = $this->client->post('http://vop.baidu.com/server_api', json_encode($params));
        if ($response->ok()) {
            $data = $response->json();

            if ($data['err_no'] === 0) {
                return $data['result'][0];
            }

            throw new \Exception($data['err_msg']);
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 文字转语音 tts
     * https://ai.baidu.com/ai-doc/SPEECH/Ok4nv3mzn
     *
     * @param string $text 文字
     * @param int $format 下载的文件格式, 3：mp3 4： pcm-16k 5： pcm-8k 6. wav(默认)
     * @param array $option 其它选项参考代码注释部分
     * @return mixed
     * @throws \Exception
     */
    public function getAudio(string $text, $format = 6, $option = [])
    {
        $default = [
            'tex'  => urlencode($text), // 为避免+等特殊字符没有编码，此处需要2次urlencode。
            // 发音人选择, 基础音库：0为度小美，1为度小宇，3为度逍遥，4为度丫丫，
            // 精品音库：5为度小娇，103为度米朵，106为度博文，110为度小童，111为度小萌，默认为度小美
            'per'  => 0,
            'spd'  => 5,//语速，取值0-15，默认为5中语速
            'pit'  => 5,//音调，取值0-15，默认为5中语调
            'vol'  => 5,//音量，取值0-9，默认为5中音量
            'aue'  => $format,//下载的文件格式, 3：mp3(default) 4： pcm-16k 5： pcm-8k 6. wav
            'cuid' => '123456PHP',
            'tok'  => $this->token,
            'lan'  => 'zh', //固定参数
            'ctp'  => 1,
        ];
        $default = array_merge($default, $option);

        $response = $this->client->post('http://tsn.baidu.com/text2audio', http_build_query($default));
        if ($response->ok()) {
            $data = $response->json();
            if ($data['err_no']) {
                throw new \Exception($data['err_msg']);
            }

            return $response->body;
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 图片文字识别
     * https://cloud.baidu.com/doc/OCR/s/1k3h7y3db
     *
     * @param string $path 本地路径或服务器路径
     * @return mixed
     * @throws \Exception
     */
    public function image2text(string $path)
    {
        $img = base64_encode(file_get_contents($path));
        $data = [
            'image' => $img
        ];
        $response = $this->client->post('https://aip.baidubce.com/rest/2.0/ocr/v1/accurate_basic?access_token='.$this->token, $data);
        if ($response->ok()) {
            $data = $response->json();

            if ($data) {
                return $data;
            }

            throw new \Exception($response->body);
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 身份证识别
     * https://cloud.baidu.com/doc/OCR/s/rk3h7xzck
     * @param string $path 本地路径或服务器路径
     * @return mixed
     * @throws \Exception
     */
    public function imageIdCard(string $path)
    {
        $img = base64_encode(file_get_contents($path));
        $data = [
            'id_card_side' => "front",
            'image' => $img
        ];

        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token=' . $this->token;
        $response = $this->client->post($url, $data);

        if ($response->ok()) {
            $data = $response->json();
            if ($data['error_msg']) {
                throw new \Exception($data['error_msg']);
            }

            return $data;
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 获取token
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getToken()
    {
        if (!$this->token) {
            $this->access = $this->getAccessData();
            return $this->access['access_token'];
        }

        return $this->token;
    }

    /**
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getAccessData()
    {
        $url = "http://aip.baidubce.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$this->apiKey."&client_secret=".$this->secretKey;
        $response = $this->client->get($url);

        if ($response->ok()) {
            $data = $response->json();

            if ($data) {
                return $data;
            }

            throw new \Exception($response->body);
        }

        throw new \Exception($response->getErrorMsg());
    }

}
