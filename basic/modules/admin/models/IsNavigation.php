<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "is_navigation".
 *
 * @property string $id
 * @property string $navi_name
 * @property integer $navi_index
 * @property integer $navi_parent_id
 * @property string $content
 * @property string $created
 * @property string $last_modified
 */
class IsNavigation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'is_navigation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['navi_name', 'navi_index', 'navi_parent_id', 'created', 'last_modified'], 'required'],
            [['navi_index', 'navi_parent_id'], 'integer'],
            [['content'], 'string'],
            [['created', 'last_modified'], 'safe'],
            [['navi_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'navi_name' => 'Navi Name',
            'navi_index' => 'Navi Index',
            'navi_parent_id' => 'Navi Parent ID',
            'content' => 'Content',
            'created' => 'Created',
            'last_modified' => 'Last Modified',
        ];
    }
}
