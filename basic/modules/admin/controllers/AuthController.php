<?php

namespace app\modules\admin\controllers;

class AuthController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     *
     * @return string
     */
    public function actionUsermanager()
    {
        return $this->render('userManager');
    }

    /**
     *
     * @return string
     */
    public function actionRolemanager()
    {
        return $this->render('roleManager');
    }

    /**
     *
     * @return string
     */
    public function actionMenumanager()
    {
        return $this->render('menuManager');
    }

}
