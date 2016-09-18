<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author Taras Makitra <makitrataras@gmail.com>
 */
class SiteSettings extends \yeesoft\settings\models\GeneralSettings
{

    public $phone;
    public $vk;
    public $fb;
    public $in;
    public $tw;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['phone', 'vk', 'fb', 'in', 'tw'], 'safe'],
                ['title', 'default', 'value' => 'Title Site'],
            ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors['ml']['requireTranslations'] = true;
        return $behaviors;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),
            [
                'vk' => Yii::t('yee/settings', 'vkontakte'),
                'fb' => Yii::t('yee/settings', 'facebook'),
                'in' => Yii::t('yee/settings', 'instagram'),
                'tw' => Yii::t('yee/settings', 'twitter'),
                'phone' => Yii::t('yee/settings', 'Phone number'),
            ]);
    }

}