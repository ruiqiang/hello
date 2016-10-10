<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\PAdv;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;

/**
 * 广告点管理
 * Class AdvController
 * @package app\modules\admin\controllers
 */
class AdvController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $advColumns = array("id","adv_name","community_name","company_name","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $advColumnsVal = array("id","adv_name",array("community","community_name"),array("company","company_name"),"");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $advList = PAdv::find()->all();
        $column = DataTools::getDataTablesColumns($this->advColumns);
        $jsonDataUrl = '/admin/adv/managerjson';
        return $this->render('advManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl,
            'advlist' => $advList
        ));
    }

    /**
     * 添加
     */
    public function actionAdd()
    {
        $community = PCommunity::find()->all();
        return $this->render('advAdd',array('list'=>$community));
    }

    /**
     * 广告位编辑
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $adv = PAdv::find()->where('id = "' . $id . '"')->one();
        $community = PCommunity::find()->all();
        return $this->render('advEdit',array('data'=>$adv,'list'=>$community));
    }

    /**
     * 广告位管理表格数据
     */
    public function actionManagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->advColumns, $this->advColumnsVal,
            new PAdv(), "adv_name");
    }
}
