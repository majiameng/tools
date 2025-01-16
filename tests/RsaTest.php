<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\RsaTool;

class RsaTest extends TestCase
{
    protected $rsaTool;

    protected function setUp(): void
    {
        $this->rsaTool = new RsaTool('./tests/keys');
        // 创建公钥和私钥
        $this->rsaTool->createKey();
    }


    public function testPrivEncryptAndDecrypt()
    {
        $data = 'Hello, World!';
        $encrypted = $this->rsaTool->privEncrypt($data);
        $this->assertNotNull($encrypted);

        $decrypted = $this->rsaTool->privDecrypt($encrypted);
        $this->assertEquals($data, $decrypted);
    }

    public function testPubEncryptAndDecrypt()
    {
        $data = 'Hello, World!';
        $encrypted = $this->rsaTool->pubEncrypt($data);
        $this->assertNotNull($encrypted);

        $decrypted = $this->rsaTool->pubDecrypt($encrypted);
        $this->assertEquals($data, $decrypted);
    }
}
