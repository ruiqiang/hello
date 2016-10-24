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
use app\modules\admin\models\PSector;
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
     * Pstaff显示的数据列及相应的信息
     */
    public $staffcolumns = array("id", "staff_name", "staff_phone", "staff_email", "company_id", "staff_sector", "edit");
    public $staffcolumnsVal = array("id", "staff_name", "staff_phone", "staff_email", "company_id", "staff_sector", "<edit,delete>");

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
        $company = PCompany::find()->where('id=' . $company_id)->one()->attributes;
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
        if ($company != null) {
            if($company_name != null)
            {
                $companyNameExsits = PCompany::find()->where('company_name = "' . $company_name . '" and id !='.$company_id)->one();
                if ($companyNameExsits != null )
                    echo "-2";  //公司名称存在
                else {
                    $company->company_name = trim($company_name);
                    $company->company_field = trim($company_field);
                    $company->staff_number = trim($staff_number);
                    $company->update_time = $date;
                    $company->save();

                    echo "1";  //更新成功
                }
            }else{
                echo "-3";   //公司id已存在
            }
        } else {
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
        if ($company != null) {
            $company->is_delete = 1;
            $company->update_time = $date;
            $company->save();

            echo "1";  //更新成功
        } else {
            echo "-1"; //该id不存在
        }
        exit;
    }

    /**
     * @return string
     * 部门管理
     */
    public function actionSectormanager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];
        $company = PCompany::find()->where('id=' . $staff->company_id)->one();


        return $this->render("sectorManager", array('company' => $company));
    }

    /**
     * 根据company_id获得该公司下面的所有部门信息
     */
    public function actionGetsectorbycompany()
    {
        $company_id = \Yii::$app->request->get('company_id', '0');
        $sectorList = PSector::find()->select('id,sector_name')->where('company_id=' . $company_id . ' and is_delete=0')->asArray()->all();
        DataTools::jsonEncodeResponse($sectorList);
    }

    /**
     * 根据人员staff_id获得该对应公司的部门信息
     */
    public function actionGetsectorbystaff()
    {
        $staff_id = \Yii::$app->request->get('staff_id', '0');
        $staff = Pstaff::find()->where('id="' . $staff_id . '"')->one();
        $sectorList = PSector::find()->select('id,sector_name')->where('company_id=' . $staff->company_id . ' and is_delete=0')->asArray()->all();
        DataTools::jsonEncodeResponse($sectorList);
    }

    /**
     * 人员管理
     */
    public function actionStaffmanager()
    {
        $session = \Yii::$app->session;
        $staffInfo = $session['loginUser'];

        if ($staffInfo->is_super == 1) {
            //超级管理员
            $companyList = PCompany::find()->where("is_delete=0")->all();
            $company = PCompany::find()->one();
            $sectorList = PSector::find()->where("company_id = " . $company->id . " and is_delete=0 ")->all();
        } else {
            //普通人员
            $companyList = PCompany::find()->where("id = " . $staffInfo->company_id . " and is_delete=0 ")->all();
            $sectorList = PSector::find()->where("company_id = " . $staffInfo->company_id . " and is_delete=0 ")->all();
        }

        $staffList = PStaff::find()->where(' is_delete = 0 ')->all();
        $column = DataTools::getDataTablesColumns($this->staffcolumns);
        $jsonDataUrl = '/admin/user/staffmanagerjson';
        return $this->render("staffManager", array("columns" => $column, 'jsonurl' => $jsonDataUrl, 'stafflist' => $staffList, 'companyList' => $companyList, 'sectorList' => $sectorList));
    }

    /*
     * 人员信息添加
     */
    public function actionAddstaff()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $staff_name = $request->post('staffName', null);
        $staff_no = $request->post('staffNo', null);
        $staff_phone = $request->post('staffPhone', null);
        $staff_email = $request->post('staffEmail', null);
        $company_id = $request->post('companyId', null);
        $staff_sector = $request->post('staffSector', '0');
        $staff_position = $request->post('staffPosition', null);

        if ($staff_name != null && trim($staff_name) != '') {
            $staff = new PStaff();
            $staff->staff_name = trim($staff_name);
            $staff->password = md5('111111');     //设置初始密码“111111”；
            $staff->staff_no = trim($staff_no);
            $staff->company_id = $company_id;
            $staff->staff_sector = $staff_sector;
            $staff->staff_position = $staff_position;
            $staff->staff_phone = trim($staff_phone);
            $staff->staff_email = trim($staff_email);
            $staff->is_super = 0;
            $staff->is_delete = 0;
            $staff->create_time = $date;
            $staff->update_time = $date;
            $staff->save();

            echo "1";  //添加成功
        } else {
            echo "-1";    //姓名为空
        }
    }

    /**
     * 根据id获得人员信息
     */
    public function actionGetstaffinfo($staff_id)
    {
        $staff = PStaff::find()->where('id=' . $staff_id)->one()->attributes;
        DataTools::jsonEncodeResponse($staff);
    }

    /**
     * 更新人员信息
     */
    public function actionUpdatestaff()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $staff_id = $request->post('staffId', '0');
        $staff_name = $request->post('staffName', null);
        $staff_no = $request->post('staffNo', 0);
        $staff_phone = $request->post('staffPhone', null);
        $staff_email = $request->post('staffEmail', null);
        $company_id = $request->post('companyId', 0);
        $staff_sector = $request->post('staffSector', '0');
        $staff_position = $request->post('staffPosition', null);

        $staff = PStaff::find()->where('id=' . $staff_id . ' and is_delete=0')->one();
        if($staff_name == null) {
            echo "-2";
        }else if ($staff != null) {
            $staff->staff_name = trim($staff_name);
            $staff->staff_no = trim($staff_no);
            $staff->company_id = $company_id;
            $staff->staff_sector = $staff_sector;
            $staff->staff_position = $staff_position;
            $staff->staff_phone = trim($staff_phone);
            $staff->staff_email = trim($staff_email);
            $staff->update_time = $date;
            $staff->save();

            echo "1";  //更新成功
        } else {
            echo "-1"; //该id不存在
        }
        exit;
    }

    /**
     * 删除人员信息（软删除）
     */
    public function actionDeletestaff()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $staff_id = $request->post('staff_id', '0');

        $staff = PStaff::find()->where('id = "' . $staff_id . '"')->one();
        if ($staff != null) {
            $staff->is_delete = 1;
            $staff->update_time = $date;
            $staff->save();

            echo "1";  //更新成功
        } else {
            echo "-1"; //该id不存在
        }
        exit;
    }

    /**
     * 人员管理表格列表
     */
    public function actionStaffmanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonDataStaff(\Yii::$app->request, "id desc", $this->staffcolumns, $this->staffcolumnsVal,
            new PStaff, "staff_name", "staff", 0);
    }

    /*
     * 密码修改
     */
    public function actionPasswordmanager()
    {
        $session = \Yii::$app->session;
        $staff = $session['loginUser'];

        return $this->render('passwordmanager', array('staff' => $staff));
    }

    /*
     * 密码修改动作
     */
    public function actionPasswordchange()
    {
        $date = date('Y-m-d H:i:s');
        $request = \Yii::$app->request;
        $id = $request->post('staffID', 0);
        $staff_name = $request->post('staffName', null);
        $password = md5($request->post('pwd', null));
        $newPwd = md5($request->post('newPwd', null));

        $staff = PStaff::find()->where('id=' . $id . ' and is_delete=0')->one();
        if ($staff != null) {
            if ($staff->password != $password) {
                echo "-2";   //原密码不符
            } else {
                $staff->password = $newPwd;
                $staff->update_time = $date;
                $staff->save();
                echo "1";  //更新成功
            }
        } else {
            echo "-1"; //该id不存在
        }
        exit;
    }
}