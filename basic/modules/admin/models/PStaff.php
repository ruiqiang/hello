<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_staff".
 *
 * @property string $id
 * @property string $staff_name
 * @property integer $staff_level
 * @property string $staff_aids_id
 * @property string $staff_no
 * @property string $staff_in
 * @property string $staff_workplace
 * @property string $staff_sector
 * @property string $staff_position
 * @property string $staff_phone
 * @property string $staff_email
 * @property string $staff_lastlogin
 * @property string $staff_logintime
 * @property string $create_time
 * @property string $update_time
 */
class PStaff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_staff';
    }

    public function getSector()
    {
        return $this->hasOne(PSector::className(), ['id' => 'staff_sector']);
    }

    public function getRoleId()
    {
        return $this->hasOne(PStaffRole::className(), ['staff_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_name', 'staff_no', 'create_time', 'update_time'], 'required'],
            [['staff_level', 'staff_aids_id', 'staff_no', 'staff_sector', 'staff_phone'], 'integer'],
            [['staff_in', 'staff_lastlogin', 'staff_logintime', 'create_time', 'update_time'], 'safe'],
            [['staff_name'], 'string', 'max' => 20],
            [['staff_workplace'], 'string', 'max' => 100],
            [['staff_position'], 'string', 'max' => 50],
            [['staff_email'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_name' => 'Staff Name',
            'staff_level' => 'Staff Level',
            'staff_aids_id' => 'Staff Aids ID',
            'staff_no' => 'Staff No',
            'staff_in' => 'Staff In',
            'staff_workplace' => 'Staff Workplace',
            'staff_sector' => 'Staff Sector',
            'staff_position' => 'Staff Position',
            'staff_phone' => 'Staff Phone',
            'staff_email' => 'Staff Email',
            'staff_lastlogin' => 'Staff Lastlogin',
            'staff_logintime' => 'Staff Logintime',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
