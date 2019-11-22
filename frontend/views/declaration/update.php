<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Declaration */

$this->title = 'Update Declaration: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Declarations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="declaration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
