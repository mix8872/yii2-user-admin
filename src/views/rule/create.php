<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\AuthItem $model
 */

$this->title = Yii::t('user-admin', 'Добавление правила');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Правила'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">
	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
