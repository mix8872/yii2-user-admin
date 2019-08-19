<?php

use yii\helpers\Html;
use mix8872\useradmin\assets\AdminAsset;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */
$this->title = Yii::t('user-admin', 'Маршруты');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user-admin', 'Пользователи'), 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::tag('h2', Html::encode($this->title), ['class' => 'pull-left float-left']) ?>
            <div class="panel-heading__btn-block">
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Пользователи'), ['user/index'], ['class' => 'btn btn-warning']) ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Правила'), ['rule/index'], ['class' => 'btn btn-light btn-white']) ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Разрешения'), ['permission/index'], ['class' => 'btn btn-light btn-white']) ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa']) . ' ' . Yii::t('user-admin', 'Роли'), ['role/index'], ['class' => 'btn btn-light btn-white']) ?>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить маршрут'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <?= Yii::t('user-admin', 'Доступные') ?> <a href="#" id="btn-refresh"><span class="fa fa-refresh"></span></a> :
                    <input id="search-avaliable" class="form-control">
                    <select id="list-avaliable" class="form-control" multiple size="20" style="width: 100%">
                    </select>
                </div>
                <div class="col-lg-1 col-md-offset-1">
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
    'assignUrl' => Url::to(['assign']),
    'searchUrl' => Url::to(['search']),
]);
$js = <<<JS
yii.admin.initProperties({$properties});

$('#search-avaliable').keydown(function () {
    yii.admin.searchRoute('avaliable');
});
$('#search-assigned').keydown(function () {
    yii.admin.searchRoute('assigned');
});
$('#btn-add').click(function () {
    yii.admin.assignRoute('assign');
    return false;
});
$('#btn-remove').click(function () {
    yii.admin.assignRoute('remove');
    return false;
});
$('#btn-refresh').click(function () {
    yii.admin.searchRoute('avaliable',1);
    return false;
});

yii.admin.searchRoute('avaliable', 0, true);
yii.admin.searchRoute('assigned', 0, true);
JS;
$this->registerJs($js);

