<?php

use mix8872\useradmin\helpers\CssHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

mix8872\useradmin\assets\MainAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user-admin', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel col-md-12">
    <div class="panel-heading">
        <?= Html::tag('h2', $this->title, ['class' => 'pull-left float-left']) ?>
        <div class="form-group float-right pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Правила'), ['rule/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Маршруты'), ['route/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Разрешения'), ['permission/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Роли'), ['role/index'], ['class' => 'btn btn-light btn-white']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить пользователя'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'email:email',
                // status
                [
                    'attribute' => 'status',
                    'filter' => $searchModel->statusList,
                    'value' => function ($data) {
                        return $data->statusName;
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {
                        return ['class' => CssHelper::statusCss($model->statusName)];
                    }
                ],
                // role
                [
                    'attribute' => 'item_name',
                    'filter' => $searchModel->rolesList,
                    'value' => function ($data) {
                        return $data->roleName;
                    },
                    'contentOptions' => function ($model, $key, $index, $column) {

                        return ['class' => CssHelper::roleCss($model->roleName)];
                    }
                ],
                // buttons
                ['class' => '\kartik\grid\ActionColumn',
                    'header' => Yii::t('user-admin', 'Действия'),
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('', $url, ['title' => Yii::t('user-admin', 'Редактировать пользователя'),
                                'class' => 'fa fa-pencil-alt']);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('', $url,
                                ['title' => 'Delete user',
                                    'class' => 'fa fa-trash-alt',
                                    'data' => [
                                        'confirm' => Yii::t('user-admin', 'Are you sure you want to delete this user?'),
                                        'method' => 'post']
                                ]);
                        }
                    ]
                ], // ActionColumn
            ], // columns
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
