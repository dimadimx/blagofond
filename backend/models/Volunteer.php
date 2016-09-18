<?php

namespace backend\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * Volunteer module definition class
 */
class Volunteer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_volunteer}}';
    }

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['price'], 'number', 'min' => 0],
            ['end_at', 'date', 'timestampAttribute' => 'end_at', 'format' => 'yyyy-MM-dd'],
            ['begin_at', 'date', 'timestampAttribute' => 'begin_at', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price' => Yii::t('yee/post', 'Need money'),
            'begin_at' => Yii::t('yee/post', 'Date of end'),
            'end_at' => Yii::t('yee/post', 'Date of launch'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomPost()
    {
        return $this->hasOne(CustomPost::className(), ['id' => 'post_id']);
    }
}
?>