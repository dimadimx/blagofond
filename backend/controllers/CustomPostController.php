<?php
namespace backend\controllers;

use backend\models\Images;
use backend\models\Volunteer;
use yeesoft\controllers\admin\BaseController;
use yeesoft\models\User;
use yeesoft\media;
use yii;
use yii\web\UploadedFile;

class CustomPostController extends \yeesoft\controllers\admin\BaseController
{

    public $modelClass = '\backend\models\CustomPost';
    public $modelSearchClass = 'yeesoft\post\models\search\PostSearch';
//    public $viewPath   = '@backend/views/custom-post/upload/';
    public $layout = '@backend/views/layouts/admin/main.php';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = new $this->modelClass;
        $secModel = new Volunteer;
        $thModel['new'] = new Images;

        if ($model->load(Yii::$app->request->post()) && $secModel->load(Yii::$app->request->post()) && $thModel['new']->load(Yii::$app->request->post())) {
            if ($model->validate() && $secModel->validate() && $thModel->validate()) {
                $model->save(false);
                $secModel->post_id = $model->id;
                $secModel->save(false);
                $this->uploadFiles($thModel['new'], $model->id);

                Yii::$app->session->setFlash('crudMessage', 'Your item has been created.');
                return $this->redirect($this->getRedirectPage('create', $model));
            } else {
                Yii::$app->session->setFlash('errorMessage', 'Error please try again later :(');
                return false;
            }
        }

        return $this->renderIsAjax('create', compact('model','secModel','thModel'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);
        $secModel = Volunteer::findOne(['post_id' => $id]);
        $thModel['new'] = new Images;
        $thModel['old'] = $thModel['new']::findAll(['post_id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $secModel->load(Yii::$app->request->post()) && $thModel['new']->load(Yii::$app->request->post())) {
            if ($model->save() && $secModel->save()) {
                $this->uploadFiles($thModel['new'], $model->id);

                Yii::$app->session->setFlash('crudMessage', 'Your item has been updated.');
                return $this->redirect($this->getRedirectPage('update', $model));
            } else {
                Yii::$app->session->setFlash('errorMessage', 'Error please try again later :(');
                return false;
            }
        }

        return $this->renderIsAjax('update', compact('model','secModel','thModel'));
    }

    private function uploadFiles($model, $id)
    {
        $routes = Yii::$app->getModule('media')->routes;
        $rename = Yii::$app->getModule('media')->rename;
        $thumbs = Yii::$app->getModule('media')->thumbs;

        $files = UploadedFile::getInstances($model, 'file');
        $delete = Yii::$app->request->post('Images');
        if ($delete['delete'] || $files) {
            $model->deleteOldFiles($routes, $id);
        }

        if ($files) {
            foreach ($files as $file) {
                try {
                    $model->saveUploadedFile($routes, $rename, null, $file, $id);

                    if ($model->isImage()) {
                        $model->createThumbs($routes, $thumbs);
                    }

                } catch (\Exception $exc) {
                    return Yii::$app->session->setFlash('errorMessage', $exc->getMessage() . ' :(');
                }
                $model = new Images;
            }
        }
    }
    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);
        $secModel = Volunteer::findOne(['post_id' => $model->id]);
        $model->delete();
        $secModel->delete();

        Yii::$app->session->setFlash('crudMessage', 'Your item has been deleted.');
        return $this->redirect($this->getRedirectPage('delete', $model));
    }

    protected function getRedirectPage($action, $model = null)
    {
        if (!User::hasPermission('editPosts') && $action == 'create') {
            return ['view', 'id' => $model->id];
        }

        switch ($action) {
            case 'update':
                return ['/post/update/'.$model->id];
                break;
            case 'create':
                return ['/post/update/'.$model->id];
                break;
            case 'delete':
                return ['/post'];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }


}
?>