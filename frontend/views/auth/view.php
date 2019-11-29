<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Профиль';
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'username',
            'city',
            'phone',
            'about',
            [
                'format' => 'html',
                'label' => 'avatar',
                'value' => function($data) {
                    return Html::img($data->getAvatar(), ['width' =>200]) ;
                }
            ],
        ],
    ]) ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Set Avatar', ['set-image', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>
</div>
