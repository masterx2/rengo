<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 09.09.15
 * Time: 19:11
 */

namespace Rengo;

interface Driver {
    public function set($object);
    public function get($key);
    public function query($query);
}