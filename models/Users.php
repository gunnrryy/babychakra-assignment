<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $usename
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Articles[] $articles
 * @property Posts[] $posts
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'email', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_name'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 32],
            ['id', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['user_id' => 'id']);
    }

    public static function get($id) {

        $cacheService = new CacheService();
        $data = $cacheService->fetch("users:{$id}");

        if (empty($data)) {
            $arrayData = self::find()->where(['id' => $id])->asArray()->one();
            if ($arrayData) {
                $cacheService->set("users:{$id}", $arrayData);
            }
        } else {
            $arrayData = json_decode($data, true);
        }
        return $arrayData;
    }
}
