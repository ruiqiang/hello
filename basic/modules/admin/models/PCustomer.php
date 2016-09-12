<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_customer".
 *
 * @property string $id
 * @property string $customer_name
 * @property string $customer_contact
 * @property string $customer_industry
 * @property string $customer_address
 */
class PCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_name', 'customer_industry'], 'string', 'max' => 50],
            [['customer_contact'], 'string', 'max' => 20],
            [['customer_address'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'customer_contact' => 'Customer Contact',
            'customer_industry' => 'Customer Industry',
            'customer_address' => 'Customer Address',
        ];
    }
}
