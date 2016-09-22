<?php

namespace backend\models;

use yeesoft\post\models\Post;
use Yii;
use yii\helpers\ArrayHelper;

use yeesoft\post\models\Tag;

use yeesoft\models\OwnerAccess;

/**
 * This is the model class for table "CustomPost".
 * * @property Volunteer[] $volunteer
 * * @property Images[] $images
 */

class CustomPost extends \yeesoft\post\models\Post implements OwnerAccess
{

    public $viewList;
    public $layoutList;
    public $thumbnailSize =  'medium';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(in_array($this->thumbnailSize, [])){
            $this->thumbnailSize = 'medium';
        }

        if (empty($this->viewList)) {
            $this->viewList = [
                'post' => Yii::t('yee', 'Post view'),
                'news' => Yii::t('yee', 'News view')
            ];
        }

        if (empty($this->layoutList)) {
            $this->layoutList = [
                'main' => Yii::t('yee', 'Main layout')
            ];
        }

//        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'saveVolunteer']);
//        $this->on(self::EVENT_AFTER_INSERT, [$this, 'saveVolunteer']);

    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['thumbnail'], 'required'],
            ]);
    }
//
//    public function attributeLabels()
//    {
//        return ArrayHelper::merge(parent::attributeLabels(),
//            [
//                'price' => Yii::t('yee/post', 'need money'),
//                'begin_at' => Yii::t('yee/post', 'Date of end'),
//                'end_at' => Yii::t('yee/post', 'Date of launch'),
//            ]);
//    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'slug' => [
                    'class' => 'common\behaviors\Slug',
                    'in_attribute' => 'title',
                    'out_attribute' => 'slug',
                    'translit' => true
                 ]
            ]);
    }

    public function getVolunteer()
    {
        return $this->hasOne(Volunteer::className(), ['post_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(Images::className(), ['post_id' => 'id']);
    }
    /**
     * Handle save tags event of the owner.
     */
    public function saveTags()
    {
        /** @var Post $owner */
        $owner = $this->owner;

        $post = Yii::$app->getRequest()->post('CustomPost');
        $tags = (isset($post['tagValues'])) ? $post['tagValues'] : null;

        if (is_array($tags)) {
            $owner->unlinkAll('tags', true);

            foreach ($tags as $tag) {
                if (!ctype_digit($tag) || !$linkTag = Tag::findOne($tag)) {
                    $linkTag = new Tag(['title' => (string) $tag]);
                    $linkTag->setScenario(Tag::SCENARIO_AUTOGENERATED);
                    $linkTag->save();
                }

                $owner->link('tags', $linkTag);
            }
        }
    }

}