<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mix8872\useradmin\models\searchs\AuthItem */

$this->title = Yii::t('user-admin', 'Разрешения');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel pane-default">

    <div class="panel-heading">
        <?= Html::tag('h2', $this->title, ['class' => 'pull-left float-left']) ?>
        <div class="panel-heading__btn-block">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Пользователи'), ['user/index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Правила'), ['rule/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Маршруты'), ['route/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Роли'), ['role/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить разрешение'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Pjax::begin([
            'enablePushState' => false,
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'label' => Yii::t('user-admin', 'Name'),
                ],
                [
                    'attribute' => 'description',
                    'label' => Yii::t('user-admin', 'Description'),
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]);
        Pjax::end();
        ?>
    </div>
</div>
