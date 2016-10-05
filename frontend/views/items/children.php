<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $post yeesoft\post\models\Post */

$page = (isset($page)) ? $page : 'post';
$getSum = (($post->paymentSum) ? $post->paymentSum : 0);
$percent = ($getSum and (int)$post->volunteer->price) ? ($getSum / $post->volunteer->price) : (($getSum and !(int)$post->volunteer->price) ? $getSum : 0);
?>
<!--# campaign #-->
<div class="col-md-3 col-sm-6 col-xxs-12 campaignBlockW">
    <div class="campaignBlock">
        <a href="<?php echo Url::toRoute("/site/{$post->slug}") ?>" class="campaignPic">
            <?php echo $post->getThumbnail(['class' => '']) ?>
            <span><?php echo $post->title ?></span>
        </a>
       <p><?= ($page === 'post') ? $post->content : $post->shortContent ?></p>
        <form class="donate" method="post" action="<?= Url::toRoute("/site/send-payment") ?>">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="hidden" name="order_id" value="<?php echo $post->id?>" />
            <input type="text" name="amount" value="100" />
            <input type="submit" value="Надіслати" class="btn2 bg-green" />
        </form>
        <div class="progressBlock">
            <div class="procent"><?php echo Yii::$app->formatter->asPercent($percent, 2)?></div>
            <div class="moneyStage">
                <span class="moneyGet"><?php echo $getSum?></span>
                <span class="moneyGoal"><?php echo $post->volunteer->price ?></span>
            </div>
        </div>
        <div class="progressBar">
            <div style="width:<?php echo (($percent > 1) ? '100%' : Yii::$app->formatter->asPercent($percent, 2))?>"></div>
        </div>
    </div>
</div>
<!--# end campaign #-->

