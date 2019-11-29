<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use function frontend\controllers\vardump;

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
            [['path'], 'required'],
            [['path'], 'file', 'extensions' => 'jpg,jpeg,png', 'message' => 'Выберите аватарку формата jpg, jpeg, png.'],
            [['path'], 'file', 'maxSize' => '3145728', 'tooBig' => 'Выберите аватарку до 3 Мб.'],
            [['path'], 'file'],
            [['creationDate'], 'safe'],
//            [['declaration_id'], 'required'],
            [['declaration_id'], 'default', 'value' => null],
            [['declaration_id'], 'integer'],
//            [['path'], 'string', 'max' => 255],
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

    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->path = $file;
        if ($this->validate())
        {
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
    }
    private function getFolder()
    {
        return Yii::getAlias('@app/') .'web/' . 'uploads/';
    }

    public function generateFileName()
    {
        return strtolower(md5(uniqid($this->path->baseName)) . '.' . $this->path->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if(!empty($currentImage) && $currentImage !=null && is_file($this->getFolder(). $currentImage))
        {
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage()
    {
        $filename = $this->generateFileName();

        $this->path->saveAs($this->getFolder() . $filename);
        return  $filename;
    }
}
