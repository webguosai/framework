<?php

namespace Webguosai\Console;

class Issue implements ConsoleInterface {

    public $define = [
        'meta' => '生成target方法索引提示',
    ];


    public function getDefine(): array {
        return [
            'meta' => '生成PhpStorm索引提示'
        ];
    }

    public function default($param) {
        return $this->meta($param);
    }

    public function meta($param) {
        return 'ok';
    }

}