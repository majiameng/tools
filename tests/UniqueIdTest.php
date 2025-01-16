<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\UniqueId;

class UniqueIdTest extends TestCase
{
    protected $uniqueId;

    protected function setUp(): void
    {
        $this->uniqueId = UniqueId::getInstance();
    }

    public function testCreateId()
    {
        $center = 5;
        $node = 10;
        $source = "test_source";
        $id = $this->uniqueId->createId($center, $node, $source);
        $this->assertNotNull($id);
        $this->assertTrue(is_int($id));
    }

    public function testParseId()
    {
        $center = 5;
        $node = 10;
        $source = "test_source";
        $id = $this->uniqueId->createId($center, $node, $source);
        $parsedId = $this->uniqueId->parseId($id);
        $this->assertEquals($center, $parsedId['center']);
        $this->assertEquals($node, $parsedId['node']);
        $this->assertTrue(is_numeric($parsedId['time']));
        $this->assertTrue(is_numeric($parsedId['rand']));
    }

    public function testIsValidId()
    {
        $center = 5;
        $node = 10;
        $source = "test_source";
        $id = $this->uniqueId->createId($center, $node, $source);
        $this->assertTrue($this->uniqueId->isValidId($id));

        $invalidId = 1234567890123456789;
        $this->assertTrue($this->uniqueId->isValidId($invalidId));
    }
}
