<?php

namespace frontend\controllers;

use frontend\actions\PageAction;
use frontend\actions\PostAction;
use frontend\models\ContactForm;
use frontend\models\HomeSlide;
use backend\models\CustomPost;
use backend\models\Transaction;
use yeesoft\page\models\Page;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
/**
 * Site controller
 */
class SiteController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (Yii::$app->request->get('slug') == 'thanks' or Yii::$app->request->get('slug') == 'callback') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'callback' => [
                'class' => 'voskobovich\liqpay\actions\CallbackAction',
                'callable' => 'payment',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($slug = 'index')
    {
        // display home page
        if (empty($slug) || $slug == 'index') {

            $slideModel = new HomeSlide();
            $slide = $slideModel->search(['slug' => 'slide']);

            $query = CustomPost::find()
                        ->where(['status' => CustomPost::STATUS_PUBLISHED])
                        ->andWhere(['view' => 'post'])
                        ->joinWith('volunteer');

//            $countQuery = clone $query;
//
//            $pagination = new Pagination([
//                'totalCount' => $countQuery->count(),
//                'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 10),
//            ]);

            $postsDesc = $query->orderBy('published_at DESC')
                ->limit(Yii::$app->settings->get('reading.page_size', 8))
                ->all();

            return $this->render('index', [
                'posts' => $postsDesc,
//                'pagination' => $pagination,
                'slide' => $slide,
            ]);
        }

        //try to display action from controller
        try {
            return $this->runAction($slug);
        } catch (\yii\base\InvalidRouteException $ex) {

        }

        //try to display static page from datebase
        $page = Page::getDb()->cache(function ($db) use ($slug) {
            return Page::findOne(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED]);
        }, 3600);

        if ($page) {
            $pageAction = new PageAction($slug, $this, [
                'slug'   => $slug,
                'page'   => $page,
                'view'   => $page->view,
                'layout' => $page->layout,
            ]);

            return $pageAction->run();
        }

        //try to display post from datebase
        $post = CustomPost::getDb()->cache(function ($db) use ($slug) {
            return CustomPost::findOne(['slug' => $slug, 'status' => CustomPost::STATUS_PUBLISHED]);
        }, 3600);

        if ($post) {
            $postAction = new PostAction($slug, $this, [
                'slug'   => $slug,
                'post'   => $post,
                'view'   => $post->view,
                'layout' => $post->layout,
            ]);

            return $postAction->run();
        }

        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionNewCompany()
    {
        $query = CustomPost::find()
            ->where(['status' => CustomPost::STATUS_PUBLISHED])
            ->andWhere(['view' => 'post'])
            ->joinWith('volunteer')
            ->orderBy('published_at DESC');
        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 8),
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('company', [
            'title' => 'Нещодавно створенні кампанії',
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    public function actionAlmostFinishCompany()
    {
        $query = CustomPost::find()
            ->where(['status' => CustomPost::STATUS_PUBLISHED])
            ->andWhere(['view' => 'post'])
            ->joinWith('volunteer')
            ->orderBy('published_at ASC');
        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('reading.page_size', 8),
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('company', [
            'title' => 'Кампанії, які майже заповнились',
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    public function actionSendPayment()
    {
        $request = Yii::$app->request;
        $product_url = 'index';
        $this->layout = false;
        if ($request->post('amount') and $request->post('order_id')) {
            $donatePost = CustomPost::findOne(['id' => $request->post('order_id'), 'status' => CustomPost::STATUS_PUBLISHED]);

            if ($donatePost) {
                $date = strtotime('now');
                $transactionModel = new Transaction();
                $loadData['Transaction'] = [
                    'post_id' => $request->post('order_id'),
                    'amount' => $request->post('amount'),
                    'currency' => 'UAH',
                    'create_date' => $date,
                ];
                if (!Yii::$app->user->isGuest)
                    $loadData['Transaction']['user_id'] = Yii::$app->user->id;
                if ($transactionModel->load($loadData) and $transactionModel->validate()) {
                    $transactionModel->save(false);
                    return $this->render('payment', [
                        'amount' => $request->post('amount'),
                        'order_id' => "{$transactionModel->id}",
                        'currency' => 'UAH',
                        'type' => 'donate',
                        'language' => Yii::$app->yee->getDisplayLanguageShortcode(Yii::$app->language),
                        'description' => $donatePost->title,
                        'product_url' => $donatePost->slug,
                        'server_url' => 'callback',
                        'result_url' => 'thanks',
                    ]);
                }
            }
        }

        $this->redirect($product_url);
    }


    protected function actionPayment($model)
    {
        $this->layout = false;
        $transactionModel = Transaction::findOne($model->order_id);
        if(!$transactionModel) {
            throw new NotFoundHttpException('The requested order does not exist.');
        }
        $transactionModel->amount = $model->amount;
        $transactionModel->currency = $model->currency;
        $transactionModel->type = $model->type;
        $transactionModel->status = $model->status;
        $transactionModel->server_data = json_encode($model);

        $transactionModel->save(false);
        Yii::$app->end();
    }

    public function actionThanks()
    {
        $request = Yii::$app->request;

        if (empty($request->post('data')) || empty($request->post('signature'))) {
            throw new BadRequestHttpException();
        }

        $callbackData = json_decode(base64_decode($request->post('data')), true);

        $loadData['Transaction'] = $callbackData;
        $loadData['Transaction']['commission'] = ($callbackData['sender_commission'] + $callbackData['receiver_commission'] + $callbackData['agent_commission']);
        $loadData['Transaction']['liqpay_data'] = json_encode($callbackData);

        $transactionModel = Transaction::findOne($callbackData['order_id']);

        if ($transactionModel->load($loadData)) {
            $transactionModel->save();
        }

        Yii::$app->session->setFlash('apiMessage', 'Your payment is '.$callbackData['status']);

        $this->redirect($callbackData['product_url']);
    }
}
