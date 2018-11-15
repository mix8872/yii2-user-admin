<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\Route $model
 * @var ActiveForm $form
 */

$this->title = Yii::t('user-admin', 'Добавление маршрута');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Маршруты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel-heading">
        <?= Html::tag('h2', Html::encode($this->title), ['class' => 'pull-left']) ?>
        <div class="panel-heading__btn-block">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Назад'), (Yii::$app->request->referrer ?? ['index']), ['class' => 'btn btn-warning']) ?>
            <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'route') ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- create -->
