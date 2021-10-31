<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\AuthItem $model
 */
$this->title = Yii::t('user-admin', 'Редактирование правила') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Правила'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('user-admin', 'Update');
?>
<?= $this->render('_form', [
    'model' => $model,
]); ?>