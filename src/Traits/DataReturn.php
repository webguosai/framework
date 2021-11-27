<?php
namespace Webguosai\Traits;

trait DataReturn
{
    public function dataReturn($code = 0, $data = [], $message = 'ok')
    {
        return [
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ];
    }
}