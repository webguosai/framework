<?php

use PHPUnit\Framework\TestCase;
use Webguosai\Factory;

final class FactorTest extends TestCase
{
    public function testCall(): void
    {
        $client = Factory::make('HttpClient', ['timeout' => 3]);
        $response = $client->get('http://www.baidu.com');

        $this->assertSame(200, $response->httpStatus);
    }
}