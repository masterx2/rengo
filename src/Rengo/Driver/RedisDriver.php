<?php
namespace Rengo\Driver;

use Rengo\Driver;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 13:31
 */
class RedisDriver implements Driver {

    /** @var Redis */
    public $redis;

    /**
     * RedisDriver constructor.
     */
    public function __construct($name, $config) {
        $this->redis = new \Redis();
        $this->redis->connect($config['host'], $config['port'], $config['timeout']);
        $this->namespace = "rengo:$name:";
    }

    public function set($object, $keys=['_id']) {
        $_id = new \MongoId();
    }

    public function get($key) {}
    public function query($query) {}
}