<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_menu".
 *
 * @property string $id
 * @property string $menu_name
 * @property string $menu_url
 * @property string $parent_id
 * @property integer $menu_level
 * @property string $menu_note
 * @property string $create_time
 * @property string $update_time
 */
class PMenu extends \yii\db\ActiveRecord
{
    public $childMenus;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_name', 'menu_url', 'parent_id', 'menu_level', 'create_time', 'update_time'], 'required'],
            [['parent_id', 'menu_level'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['menu_name'], 'string', 'max' => 50],
            [['menu_url', 'menu_note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_name' => 'Menu Name',
            'menu_url' => 'Menu Url',
            'parent_id' => 'Parent ID',
            'menu_level' => 'Menu Level',
            'menu_note' => 'Menu Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * 获取菜单树列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTreeMenuList() {
        $menuList = PMenu::getSubMenuList(0);
        return $menuList;
    }

    /**
     * 返回JSTree需要的json数据
     * @param $menulist
     * @param $roleMenuList
     * @return array
     */
    public static function responseTreeJsonData($menulist, $roleMenuList = null) {
        $jsonArray = array();
        foreach($menulist as $key=>$menu) {
            $jsonArray[$key]['text'] = $menu->menu_name;
            $jsonArray[$key]['id'] = $menu->id;
            if(count($menu->childMenus) > 0) {
                $jsonArray[$key]['children'] = PMenu::responseTreeJsonData($menu->childMenus, $roleMenuList);
                $jsonArray[$key]['state']['opened'] = "true";
                $jsonArray[$key]['icon']= "glyphicon glyphicon-folder-open";
            }
            if(in_array($menu->id,$roleMenuList)) {
                $jsonArray[$key]['state']['selected'] = "true";
            }
        }
        return $jsonArray;
    }

    /**
     * 获取某个菜单的全部子菜单
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getSubMenuList($id) {
        $menuList = PMenu::find()->where('`parent_id` = "' . $id . '"')->all();
        foreach($menuList as &$li) {
            $li['childMenus'] = PMenu::getSubMenuList($li['id']);
        }
        return $menuList;
    }
}
