<?php

namespace app\models;

use Yii;

class CacheService  extends \yii\db\ActiveRecord {

    public function fetch($key) {
        return Yii::$app->redis->get($key) ?? '';
    }

    public function set($key, $data) {
        Yii::$app->redis->set($key, json_encode($data));
    }
}