<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\HttpRequest;

class HttpRequestTest extends TestCase
{
    public function testHttpPost()
    {
        // 模拟一个简单的 POST 请求
        $url = 'http://example.com/api';
        $param = ['key' => 'value'];
        $httpHeaders = ['Content-Type: application/json'];
        $proxy = '127.0.0.1:8080';
        $http_code = 200;

        // 使用 Mockery 或其他工具来模拟 HTTP 请求
        // 这里假设我们有一个模拟的响应内容
        $mockResponse = '{"status": "success", "data": {"key": "value"}}';

        // 使用 Mockery 来模拟 curl_exec 的返回值
        $curlMock = \Mockery::mock('alias:curl_init');
        $curlMock->shouldReceive('curl_setopt_array')->andReturn(true);
        $curlMock->shouldReceive('curl_exec')->andReturn($mockResponse);
        $curlMock->shouldReceive('curl_getinfo')->andReturn(['http_code' => $http_code]);
        $curlMock->shouldReceive('curl_close')->andReturn(true);

        $response = HttpRequest::httpPost($url, $param, $httpHeaders, $proxy, $http_code);
        $this->assertEquals($mockResponse, $response);
    }

    public function testHttpGet()
    {
        // 模拟一个简单的 GET 请求
        $url = 'http://example.com/api';
        $param = ['key' => 'value'];
        $httpHeaders = ['Content-Type: application/json'];
        $proxy = '127.0.0.1:8080';
        $http_code = 200;

        // 使用 Mockery 或其他工具来模拟 HTTP 请求
        // 这里假设我们有一个模拟的响应内容
        $mockResponse = '{"status": "success", "data": {"key": "value"}}';

        // 使用 Mockery 来模拟 curl_exec 的返回值
        $curlMock = \Mockery::mock('alias:curl_init');
        $curlMock->shouldReceive('curl_setopt_array')->andReturn(true);
        $curlMock->shouldReceive('curl_exec')->andReturn($mockResponse);
        $curlMock->shouldReceive('curl_getinfo')->andReturn(['http_code' => $http_code]);
        $curlMock->shouldReceive('curl_close')->andReturn(true);

        $response = HttpRequest::httpGet($url, $param, $httpHeaders, $proxy, $http_code);
        $this->assertEquals($mockResponse, $response);
    }
}
