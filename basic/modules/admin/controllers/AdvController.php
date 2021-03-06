<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\PAdv;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCommunity;
use app\modules\admin\models\PModel;
use app\modules\admin\models\ExcelTools;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

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
    public $advColumnsVal = array("id","adv_name",array("community","community_name"),array("company","company_name"),"<bindadv,edit,delete>");

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
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $models = PModel::find()->where('company_id = "' .$company_id. '" and model_status = "3"')->all();
        $community = PCommunity::find()->all();
        return $this->render('advAdd',array('list'=>$community,'model'=>$models));
    }

    /**
     * 广告位编辑
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '"')->one();
        $models = PModel::find()->where('company_id = "' .$company_id. '"')->all();
        $community = PCommunity::find()->all();
        return $this->render('advEdit',array('data'=>$adv,'list'=>$community, 'model'=>$models));
    }

    /**
     * 广告位详情
     * @param $id
     * @return string
     */
    public function actionDetails($id)
    {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '"')->one();
        $models = PModel::find()->where('company_id = "' .$company_id. '"')->all();
        $community = PCommunity::find()->all();
        return $this->render('advDetails',array('data'=>$adv,'list'=>$community, 'model'=>$models));
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

    public function actionDoadd()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $adv = new PAdv();
        $adv->adv_no = $post['adv_no'];
        $adv->adv_community_id = $post['adv_community_id'];
        $adv->adv_name = $post['adv_name'];
        $adv->adv_starttime = $post['adv_starttime'];
        $adv->adv_endtime = $post['adv_endtime'];
        $adv->adv_image = $post['adv_image'];
        $adv->adv_property = $post['adv_property'];
        $adv->adv_position = $post['adv_position'];
        $adv->model_id = $post['model_id'];
        $adv->adv_install_status = $post['adv_install_status'];
        $adv->adv_use_status = $post['adv_use_status'];
        $adv->adv_sales_status = $post['adv_sales_status'];
        $adv->adv_pic_status = $post['adv_pic_status'];
        $adv->company_id = \Yii::$app->session['loginUser']->company_id;
        $adv->is_delete = "0";
        $adv->creator = \Yii::$app->session['loginUser']->id;
        $adv->create_time = $now;
        $adv->update_time = $now;
        $adv->save();
        $this->redirect("/admin/adv/manager");
    }

    public function actionDoedit()
    {
        $now = date("Y-m-d H:i:s");
        $post = \Yii::$app->request->post();
        $adv = PAdv::find()->where('id = "' . $post['id'] . '"')->one();
        $adv->adv_no = $post['adv_no'];
        $adv->adv_community_id = $post['adv_community_id'];
        $adv->adv_name = $post['adv_name'];
        $adv->adv_starttime = $post['adv_starttime'];
        $adv->adv_endtime = $post['adv_endtime'];
        $adv->adv_image = $post['adv_image'];
        $adv->adv_property = $post['adv_property'];
        $adv->adv_position = $post['adv_position'];
        $adv->model_id = $post['model_id'];
        $adv->adv_install_status = $post['adv_install_status'];
        $adv->adv_use_status = $post['adv_use_status'];
        $adv->adv_sales_status = $post['adv_sales_status'];
        $adv->adv_pic_status = $post['adv_pic_status'];
        $adv->company_id = \Yii::$app->session['loginUser']->company_id;
        $adv->updater = \Yii::$app->session['loginUser']->id;
        $adv->update_time = $now;
        $adv->save();
        $this->redirect("/admin/adv/manager");
    }

    /*
     * excel 导入
     */
    public function actionAddexcel()
    {
        return $this->render('advExcel');
    }

    public function actionDoexcel()
    {
        if ($_FILES["commExcel"]["error"] <= 0)
        {
            $temp = explode(".",$_FILES["commExcel"]["name"]);
            $suffix = end($temp);
            if($suffix == "xlsx") {
                $excel = ExcelTools::getExcelObject($_FILES["commExcel"]["tmp_name"]);

                $company_id = \Yii::$app->session['loginUser']->company_id;

                $communityList = PCommunity::find()->select('id,community_name')->where('company_id=' . $company_id . ' and is_delete=0')->asArray()->all();
//                foreach($communityList as $k=>$v)
//                    echo $v["community_name"];

                $modelList = PModel::find()->select('id,model_id,model_name')->where('company_id=' . $company_id . ' and is_delete=0')->asArray()->all();

                ExcelTools::setDataIntoAdv($excel,$communityList,$modelList);
            }
        }
        $this->redirect("/admin/adv/manager");
    }

    public function actionProcess()
    {
        return $this->render('process');
    }

    public function actionFlow($id) {
        $company_id = \Yii::$app->session['loginUser']->company_id;
        $adv = PAdv::find()->where('id = "' . $id . '" and company_id = "' .$company_id. '"')->one();
        $models = PModel::find()->where('company_id = "' .$company_id. '"')->all();
        $community = PCommunity::find()->where('company_id = "' .$company_id. '"')->all();
        $staff = PStaff::find()->where('company_id = "' .$company_id. '"')->all();
        return $this->render('advFlow', array('data'=>$adv,'list'=>$community, 'model'=>$models,
            'staff'=>$staff));
    }

    public function actionDownloadexcel()
    {
        $this->redirect("/excel/模版（广告位信息）.xlsx");
    }
}
