<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $user_id
 * @property string $article_title
 * @property string $article_text
 * @property string $article_image
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'article_title', 'article_text', 'article_image'], 'required'],
            [['user_id'], 'integer'],
            [['article_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['article_title', 'article_image'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'article_title' => 'Article Title',
            'article_text' => 'Article Text',
            'article_image' => 'Article Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function get($id) {

        $cacheService = new CacheService();
        $data = $cacheService->fetch("articles:{$id}");

        if (empty($data)) {
            $arrayData = self::find()->where(['id' => $id])->asArray()->one();
            if ($arrayData) {
                $cacheService->set("articles:{$id}", $arrayData);
            }
        } else {
            $arrayData = json_decode($data, true);
        }
        return $arrayData;
    }
}
