<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Declaration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="declaration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropDownList([
            'Недвижимость' => 'Недвижимость',
            'Транспорт' => 'Транспорт',
            'Личные вещи' => 'Личные вещи',
            'Хобби и отдых' => 'Хобби и отдых',
            'Услуги' => 'Услуги',
            'Бытовая техника'=>'Бытовая техника',
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true,'value' => $model->user->city]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'viewed')->fileInput(['maxlength' => true]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'format' => 'html',
                'label' => '',
                'value' => function($data) {
                    return Html::img($data->getPhotos(), ['width' =>200]) ;
                }
            ],
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
