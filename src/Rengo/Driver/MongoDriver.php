<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 19:11
 */

namespace Rengo\Driver;


class MongoDriver {
    /**
     * @var \MongoCollection
     */
    public $collection;

    /**
     * DB Connect
     * @param string $dbname
     */
    public function connect($name, $config) {
        $mc = new \MongoClient("mongodb://".$config['host'].":".$config['port']);
        $db = $mc->selectDB($config['database']);
        $this->collection = $db->selectCollection($name);
    }

    public function set($object) {}
    public function get($key) {}
    public function query($query) {}
}