<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\ChineseChar;

class ChineseCharTest extends TestCase
{
    protected function setUp(): void
    {
        // 这里可以进行一些初始化操作
    }
    public function testName()
    {
        var_dump(ChineseChar::getChineseChar('葛鿉会', false, false));
    }

    public function testGetChineseFirstChar()
    {
        $this->assertEquals('wo', ChineseChar::getChineseFirstChar('我是作者', false, false));
        $this->assertEquals('w', ChineseChar::getChineseFirstChar('我是作者', true, false));
        $this->assertEquals('W', ChineseChar::getChineseFirstChar('我是作者', true, true));
        $this->assertEquals('WO', ChineseChar::getChineseFirstChar('我是作者', false, true));
        $this->assertEquals('A', ChineseChar::getChineseFirstChar('A', false, false));
        $this->assertEquals('h', ChineseChar::getChineseFirstChar('汉字', true, false));
        $this->assertEquals('H', ChineseChar::getChineseFirstChar('汉字', true, true));
    }

    public function testGetChineseChar()
    {
        $this->assertEquals('wo shi zuo zhe', ChineseChar::getChineseChar('我是作者', false, false));
        $this->assertEquals('w s z z', ChineseChar::getChineseChar('我是作者', true, false));
        $this->assertEquals('W S Z Z', ChineseChar::getChineseChar('我是作者', true, true));
        $this->assertEquals('WO SHI ZUO ZHE', ChineseChar::getChineseChar('我是作者', false, true));
        $this->assertEquals('A', ChineseChar::getChineseChar('A', false, false));
        $this->assertEquals('han zi', ChineseChar::getChineseChar('汉字', false, false));
    }
}