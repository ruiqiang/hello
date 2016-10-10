<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "p_customer".
 *
 * @property string $id
 * @property string $customer_company
 * @property string $customer_address
 * @property string $customer_contact
 * @property string $customer_phone
 * @property string $customer_email
 * @property string $customer_industry
 * @property string $company_id
 * @property string $creator
 * @property string $create_time
 * @property string $updater
 * @property string $update_time
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

    public function getCompany()
    {
        return $this->hasOne(PCompany::className(), ['id' => 'company_id']);
    }
}
