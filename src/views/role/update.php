<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\AuthItem $model
 */
$this->title = Yii::t('user-admin', 'Редактирование роли') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]);
?>
