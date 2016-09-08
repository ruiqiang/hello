<?php

namespace app\modules\admin\controllers;

/**
 * 小区管理
 * Class CommunityController
 * @package app\modules\admin\controllers
 */
class CommunityController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        return $this->render('communityManager');
    }
}
