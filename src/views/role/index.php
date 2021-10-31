<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var mix8872\useradmin\models\AuthItemSearch $searchModel
 */
$this->title = Yii::t('user-admin', 'Роли');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">
    <div class="panel-heading">
        <h2 class="pull-left float-left"><?= $this->title ?></h2>
        <div class="panel-heading__btn-block">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Пользователи'), ['user/index'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Правила'), ['rule/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Маршруты'), ['route/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Разрешения'), ['permission/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить роль'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
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
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
