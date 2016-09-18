<?php

use yii\helpers\Url;
use yii\helpers\Html;
use \backend\models\Images;

/* @var $post yeesoft\post\models\Post */

$page = (isset($page)) ? $page : 'post';
?>
<?php
    $volunteer = $post->volunteer;
    $images = $post->images;
?>
<!--# detailed #-->
<div class="detailed">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="detailedWrapper row">
                    <div class="col-sm-6 col-xs-12 detailPic">
                        <div id="bigPic">
                            <?= $post->getThumbnail(['class' => '', 'style' => '']) ?>
                        </div>
                        <div id="thumbnails">
                            <div>
                                <div><?= $post->getThumbnail(['class' => '', 'style' => '']) ?></div>
                                <?php foreach ($images as $value) { ?>
                                    <div><?= Html::img($value->attributes['url'])?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12 detailInfo">
                        <h1><?= $post->title ?></h1>
                        <div class="detailShortInfo">
                            <div><strong>Кампанія триває:</strong> з <?= Yii::$app->formatter->asDate($volunteer->begin_at) ?> по <?= Yii::$app->formatter->asDate($volunteer->end_at) ?></div>
                            <div><strong>Організатор:</strong> <a href="<?= Url::to(['/category/index', 'slug' => $post->category->slug]) ?>"><?= $post->category->title ?></a></div>
                        </div>
                        <p class="detailsDesc"><?= $post->shortContent ?></p>

                        <div class="clr">
                            <form>
                                <input type="text" value="100" />
                                <input type="submit" value="Надіслати" class="btn2 bg-green" />
                            </form>
                        </div>

                        <div class="detailsProgress">
                            <div class="progressWidth" style="width: 88%;"></div>
                            <div class="procent">88%</div>
                            <div class="moneyStage">
                                <span class="moneyGet">22000</span>
                                <span class="moneyGoal"><?= $volunteer->price ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end detailed #-->

<!--# content-block #-->
<div class="contentBlock">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2>Більше інформації</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?= ($page === 'post') ? $post->content : $post->shortContent ?>
            </div>
        </div>
    </div>
</div>
<!--# end content-block #-->