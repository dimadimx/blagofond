<?php
/* @var $this yii\web\View */

use yeesoft\comments\widgets\Comments;
use yeesoft\page\models\Page;
use yii\helpers\Html;

$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;
?>
<div class="contentBlock contentInner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2><?= Html::encode($page->title) ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="page">
                    <?= $page->content ?>
                </div>
                <?php if ($page->comment_status == Page::COMMENT_STATUS_OPEN): ?>
                    <?php echo Comments::widget(['model' => Page::className(), 'model_id' => $page->id]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
