<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PStaff;

class AuthController extends \yii\web\Controller
{

    public $layout='admin';

    /**
     * @var array 显示的数据列
     */
    public $usercolumns = array("id","staff_name","staff_sector_name","staff_in","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $usercolumnsVal = array("id","staff_name",array("sector","sector_name"),"staff_in","");

    /**
     * @var array 显示的数据列
     */
    public $rolecolumns = array("id","role_name","role_code","create_time","edit");

    /**
     * relation 关联的字段做成数组,支持多relation的深层字段属性
     * @var array
     */
    public $rolecolumnsVal = array("id","role_name","role_code","create_time","");

    /**
     * 用户管理
     * @return string
     */
    public function actionUsermanager()
    {
        $column = DataTools::getDataTablesColumns($this->usercolumns);
        $jsonDataUrl = '/admin/auth/usermanagerjson';
        return $this->render('userManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl));
    }

    /**
     * 用户管理表格数据
     */
    public function actionUsermanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->usercolumns, $this->usercolumnsVal,
            new PStaff, "staff_name");
    }

    /**
     * 权限管理
     * @return string
     */
    public function actionRolemanager()
    {
        $column = DataTools::getDataTablesColumns($this->rolecolumns);
        $jsonDataUrl = '/admin/auth/rolemanagerjson';
        return $this->render('roleManager', array("columns" => $column, 'jsonurl'=>$jsonDataUrl));
    }

    /**
     * 权限管理列表数据
     */
    public function actionRolemanagerjson()
    {
        //请求,排序,展示字段,展示字段的字段名(支持relation字段),主表实例,搜索字段
        DataTools::getJsonData(\Yii::$app->request, "id desc", $this->rolecolumns, $this->rolecolumnsVal,
            new PRole, "role_name");
    }

    /**
     *
     * @return string
     */
    public function actionMenumanager()
    {
        $menuList = PMenu::getTreeMenuList();
        return $this->render('menuManager', array('menus' => $menuList));
    }

    /**
     * 获取单个菜单的信息
     * @param $menu_id
     */
    public function actionGetmenuinfo($menu_id)
    {
        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one()->attributes;
        $menu['childMenus'] = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
        DataTools::jsonEncodeResponse($menu);
    }

    /**
     * 更新菜单信息
     * @param $menu_id
     */
    public function actionUpdatemenuinfo()///*$menu_id, $menu_name, $menu_url*/
    {
        echo "<pre>";print_r($_POST);exit;
        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one();
        $childCount = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
        $menu->menu_name = $menu_name;
        $menu->menu_url = $menu_url;
        if($childCount > 0) {
            $menu->menu_url = null;//有子菜单的虚菜单url不做更新
        }
        $menu->save();
    }
}
