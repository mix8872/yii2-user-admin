<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var mix8872\useradmin\models\AuthItem $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="panel panel-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel-heading">
        <?= Html::tag('h2', Html::encode($this->title), ['class' => 'pull-left']) ?>
        <div class="panel-heading__btn-block">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Назад'), (Yii::$app->request->referrer ?? ['index']), ['class' => 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>
                <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-floppy-o']) . ' ' . Yii::t('user-admin', 'Обновить'), ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-remove']) . ' ' . Yii::t('user-admin', 'Удалить'), ['delete', 'id' => $model->name], ['class' => 'btn btn-danger', 'data' => [
                    'confirm' => 'Вы действительно хотите удалить пользователя?',
                    'method' => 'post'
                ]]) ?>
            <?php else : ?>
                <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить'), ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        <?= $form->field($model, 'className')->textInput() ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
