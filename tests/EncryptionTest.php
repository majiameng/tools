<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\Encryption;

class EncryptionTest extends TestCase
{
    public function testAuthcodeEncode()
    {
        $originalString = 'Hello, World!';
        $key = 'tinymeng';
        $encodedString = Encryption::authcode($originalString, 'encode', $key);
        $this->assertNotEquals($originalString, $encodedString);
    }

    public function testAuthcodeDecode()
    {
        $originalString = 'Hello, World!';
        $key = 'tinymeng';
        $encodedString = Encryption::authcode($originalString, 'encode', $key);
        $decodedString = Encryption::authcode($encodedString, 'decode', $key);
        $this->assertEquals($originalString, $decodedString);
    }

    public function testAuthcodeWithExpiry()
    {
        $originalString = 'Hello, World!';
        $key = 'tinymeng';
        $expiry = 10; // 10 seconds
        $encodedString = Encryption::authcode($originalString, 'encode', $key, $expiry);
        sleep(11); // Wait for the encoded string to expire
        $decodedString = Encryption::authcode($encodedString, 'decode', $key);
        $this->assertEquals('', $decodedString);
    }

    public function testAuthcodeWithoutExpiry()
    {
        $originalString = 'Hello, World!';
        $key = 'tinymeng';
        $encodedString = Encryption::authcode($originalString, 'encode', $key);
        $decodedString = Encryption::authcode($encodedString, 'decode', $key);
        $this->assertEquals($originalString, $decodedString);
    }
}
