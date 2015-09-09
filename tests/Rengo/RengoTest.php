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
        $this->storage = Storage::factory('test-rengo');
    }

    public function testGetCacher() {
        $this->assertInstanceOf('Rengo\Storage', $this->storage);
    }

    public function testStoreData() {
        $one = $this->storage->insert([
            '1' => 'one',
            '2' => 'two',
            '3' => 'three'
        ]);

        $two = $this->storage->insert([
            'one' => '1',
            'two' => '2',
            'three' => '3'
        ]);

        $this->assertTrue($one && $two);
    }

    public function testGetData() {
        $result = $this->storage->find(['1' => 'one']);

        $this->assertEquals([
            '1' => 'one',
            '2' => 'two',
            '3' => 'three'], $result);
    }

    public function testOk() {
        $this->assertTrue(true);
    }
}