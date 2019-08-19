<?php

use mix8872\useradmin\assets\AdminAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use mix8872\useradmin\assets\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model mix8872\useradmin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::tag('h2', Html::encode($this->title), ['class' => 'pull-left float-left']) ?>
            <div class="panel-heading__btn-block">
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Назад'), (Yii::$app->request->referrer ?? ['index']), ['class' => 'btn btn-warning']) ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-floppy-o']) . ' ' . Yii::t('user-admin', 'Обновить'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-remove']) . ' ' . Yii::t('user-admin', 'Удалить'), ['delete', 'id' => $model->name], ['class' => 'btn btn-danger', 'data' => [
                        'confirm' => 'Вы действительно хотите удалить разрешение?',
                        'method' => 'post'
                    ]]) ?>
                <?php else : ?>
                    <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить'), ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule-name']) ?>
                <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
AutocompleteAsset::register($this);
$options = Json::htmlEncode([
    'source' => array_keys(Yii::$app->authManager->getRules())
]);
$this->registerJs("$('#rule-name').autocomplete($options);");
?>
<?php if (!$model->isNewRecord): ?>
    <div class="panel">
        <div class="panel-heading">
            <?= Html::tag('h3', Yii::t('user-admin', 'Правила'), ['class' => 'pull-left float-left']) ?>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <?= Yii::t('user-admin', 'Доступные') ?>:
                    <input id="search-avaliable" class="form-control">
                    <select id="list-avaliable" class="form-control" multiple size="20" style="width: 100%">
                    </select>
                </div>
                <div class="col-lg-1 col-lg-offset-1">
                    <div class="assign-btn-block">
                        <a href="#" id="btn-add" class="btn btn-success">&gt;&gt;</a><br>
                        <a href="#" id="btn-remove" class="btn btn-danger">&lt;&lt;</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <?= Yii::t('user-admin', 'Назначенные') ?>:
                    <input id="search-assigned" class="form-control">
                    <select id="list-assigned" class="form-control" multiple size="20" style="width: 100%">
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php
    AdminAsset::register($this);
    $properties = Json::htmlEncode([
        'roleName' => $model->name,
        'assignUrl' => Url::to(['assign']),
        'searchUrl' => Url::to(['search']),
    ]);
    $js = <<<JS
        yii.admin.initProperties({$properties});
        
        $('#search-avaliable').keydown(function () {
            yii.admin.searchRole('avaliable');
        });
        $('#search-assigned').keydown(function () {
            yii.admin.searchRole('assigned');
        });
        $('#btn-add').click(function () {
            yii.admin.addChild('assign');
            return false;
        });
        $('#btn-remove').click(function () {
            yii.admin.addChild('remove');
            return false;
        });
        
        yii.admin.searchRole('avaliable', true);
        yii.admin.searchRole('assigned', true);
JS;
    $this->registerJs($js);
endif;