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
     */
    public static function getTreeMenuList() {
        $menuList = PMenu::find()->where("`menu_level` = 1")->all();
        foreach($menuList as $key => $menu) {
            $childMenuList = PMenu::find()->where('`parent_id` = "' . $menu->id . '"')->all();
            $menuList[$key]['childMenus'] = $childMenuList;
        }
        return $menuList;
    }
}
