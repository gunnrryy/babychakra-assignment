<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Posts;
use app\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SearchController extends Controller {


    public function actionData($entity_type, $entity_id) {

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($entity_type === 'users') {
            $data = Users::get($entity_id);
        } else if ($entity_type === 'articles') {
            $data = Articles::get($entity_id);
        } else  if ($entity_type === 'posts') {
            $data = Posts::get($entity_id);
        }

        return $data;
    }

}