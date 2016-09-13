<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DataTools;
use app\modules\admin\models\PMenu;
use app\modules\admin\models\PRole;
use app\modules\admin\models\PRoleMenu;
use app\modules\admin\models\PStaff;

class AuthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'admin';

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

    public function actionGetmenutreedata()
    {
        $role_id = \Yii::$app->request->get('role_id','0');
        $roleMenuList = PRoleMenu::find()->select('menu_id')->where('`role_id` = "' . $role_id . '"')->asArray()->all();
        $menuList = PMenu::getTreeMenuList();
        DataTools::jsonEncodeResponse(PMenu::responseTreeJsonData($menuList, DataTools::put2dArrayTo1d($roleMenuList)));
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
     * 更新菜单信息，添加子菜单
     * 返回 -1失败 1更新成功 2更新成功并且添加子菜单成功
     */
    public function actionUpdatemenuinfo()
    {
        $request = \Yii::$app->request;
        $menu_id = $request->post('menu_id','0');
        $menu_name = $request->post('menu_name', null);
        $menu_url = $request->post('menu_url', null);

        $sub_menu_name = trim($request->post('sub_menu_name', null)) == "" ? null : trim($request->post('sub_menu_name', null));
        $sub_menu_url = trim($request->post('sub_menu_url', null)) == "" ? null : trim($request->post('sub_menu_url', null));

        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one();
        if($menu == null || $menu->id < 1) {
            echo '-1';
            exit;
        }
        $childCount = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
        $menu->menu_name = trim($menu_name) == "" ? null : trim($menu_name);
        $menu->menu_url = trim($menu_url) == "/" ? null : trim($menu_url);
        if($childCount > 0) {
            $menu->menu_url = $menu->menu_url;//有子菜单的虚菜单url不做更新
        }
        $menu->save();

        //添加子菜单
        if($sub_menu_name != null && $sub_menu_url != null) {
            $subMenu = new PMenu();
            $subMenu->menu_name = $sub_menu_name;
            $subMenu->menu_url = $sub_menu_url;
            $subMenu->parent_id = $menu_id;
            $subMenu->menu_level = $menu->menu_level + 1;
            $subMenu->create_time = date('Y-m-d H:i:s');
            $subMenu->update_time = date('Y-m-d H:i:s');
            $subMenu->save();
            echo "2";
            exit;
        }
        echo '1';
        exit;
    }

    /**
     * 删除菜单,有子菜单的菜单无法删除,需要先删除其子菜单
     * @throws \Exception
     */
    public function actionDeletemenu()
    {
        $request = \Yii::$app->request;
        $menu_id = $request->post('menu_id','0');
        $menu = PMenu::find()->where('`id` = ' . $menu_id)->one();
        if($menu != null && $menu->id > 0) {
            $childMenuCounts = PMenu::find()->where('`parent_id` = ' . $menu_id)->count();
            if($childMenuCounts < 1) {
                $menu->delete();
                echo "1";
                exit;
            } else {
                echo "0";
                exit;
            }
        }
        echo "-1";
        exit;
    }
}
