<?php
/**
 * Created by PhpStorm.
 * User: Mix
 * Date: 15.11.2018
 * Time: 09:35
 */

namespace mix8872\useradmin\controllers;


class BaseController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        \mix8872\useradmin\assets\MainAsset::register($this->view);
        return parent::beforeAction($action);
    }
}