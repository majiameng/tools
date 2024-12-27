<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\UrlTool;

class UrlToolTest extends TestCase
{
    public function testGetMainDomain_HostExists_ReturnsMainDomain()
    {
        $url = "http://sub.example.com";
        $expected = "example.com";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testGetMainDomain_HostMissing_ReturnsMainDomain()
    {
        $url = "sub.example.com";
        $expected = "example.com";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testGetMainDomain_Localhost_ReturnsEmpty()
    {
        $url = "http://localhost";
        $expected = "";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testGetMainDomain_127_0_0_1_ReturnsEmpty()
    {
        $url = "http://127.0.0.1";
        $expected = "";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testGetMainDomain_DoubleSuffix_ReturnsMainDomain()
    {
        $url = "http://sub.example.com.cn";
        $expected = "example.com.cn";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testGetMainDomain_TwoParts_ReturnsMainDomain()
    {
        $url = "http://example.com";
        $expected = "example.com";
        $this->assertEquals($expected, UrlTool::getMainDomain($url));
    }

    public function testIsURL_ValidURL_ReturnsTrue()
    {
        $url = "http://example.com";
        $this->assertTrue((new UrlTool)->isURL($url));
    }

    public function testIsURL_InvalidURL_ReturnsFalse()
    {
        $url = "example.com";
        $this->assertFalse((new UrlTool)->isURL($url));
    }
}
