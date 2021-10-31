<?php

namespace mix8872\useradmin\controllers;

/**
 * DefaultController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DefaultController extends BaseController
{

    /**
     * Action index
     */
    public function actionIndex()
    {
        $this->redirect(['user/index']);
    }
}
