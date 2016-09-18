<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yeesoft\media\models\Album;

/**
 * ContactForm is the model behind the contact form.
 */
class HomeSlide extends \yeesoft\media\models\MediaSearch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'size', 'album_id', 'created_by', 'updated_by'], 'integer'],
            [['filename', 'type', 'created_at', 'updated_at', 'url', 'alt', 'description', 'thumbs', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $dataProvider = Album::find()->where($params)->joinWith('media')->one();

        return $dataProvider;
    }
}
