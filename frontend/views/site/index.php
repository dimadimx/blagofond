<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Homepage';
?>
<!--# head #-->
<div class="head">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php echo $slide['description'] ?></h1>
                <a href="#" class="btn2 bg-red"><?php echo Yii::t('yee/site', 'Helping children') ?></a>
            </div>
        </div>
    </div>
    <div id="slider">
        <?php foreach ($slide['media'] as $value) { ?>
            <div style="background-image:url('<?php echo $value['url']?>')"></div>
        <?php } ?>
    </div>
</div>
<!--# end head #-->

<!--# content-block #-->
<div class="contentBlock">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2>Кампанії, які майже заповнились</h2>
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
                        <a href="#" class="btn2 bg-red">ВЕСЬ СПИСОК</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end content-block #-->

<!--# content-block #-->
<div class="contentBlock">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2>Нещодавно створенні кампанії</h2>
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
                        <a href="#" class="btn2 bg-red">ВЕСЬ СПИСОК</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end content-block #-->

<!--<div class="site-index">-->
<!---->
<!--    <div class="body-content">-->
<!---->
<!--        --><?php ///* @var $post yeesoft\post\models\Post */ ?>
<!--        --><?php //foreach ($posts as $post) : ?>
                <?php //= $this->render('/items/post.php', ['post' => $post, 'page' => 'index']) ?>
<!--        --><?php //endforeach; ?>
<!---->
<!--        <div class="text-center">-->
                <?php //= LinkPager::widget(['pagination' => $pagination]) ?>
<!--        </div>-->
<!---->
<!--    </div>-->
<!--</div>-->
