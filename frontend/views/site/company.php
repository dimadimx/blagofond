<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;


/* @var $this yii\web\View */

//$this->title = 'Нещодавно створенні кампанії';
?>
<!--# content-block #-->
<div class="contentBlock">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2><?= Html::encode($title) ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <?php foreach ($posts as $post) : ?>
                        <?= $this->render('/items/children.php', ['post' => $post, 'page' => 'index']) ?>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center allList">
                        <?php echo LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end content-block #-->