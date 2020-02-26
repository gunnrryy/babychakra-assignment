<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Posts;
use app\models\Users;
use Yii;
use yii\web\Controller;

class PopulateDataController extends Controller {

    public function actionFromJson() {
        $type = Yii::$app->request->get('type');

        try {
            $arrayData = json_decode(file_get_contents("../data/{$type}.json"), true);
            if (empty($arrayData)) {
                throw new \Exception("No data to be inserted");
            }

            $db = Yii::$app->db;
            $sql = self::getInitialSql($type);    
            foreach ($arrayData as $row) {
                $rowData[] = '("'. implode('","', array_map('strval', $row)) . '")';
            }
            $sql .= implode(',', $rowData);
            $db->createCommand($sql)->execute();
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
        die("Data imported Successfully");
    }

    /**
     * Common function to get Initial Sql and field set based upon Table
     *
     * @param string $type
     * @throws Exception
     * @return string
     */
    private static function getInitialSql(string $type) : string {

        if ($type === 'users') {
            $sql = 'INSERT INTO `user`(`id`, `user_name`, `email`, `password`, `created_at`, `updated_at`) VALUES ';
        } else if ($type === 'posts') {
            $sql = 'INSERT INTO `posts`(`id`, `user_id`, `text`, `image`, `created_at`, `updated_at`) VALUES ';
        } else if ($type === 'articles') {
            $sql = 'INSERT INTO `articles`(`id`, `user_id`, `article_title`, `article_text`, `article_image`, `created_at`, `updated_at`) VALUES ';
        } else {
            throw new \Exception("Please provide a correct type for which data needs to be inserted");
        }
        return $sql;
    }


    /*
    public function actionUsers() {
        $arrayData = json_decode(file_get_contents('../data/users.json'), true);

        try {
            // Method 1: Using Model rules for applying validations.
            // foreach ($arrayData as $row) {
            //     $newUser = new Users();
            //     $newUser->attributes = $row;
            //     if (!$newUser->save()) {
            //         throw new \Exception("error while creating User:: {$row['user_name']}");
            //     }
            // }
            
            // Method 2: Batch-inserting using raw query.
            $db = Yii::$app->db;
            $sql = 'INSERT INTO `user`(`id`, `user_name`, `email`, `password`, `created_at`, `updated_at`) VALUES ';

            foreach ($arrayData as $row) {
                $rowData[] = '("'. implode('","', array_map('strval', $row)) . '")';
            }
            $sql .= implode(',', $rowData);
            $db->createCommand($sql)->execute();
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }


    public function actionArticles() {
        $arrayData = json_decode(file_get_contents('../data/articles.json'), true);
        try {
            // Method 1: Using Model rules for applying validations.
            // foreach ($arrayData as $row) {
            //     $newArticle = new Articles();
            //     $newArticle->attributes = $row;
            //     if (!$newArticle->save()) {
            //         throw new \Exception("error while creating Article-ID:: {$row['id']}");
            //     }
            // }
            
            // Method 2: Batch-inserting using raw query.
            $db = Yii::$app->db;
            $sql = 'INSERT INTO `articles`(`id`, `user_id`, `article_title`, `article_text`, `article_image`, `created_at`, `updated_at`) VALUES ';

            foreach ($arrayData as $row) {
                $rowData[] = '("'. implode('","', array_map('strval', $row)) . '")';
            }
            $sql .= implode(',', $rowData);
            $db->createCommand($sql)->execute();
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function actionPosts() {
        $arrayData = json_decode(file_get_contents('../data/posts.json'), true);
        try {
            // Method 1: Using Model rules for applying validations.
            // foreach ($arrayData as $row) {
            //     $newPost = new Posts();
            //     $newPost->attributes = $row;
            //     if (!$newPost->save()) {
            //         throw new \Exception("error while creating Post-ID:: {$row['id']}");
            //     }
            // }
            
            // Method 2: Batch-inserting using raw query.
            $db = Yii::$app->db;
            $sql = 'INSERT INTO `posts`(`id`, `user_id`, `text`, `image`, `created_at`, `updated_at`) VALUES ';

            foreach ($arrayData as $row) {
                $rowData[] = '("'. implode('","', array_map('strval', $row)) . '")';
            }
            $sql .= implode(',', $rowData);
            $db->createCommand($sql)->execute();
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }
    */
}
?>