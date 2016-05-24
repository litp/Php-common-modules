<?php

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public $collection;


    public function setUp()
    {
        $data = array(
            'prop1' => 'test string @ prop1',
            'prop2' => 'test string @ prop2',
            'prop3' => 'test string @ prop3'
            );

        $this->collection = new Collection($data);
    }

    public function testCreateCollection()
    {
        $this->assertInstanceOf('Collection', $this->collection);
    }

    public function testGet()
    {
        $this->assertNull($this->collection->prop4);
        $this->assertNotNull($this->collection->prop1);
    }

    public function testSet()
    {
        $this->assertNull($this->collection->prop4);
        $this->collection->prop4 = 'prop4 setted';
        $this->assertEquals('prop4 setted', $this->collection->prop4);
    }

    public function testCount()
    {
        $this->assertEquals(3, count($this->collection));
    }

    public function testIterator()
    {
        $this->assertInstanceOf('ArrayIterator', $this->collection->getIterator());
    }
}
