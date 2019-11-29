<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DeclarationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Declarations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="declaration-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'title',
            'description',
            'date',
            'city',
            //'total',
            //'category',
            //'status',
            //'viewed',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
