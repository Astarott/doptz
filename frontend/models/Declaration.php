<?php

namespace frontend\models;

use frontend\models\Photo;
use common\models\User;
use Yii;
/**
 * This is the model class for table "declaration".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property string $city
 * @property int $total
 * @property string $category
 * @property string $status
 * @property int $viewed
 * @property int $user_id
 *
 * @property User $user
 * @property Photo[] $photos
 */
class Declaration extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'declaration';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['date'], 'safe'],
            [['total', 'viewed', 'user_id'], 'default', 'value' => null],
            [['total', 'viewed', 'user_id'], 'integer'],
            [['title', 'description', 'city', 'category', 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['photos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,jpeg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'city' => 'City',
            'total' => 'Total',
            'category' => 'Category',
            'status' => 'Status',
//            'viewed' => 'Viewed',
            'viewed' => 'Photo',
            'user_id' => 'User ID',
            //'photos' => 'Photos',
        ];
    }

//    public function getPhotos()
//    {
//        return
//    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['declaration_id' => 'id']);
    }

}
