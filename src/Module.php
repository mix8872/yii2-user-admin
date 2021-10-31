<?php

namespace mix8872\useradmin;

use Yii;
use yii\helpers\Inflector;

/**
 * GUI manager for RBAC.
 * 
 * Use [[\yii\base\Module::$controllerMap]] to change property of controller. 
 * To change listed menu, use property [[$menus]].
 * 
 * ~~~
 * 'layout' => 'left-menu', // default to null mean use application layout.
 * 'menus' => [
 *     'assignment' => [
 *         'label' => 'Grand Access' // change label
 *     ],
 *     'route' => null, // disable menu
 * ],
 * ~~~
 * 
 * @property string $mainLayout Main layout using for module. Default to layout of parent module.
 * Its used when `layout` set to 'left-menu', 'right-menu' or 'top-menu'.
 * @property array $menus List avalible menu of module.
 * It generated by module items .
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'assignment';

    public $parameters;
    public $userTableName = 'user';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['user-admin'])) {
            Yii::$app->i18n->translations['user-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru-RU',
                'basePath' => '@vendor/mix8872/useradmin/src/messages'
            ];
        }
        if (isset($this->parameters['userTableName']) && $this->parameters['userTableName']) {
            $this->userTableName = $this->parameters['userTableName'];
        }
        if (!isset($this->parameters['avatarSavePath']) || $this->parameters['avatarSavePath']) {
            $this->parameters['avatarSavePath'] = '/uploads/avatars/';
        } else {
            $this->parameters['avatarSavePath'] = trim($this->parameters['avatarSavePath'], '/');
            $this->parameters['avatarSavePath'] = '/' . $this->parameters['avatarSavePath'] . '/';
        }
    }
}