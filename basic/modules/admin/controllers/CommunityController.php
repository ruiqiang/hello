<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\PAdv;
use app\modules\admin\models\PCommunity;

use app\modules\admin\models\DataTools;

/**
 * 小区管理
 * Class CommunityController
 * @package app\modules\admin\controllers
 */
class CommunityController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $communityColumns = array("id","community_no","community_name","community_cbd","company_name","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性(最多三层)
     * @var array
     */
    public $communityColumnsVal = array("id","community_no","community_name","community_cbd",array("company","company_name"),"");

    /**
     *
     * @return string
     */
    public function actionManager()
    {
        $communityList = PCommunity::find()->all();
        $column = DataTools::getDataTablesColumns($this->communityColumns);
        $jsonDataUrl = '/admin/community/managerjson';
        return $this->render('communityManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl,
            'rolelist' => $communityList
        ));
    }

    /**
     * 楼盘管理表格数据
     */
    public function actionManagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->communityColumns, $this->communityColumnsVal,
            new PCommunity(), "community_name");
    }

    /**
     * 楼盘添加
     */
    public function actionAdd()
    {
        return $this->render('communityAdd');
    }

    /**
     * 楼盘添加
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $community = PCommunity::find()->where('id = "' . $id . '"')->one();
        return $this->render('communityEdit',array('data'=>$community));
    }

    /**
     * 楼盘删除
     * @param $id
     */
    public function actionDeleteajax($id)
    {
        $community = PCommunity::find('id = "' . $id . '"')->one();
        if(empty($community)) {
            echo "0";exit;
        }
        $advCount = PAdv::find()->where('adv_community_id = "' . $id . '"')->count();
        if($advCount > 0) {
            echo "-1";exit;
        }
        $community->delete();
        echo "1";exit;
    }
}
