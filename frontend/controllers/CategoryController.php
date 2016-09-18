<?php

namespace frontend\controllers;

use backend\models\CustomPost;
use Yii;
use yeesoft\post\models\Category;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CategoryController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug = 'index')
    {
        if (empty($slug) || $slug == 'index') {
            throw new NotFoundHttpException('Page not found.');
        } else {
            $category = Category::find()->where(['slug' => $slug]);
            $categoryCount = clone $category;
            if (!$categoryCount->count()) {
                throw new NotFoundHttpException('Page not found.');
            }
        }

        $query = CustomPost::find()->joinWith('category')->where([
            'status' => CustomPost::STATUS_PUBLISHED,
            Category::tableName() . '.slug' => $slug,
        ])->orderBy('published_at DESC');
        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 10),
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
                'posts' => $posts,
                'category' => $category->one(),
                'pagination' => $pagination,
        ]);
    }
}