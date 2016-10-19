<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\PModel;

use app\modules\admin\models\DataTools;
/**
 * 广告点管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class ModelController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $modelColumns = array("id","model_name","model_category","model_factory","company_name","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $modelColumnsVal = array("id","model_name","model_category",
        "model_factory",array("company","company_name"),"");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $modelList = PModel::find()->all();
        $column = DataTools::getDataTablesColumns($this->modelColumns);
        $jsonDataUrl = '/admin/model/managerjson';
        return $this->render('modelManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl,
            'advlist' => $modelList
        ));
    }

    /**
     * 广告位管理表格数据
     */
    public function actionManagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->modelColumns, $this->modelColumnsVal,
            new PModel(), "model_name");
    }

    public function actionAdd()
    {
        return $this->render('modelAdd');
    }

    public function actionEdit($id)
    {
        $model = PModel::find()->where('id = "' . $id . '"')->one();
        return $this->render('modelEdit',array('model'=>$model));
    }
}
