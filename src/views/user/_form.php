<?php

use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $role common\rbac\models\Role; */
?>
<?php $form = ActiveForm::begin(['id' => 'form-user', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::tag('h2', Html::encode($title), ['class' => 'pull-left float-left']) ?>
            <div class="form-group float-right pull-right">
                <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-chevron-left']) . ' ' . Yii::t('user-admin', 'Назад'), (Yii::$app->request->referrer ?? ['index']), ['class' => 'btn btn-warning']) ?>
                <?php if (!$user->isNewRecord): ?>
                    <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-save']) . ' ' . Yii::t('user-admin', 'Обновить'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']) . ' ' . Yii::t('user-admin', 'Удалить'), ['delete', 'id' => $user->id], ['class' => 'btn btn-danger', 'data' => [
                        'confirm' => 'Вы действительно хотите удалить пользователя?',
                        'method' => 'post'
                    ]]) ?>
                <?php else : ?>
                    <?= Html::submitButton(Html::tag('i', '', ['class' => 'fa fa-plus']) . ' ' . Yii::t('user-admin', 'Добавить'), ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!$user->isNewRecord) : ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if ($user->hasAttribute('img')): ?>
                            <div class="user-img-block form-group">
                                <img src="<?= $user->img ? $user->img : Yii::getAlias('@web/img/avatar.jpg') ?>" alt="">
                            </div>
                            <div class="form-group">
                                <?= Html::fileInput('user-img', null, ['class' => 'avatar-input', 'accept' => '.jpg, .jpeg, .png, .bmp', 'title' => ($user->img ? Yii::t('user-admin', 'Заменить') : Yii::t('user-admin', 'Добавить'))]) ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <h4><?= $user->display_name ?? $user->username ?></h4>
                            <p class="text-muted font-13">
                                <strong>Email</strong>
                                <span class="m-l-15"><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($user, 'username') ?>

                    <?= $form->field($user, 'email') ?>

                    <?php if ($user->scenario === 'create'): ?>
                        <?= $form->field($user, 'password')->widget(PasswordInput::classname(), []) ?>
                    <?php else: ?>
                        <?= $form->field($user, 'password')->widget(PasswordInput::classname(), [])
                            ->passwordInput(['placeholder' => Yii::t('user-admin', 'Новый пароль (если нужно изменить его)')])
                        ?>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($user, 'status')->dropDownList($user->statusList) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php if (!$user->isNewRecord): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3><?= Yii::t('user-admin', 'Права и роли') ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <?= Yii::t('user-admin', 'Доступные') ?>:
                            <input id="search-avaliable" class="form-control"><br>
                            <select id="list-avaliable" class="form-control" multiple size="20" style="width: 100%">
                            </select>
                        </div>
                        <div class="col-lg-1 col-lg-offset-1">
                            <div class="assign-btn-block">
                                <a href="#" id="btn-assign" class="btn btn-success">&gt;&gt;</a><br>
                                <a href="#" id="btn-revoke" class="btn btn-danger">&lt;&lt;</a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <?= Yii::t('user-admin', 'Назначенные') ?>:
                            <input id="search-assigned" class="form-control"><br>
                            <select id="list-assigned" class="form-control" multiple size="20" style="width: 100%">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        \mix8872\useradmin\assets\AdminAsset::register($this);
        $properties = Json::htmlEncode([
            'userId' => $user->id,
            'assignUrl' => Url::to(['assign']),
            'searchUrl' => Url::to(['role-search']),
        ]);
        $js = <<<JS
            yii.admin.initProperties({$properties});
            
            $('#search-avaliable').keydown(function () {
                yii.admin.searchAssignmet('avaliable');
            });
            $('#search-assigned').keydown(function () {
                yii.admin.searchAssignmet('assigned');
            });
            $('#btn-assign').click(function () {
                yii.admin.assign('assign');
                return false;
            });
            $('#btn-revoke').click(function () {
                yii.admin.assign('revoke');
                return false;
            });
            
            yii.admin.searchAssignmet('avaliable', true);
            yii.admin.searchAssignmet('assigned', true);
            
            $('input.avatar-input').bootstrapFileInput();
JS;
        $this->registerJs($js);
        ?>
    </div>
<?php endif; ?>