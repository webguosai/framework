<?php

require_once '../vendor/autoload.php';

//sleep(5);

$js = file_get_contents('js.txt');

if ($js % 5 !== 0) {
    \Webguosai\Http\HttpHeader::setHttpCode(502);

    echo json_encode([
        'code' => 1,
        'message' => 'error - ' . $js
    ]);
} else {
    echo json_encode([
        'code' => 0,
        'message' => 'ok - ' . $js
    ]);
}



file_put_contents('js.txt', $js+1);