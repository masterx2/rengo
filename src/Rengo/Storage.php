<?php

namespace Rengo;

use Rengo\Driver\MongoDriver;
use Rengo\Driver\RedisDriver;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 13:25
 */
class Storage {
    /** @var RedisDriver */
    private $redis;

    /** @var MongoDriver */
    private $mongo;

    /**
     * RedisCache constructor.
     */
    public function __construct($redis, $mongo) {
        $this->redis = $redis;
        $this->mongo = $mongo;
    }

    /**
     * @param $config
     * @return static
     */
    public static function factory($name, $keys=['_id'], $config=null) {
        if (!$config) {
            // Default config for fast deploy
            $config = [
                'redis' =>
                    [
                        'host' => '127.0.0.1',
                        'port' => 6379,
                        'timeout' => 300,
                        'db' => 0
                    ],
                'mongo' =>
                    [
                        'host' => '127.0.0.1',
                        'port' => 27017,
                        'database' => 'rengo'
                    ]
            ];
        }
        $redis_driver = new RedisDriver($name, $keys, $config['redis']);
        $mongo_driver = new MongoDriver($name, $config['mongo']);
        return new static($redis_driver, $mongo_driver);
    }

    /**
     * @param $object
     * @param int $way
     * @return bool
     */
    public function insert($object) {
        return $this->redis->set($object);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function find($query) {
        $result = $this->redis->getAll($query);
        if (!$result) {
            $result = $this->mongo->get($query);
        }
        return $result;
    }

    public function flush() {
        $this->redis->flushall();
    }
}