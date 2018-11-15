<?php

namespace mix8872\useradmin\assets;

/**
 * AdminAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AdminAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/mix8872/yii2-user-admin/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [

    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'yii.admin.js',
    ];

    public $depends = [
        'mix8872\useradmin\assets\MainAsset',
    ];
}
