<?php
namespace Rengo\Driver;

use Rengo\Util\MongoUtils;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 13:31
 */
class RedisDriver {

    /** @var /Redis */
    public $redis;

    /** @var array */
    public $keys;

    /**
     * RedisDriver constructor.
     */
    public function __construct($name, $keys, $config) {
        $this->redis = new \Redis();
        $this->redis->connect($config['host'], $config['port'], $config['timeout']);
        $this->namespace = "rengo:$name";
        $this->keys = $keys;
        $this->keys[] = '_id';
    }

    /**
     * @param $object
     * @return string
     */
    public function getKey($object) {
        $values = [];
        foreach ($this->keys as $key) {
            $values[] = MongoUtils::clearMongo($object[$key]);
        }
        return $this->namespace.':'.implode(':', $values);
    }

    /**
     * @param $query
     * @return null|string
     */
    public function queryToKey($query) {
        $result = [$this->namespace];
        foreach ($this->keys as $key) {
            $query_keys = array_keys($query);
            $index = array_search($key, $query_keys);
            if ($index > -1) {
                $result[] = $query[$query_keys[$index]];
            } else {
                $result[] = '*';
            }
        }
        return !empty($result) ? implode(':', $result) : null;
    }

    /**
     * @param $object
     * @return bool
     */
    public function set($object) {
        $object['_id'] = new \MongoId();
        $key = $this->getKey($object);
        return $this->redis->setex($key, 100, serialize($object));
    }

    /**
     * @param $query
     * @return array|bool
     */
    public function getAll($query) {
        $result = [];
        $keys = $this->redis->keys($this->queryToKey($query));
        if (!empty($keys)) {
            foreach ($keys as $key) {
                $result[] = unserialize($this->redis->get($key));
            }
        }
        return !empty($result) ? $result : false;
    }

    /**
     * @param $query
     * @return bool|string
     */
    public function getOne($query) {
        $keys = $this->redis->keys($this->queryToKey($query));
        if (!empty($keys)) {
            return unserialize($this->redis->get($keys[0]));
        }
        return false;
    }

    /**
     *
     */
    public function flushall() {
        $keys = $this->redis->keys($this->queryToKey([]));
        if (!empty($keys)) {
            foreach ($keys as $key) {
                $this->redis->del($key);
            }
        }
    }

    /**
     * @param $_id
     * @return bool|string
     */
    public function getById($_id) {
        return $this->getOne([
            '_id' => $_id
        ]);
    }
}