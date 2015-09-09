<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 10.09.15
 * Time: 0:29
 */

namespace Rengo\Util;

class MongoUtils {
    public static function clearMongo($data) {
        if(is_array($data)) {
            foreach($data as &$attr) {
                if($attr instanceof \MongoId) {
                    $attr = (string) $attr;
                }
                if($attr instanceof \MongoDate) {
                    $attr = $attr->sec;
                }
                if(is_array($attr)) {
                    $attr = self::clearMongo($attr);
                }
            }
            unset($attr);
        } else {
            return  $data instanceof \MongoDate ? $data->{'sec'} : (string) $data;
        }
        return $data;
    }
}