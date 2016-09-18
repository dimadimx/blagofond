<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $post yeesoft\post\models\Post */

$page = (isset($page)) ? $page : 'post';
?>
<!--# campaign #-->
<div class="col-md-3 col-sm-6 col-xxs-12 campaignBlockW">
    <div class="campaignBlock">
        <a href="<?php echo Url::toRoute("/site/{$post->slug}") ?>" class="campaignPic">
            <?php echo $post->getThumbnail(['class' => '']) ?>
            <span><?php echo $post->title ?></span>
        </a>
       <p><?= ($page === 'post') ? $post->content : $post->shortContent ?></p>
        <form>
            <input type="text" value="100" />
            <input type="submit" value="Надіслати" class="btn2 bg-green" />
        </form>
        <div class="progressBlock">
            <div class="procent">88%</div>
            <div class="moneyStage">
                <span class="moneyGet">22000</span>
                <span class="moneyGoal"><?php echo $post->volunteer->price ?></span>
            </div>
        </div>
        <div class="progressBar">
            <div style="width:88%"></div>
        </div>
    </div>
</div>
<!--# end campaign #-->

