<?php
namespace tinymeng\tools;

use PHPUnit\Framework\TestCase;

class ArrayToolTest extends TestCase
{
    public function testArraySort_AscendingOrder_ReturnsSortedArray()
    {
        $arr = [
            ['id' => 3, 'name' => 'Charlie'],
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ];
        $expected = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];
        $this->assertEquals($expected, ArrayTool::arraySort($arr, 'id', 'asc'));
    }

    public function testArraySort_DescendingOrder_ReturnsSortedArray()
    {
        $arr = [
            ['id' => 3, 'name' => 'Charlie'],
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ];
        $expected = [
            ['id' => 3, 'name' => 'Charlie'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 1, 'name' => 'Alice'],
        ];
        $this->assertEquals($expected, ArrayTool::arraySort($arr, 'id', 'desc'));
    }

    public function testArraySort_EmptyArray_ReturnsEmptyArray()
    {
        $arr = [];
        $expected = [];
        $this->assertEquals($expected, ArrayTool::arraySort($arr, 'id', 'asc'));
    }

    public function testArraySort_InvalidKey_ReturnsOriginalArray()
    {
        $arr = [
            ['id' => 3, 'name' => 'Charlie'],
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ];
        $expected = $arr;
        $this->assertEquals($expected, ArrayTool::arraySort($arr, 'invalid_key', 'asc'));
    }

    public function testGetTreeStructure_NormalTree_ReturnsTreeStructure()
    {
        $list = [
            ['id' => 1, 'pid' => 0, 'name' => 'Root'],
            ['id' => 2, 'pid' => 1, 'name' => 'Child 1'],
            ['id' => 3, 'pid' => 1, 'name' => 'Child 2'],
            ['id' => 4, 'pid' => 2, 'name' => 'Grandchild 1'],
        ];
        $expected = [
            [
                'id' => 1,
                'pid' => 0,
                'name' => 'Root',
                'child' => [
                    [
                        'id' => 2,
                        'pid' => 1,
                        'name' => 'Child 1',
                        'child' => [
                            [
                                'id' => 4,
                                'pid' => 2,
                                'name' => 'Grandchild 1',
                            ],
                        ],
                    ],
                    [
                        'id' => 3,
                        'pid' => 1,
                        'name' => 'Child 2',
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, ArrayTool::getTreeStructure($list));
    }

    public function testGetTreeStructure_EmptyArray_ReturnsEmptyArray()
    {
        $list = [];
        $expected = [];
        $this->assertEquals($expected, ArrayTool::getTreeStructure($list));
    }

    public function testGetTreeStructure_NoChildren_ReturnsTreeStructureWithoutChildren()
    {
        $list = [
            ['id' => 1, 'pid' => 0, 'name' => 'Root'],
        ];
        $expected = [
            [
                'id' => 1,
                'pid' => 0,
                'name' => 'Root',
            ],
        ];
        $this->assertEquals($expected, ArrayTool::getTreeStructure($list));
    }

    public function testGetTreeStructure_SingleNode_ReturnsSingleNode()
    {
        $list = [
            ['id' => 1, 'pid' => 0, 'name' => 'Root'],
        ];
        $expected = [
            [
                'id' => 1,
                'pid' => 0,
                'name' => 'Root',
            ],
        ];
        $this->assertEquals($expected, ArrayTool::getTreeStructure($list));
    }

    public function testObjectToArray_Object_ReturnsArray()
    {
        $obj = (object) [
            'id' => 1,
            'name' => 'Alice',
            'details' => (object) [
                'age' => 30,
                'city' => 'Wonderland',
            ],
        ];
        $expected = [
            'id' => 1,
            'name' => 'Alice',
            'details' => [
                'age' => 30,
                'city' => 'Wonderland',
            ],
        ];
        $this->assertEquals($expected, ArrayTool::objectToArray($obj));
    }

    public function testObjectToArray_NestedObject_ReturnsNestedArray()
    {
        $obj = (object) [
            'id' => 1,
            'name' => 'Alice',
            'details' => (object) [
                'age' => 30,
                'city' => 'Wonderland',
                'contact' => (object) [
                    'email' => 'alice@example.com',
                    'phone' => '1234567890',
                ],
            ],
        ];
        $expected = [
            'id' => 1,
            'name' => 'Alice',
            'details' => [
                'age' => 30,
                'city' => 'Wonderland',
                'contact' => [
                    'email' => 'alice@example.com',
                    'phone' => '1234567890',
                ],
            ],
        ];
        $this->assertEquals($expected, ArrayTool::objectToArray($obj));
    }

    public function testObjectToArray_NonObject_ReturnsOriginalInput()
    {
        $input = 'not an object';
        $expected = 'not an object';
        $this->assertEquals($expected, ArrayTool::objectToArray($input));
    }

    public function testNullArrayToObject_EmptyArray_ReturnsObject()
    {
        $data = [];
        ArrayTool::nullArrayToObject($data);
        $this->assertIsObject($data);
    }

    public function testNullArrayToObject_NestedEmptyArray_ReturnsNestedObject()
    {
        $data = [
            'key1' => [],
            'key2' => [
                'key3' => [],
            ],
        ];
        ArrayTool::nullArrayToObject($data);
        $this->assertIsObject($data['key1']);
        $this->assertIsObject($data['key2']['key3']);
    }

    public function testNullArrayToObject_NonArray_ReturnsOriginalInput()
    {
        $data = 'not an array';
        ArrayTool::nullArrayToObject($data);
        $this->assertEquals('not an array', $data);
    }
}
