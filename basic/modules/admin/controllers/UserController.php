<?php
/**
 * User: Administrator
 * Date: 2016/9/29
 */
namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PCompany;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PRoleMenu;
use app\modules\admin\models\PStaff;
use app\modules\admin\models\PStaffRole;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'admin';

    /**
     * Pcompany显示的数据列及相应的信息
     */
    public $companycolumns = array("id", "company_name", "company_field", "staff_number", "edit");
    public $companycolumnsVal = array("id", "company_name", "company_field", "staff_number", "<edit,delete>");

    /**
     * 公司管理
     */
    public function actionCompanymanager()
    {
        $companyList = PCompany::find()->where(' is_delete = 0 ')->all();
        $column = DataTools::getDataTablesColumns($this->companycolumns);
        $jsonDataUrl = '/admin/user/companymanagerjson';
        return $this->render('companyManager', array("columns" => $column, 'jsonurl' => $jsonDataUrl, 'companylist' => $companyList));
    }

    /*
     * 公司管理表格数据
     */
    public function actionCompanymanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonDataGenerl(\Yii::$app->request, "id desc", $this->companycolumns, $this->companycolumnsVal,
            new PCompany, "company_name", "company", 0);
    }

    /**
     * 添加公司信息
     */
    public function actionAddcompany()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $company_name = $request->post('companyName', null);
        $company_field = $request->post('companyField', null);
        $staff_number = $request->post('staffNumber', null);

        if ($company_name != null && trim($company_name) != '') {
            $companyNameExsits = PCompany::find()->where('company_name = "' . $company_name . '"')->one();
            if ($companyNameExsits != null)
                echo "-2";  //公司名称存在
            else {
                $company = new PCompany();
                $company->company_name = trim($company_name);
                $company->company_field = trim($company_field);
                $company->staff_number = trim($staff_number);
                $company->is_delete = 0;
                $company->create_time = $date;
                $company->update_time = $date;
                $company->save();

                echo "1";  //添加成功
            }
        } else {
            echo "-1";    //公司名称为空
        }
    }

    /**
     * 根据id获得公司信息
     */
    public function actionGetcompanyinfo($company_id)
    {
        $company=PCompany::find()->where('id='.$company_id)->one()->attributes;
        DataTools::jsonEncodeResponse($company);
    }

    /**
     * 更新公司信息
     */
    public function actionUpdatecompany()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $company_id = $request->post('company_id', '0');
        $company_name = $request->post('company_name', null);
        $company_field = $request->post('company_field', null);
        $staff_number = $request->post('staff_number', null);

        $company = PCompany::find()->where('id = "' . $company_id . '"')->one();
        if($company != null)
        {
            $companyNameExsits = PCompany::find()->where('company_name = "' . $company_name . '"')->one();
            if ($companyNameExsits != null)
                echo "-2";  //公司名称存在
            else{
                $company->company_name = trim($company_name);
                $company->company_field = trim($company_field);
                $company->staff_number = trim($staff_number);
                $company->update_time = $date;
                $company->save();

                echo "1";  //更新成功
            }
        } else{
            echo "-1"; //该id不存在
        }
        exit;
    }

    /**
     * 删除公司信息
     */
    public function actionDeletecompany()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $company_id = $request->post('company_id', '0');

        $company = PCompany::find()->where('id = "' . $company_id . '"')->one();
        if($company != null)
        {
                $company->is_delete = 1;
                $company->update_time = $date;
                $company->save();

                echo "1";  //更新成功
        } else{
            echo "-1"; //该id不存在
        }
        exit;
    }
}