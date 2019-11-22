<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property string $creationDate
 * @property string $path
 * @property int $declaration_id
 *
 * @property Declaration $declaration
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creationDate'], 'safe'],
            [['declaration_id'], 'required'],
            [['declaration_id'], 'default', 'value' => null],
            [['declaration_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['declaration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Declaration::className(), 'targetAttribute' => ['declaration_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creationDate' => 'Creation Date',
            'path' => 'Path',
            'declaration_id' => 'Declaration ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeclaration()
    {
        return $this->hasOne(Declaration::className(), ['id' => 'declaration_id']);
    }
}
