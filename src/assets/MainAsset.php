<?php

namespace mix8872\useradmin\assets;

/**
 * AdminAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MainAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/mix8872/yii2-user-admin/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'main.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'bootstrap.file-input.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
