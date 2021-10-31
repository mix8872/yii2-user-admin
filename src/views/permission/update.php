<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mix8872\useradmin\models\AuthItem */

$this->title = Yii::t('user-admin', 'Редактирование разрешения') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Разрешения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]);
?>

