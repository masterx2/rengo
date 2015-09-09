<?php

namespace Rengo;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 13:42
 */
class StorageTest extends \PHPUnit_Framework_TestCase {

    /** @var Storage */
    public $storage;

    public function setUp() {
        $this->storage = Storage::factory('test-rengo', ['unit_id']);
    }

    public function testFlushAll() {
        $this->storage->flush();
    }

    public function testGetCacher() {
        $this->assertInstanceOf('Rengo\Storage', $this->storage);
    }

    public function testStoreData() {
        $one = $this->storage->insert([
            'one' => 'Test One',
            'unit_id' => 'section_key',
            'three' => '3213123432'
        ]);

        $two = $this->storage->insert([
            'one' => 'Test Two',
            'unit_id' => 'section_key',
            'three' => new \MongoDate()
        ]);

        $this->assertTrue($one && $two);
    }

    public function testGetData() {
        $result = $this->storage->find(['unit_id' => 'section_key']);
        $this->assertEquals(2, count($result));
    }

    public function testQuery() {
        $result = $this->storage->find([
            'unit_id' => 'section_key',
            'message' => 'hello'
        ]);
    }

    public function testOk() {
        $this->assertTrue(true);
    }
}