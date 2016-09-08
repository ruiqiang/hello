<?php

namespace app\modules\admin\controllers;

/**
 * 广告点管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class AdvController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        return $this->render('advManager');
    }
}
