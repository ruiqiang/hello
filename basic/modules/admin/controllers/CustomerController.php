<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCustomer;

class CustomerController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $columns = array("id","customer_company","customer_industry","company_name","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $columnsVal = array("id","customer_company","customer_industry",array("company","company_name"),"");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $column = DataTools::getDataTablesColumns($this->columns);
        $jsonDataUrl = '/admin/customer/customermanagerjson';
        return $this->render('customerManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl));
    }

    public function actionCustomermanagerjson($draw = 1, $start = 0, $length = 10)
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->columns, $this->columnsVal,
            new PCustomer, "customer_company");
    }
}
