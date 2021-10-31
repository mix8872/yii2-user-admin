<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\AuthItem $model
 */

$this->title = Yii::t('user-admin', 'Добавление роли');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Роли'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]); ?>
