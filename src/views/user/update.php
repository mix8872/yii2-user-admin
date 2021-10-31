<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $role mix8872\useradmin\components\rbac\models\Role; */

$this->title = Yii::t('user-admin', 'Редактирование') . ': ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'title' => $this->title,
    'user' => $user,
    'role' => $role,
    'usernameField' => $usernameField,
]) ?>
