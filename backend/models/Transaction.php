<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%transaction}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $order_id
 * @property string $amount
 * @property string $currency
 * @property string $commission
 * @property string $type
 * @property string $action
 * @property string $status
 * @property string $liqpay_data
 * @property string $server_data
 * @property string $ip
 * @property integer $create_date
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'order_id', 'amount', 'currency'], 'required'],
            [['commission', 'type', 'action', 'status', 'liqpay_data', 'server_data', 'ip'], 'safe'],
            [['post_id', 'create_date'], 'integer'],
            [['amount', 'commission'], 'number'],
            [['liqpay_data', 'server_data'], 'string'],
            [['order_id'], 'string', 'max' => 11],
            [['currency'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 20],
            [['action', 'status'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee/transaction', 'ID'),
            'post_id' => Yii::t('yee/transaction', 'Post ID'),
            'order_id' => Yii::t('yee/transaction', 'Order ID'),
            'amount' => Yii::t('yee/transaction', 'Amount'),
            'currency' => Yii::t('yee/transaction', 'Currency'),
            'commission' => Yii::t('yee/transaction', 'Commission'),
            'type' => Yii::t('yee/transaction', 'Type'),
            'action' => Yii::t('yee/transaction', 'Action'),
            'status' => Yii::t('yee/transaction', 'Status'),
            'liqpay_data' => Yii::t('yee/transaction', 'Liqpay Data'),
            'server_data' => Yii::t('yee/transaction', 'Server Data'),
            'ip' => Yii::t('yee/transaction', 'Ip'),
            'create_date' => Yii::t('yee/transaction', 'Create Date'),
        ];
    }
}
