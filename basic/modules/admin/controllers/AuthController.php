<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PStaff;

class AuthController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $columns = array("id","staff_name","staff_sector_name","staff_in","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $columnsVal = array("id","staff_name",array("sector","sector_name"),"staff_in","");

    /**
     *
     * @return string
     */
    public function actionUsermanager()
    {
        $column = DataTools::getDataTablesColumns($this->columns);
        $jsonDataUrl = '/admin/auth/usermanagerjson';
        return $this->render('userManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl));
    }

    public function actionUsermanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->columns, $this->columnsVal,
            new PStaff, "staff_name");
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
