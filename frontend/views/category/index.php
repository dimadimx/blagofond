<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contentBlock contentInner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2><?= $category->title ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <?php /* @var $post yeesoft\post\models\Post */ ?>
                    <?php foreach ($posts as $post) : ?>

                        <?php if ($category->slug == 'news') { ?>
                            <?= $this->render('/items/news.php', ['post' => $post, 'page' => 'category']) ?>
                        <?php } else { ?>
                            <?= $this->render('/items/children.php', ['post' => $post, 'page' => 'category']) ?>
                        <?php } ?>

                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center allList">
                        <?= LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
