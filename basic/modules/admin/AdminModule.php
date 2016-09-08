<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class AdminModule extends \yii\base\Module
{
    /**
     * @var
     */
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($_SERVER['REQUEST_URI'] === '/admin') {

            parent::runAction("index",[]);exit;
        }
    }
}
