<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\PAdv;
use app\modules\admin\models\PCommunity;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PPTools;

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
        $company_id = \Yii::$app->session['loginUser']->company_id;
        return $this->render('communityAdd');
    }

    public function actionAddexcel()
    {
        return $this->render('communityExcel');
    }

    public function actionDoexcel()
    {
        if ($_FILES["commExcel"]["error"] <= 0)
        {
            $temp = explode(".",$_FILES["commExcel"]["name"]);
            $suffix = end($temp);
            if($suffix == "xlsx") {
                $excel = ExcelTools::getExcelObject($_FILES["commExcel"]["tmp_name"]);
                ExcelTools::setDataIntoCommunity($excel);
            }
        }
        $this->redirect("/admin/community/manager");
    }

    /**
     * 楼盘添加
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
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

    /**
     * 楼盘添加
     */
    public function actionMap()
    {
        $community = PCommunity::find()->asArray()->all();
        return $this->render('communityMap', array("data"=>$community,"datajson"=>json_encode($community)));
    }

    /**
     * 楼盘执行添加
     * @return string
     */
    public function actionDoadd()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $community = new PCommunity();
        $community->community_no = $post['community_no'];
        $community->community_name = $post['community_name'];
        $community->community_position = $post['community_position'];
        $community->community_category = $post['community_category'];
        $community->community_price = $post['community_price'];
        $community->community_cbd = $post['community_cbd'];
        $community->community_nature = $post['community_nature'];
        $community->community_opentime = $post['community_opentime'];
        $community->community_staytime = $post['community_staytime'];
        $community->community_units = $post['community_units'];
        $community->community_households = $post['community_households'];
        $communityMap = explode(",",$post['community_map']);
        $community->community_longitudex = $communityMap[0];
        $community->community_latitudey = $communityMap[1];
        $community->company_id = \Yii::$app->session['loginUser']->company_id;
        $community->creator = \Yii::$app->session['loginUser']->id;
        $community->create_time = $now;
        $community->update_time = $now;
        $community->save();
        $this->redirect("/admin/community/manager");
    }

    public function actionDoedit()
    {
        $post = \Yii::$app->request->post();
        $community = PCommunity::find()->where('id = "' . $post['id'] . '"')->one();
        $community->community_no = $post['community_no'];
        $community->community_name = $post['community_name'];
        $community->community_position = $post['community_position'];
        $community->community_category = $post['community_category'];
        $community->community_price = $post['community_price'];
        $community->community_cbd = $post['community_cbd'];
        $community->community_nature = $post['community_nature'];
        $community->community_opentime = $post['community_opentime'];
        $community->community_staytime = $post['community_staytime'];
        $community->community_units = $post['community_units'];
        $community->community_households = $post['community_households'];
        $communityMap = explode(",",$post['community_map']);
        $community->community_longitudex = $communityMap[0];
        $community->community_latitudey = $communityMap[1];
        $community->company_id = \Yii::$app->session['loginUser']['company_id'];
        $community->updater = \Yii::$app->session['loginUser']['id'];
        $community->update_time = date("Y-m-d H:i:s");
        $community->save();
        $this->redirect("/admin/community/manager");
    }

    public function actionDownloadppt()
    {
        $community = PCommunity::find()->all();
        $fileName = PPTools::createPPT("楼盘管理", $community);
        $this->redirect("/ppt/" . $fileName);
    }
}
