<?php

namespace mix8872\useradmin\assets;

/**
 * AutocompleteAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AutocompleteAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/mix8872/yii2-user-admin/src/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'jquery-ui.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'jquery-ui.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
