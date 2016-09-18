<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\assets\ThemeAsset;
use yeesoft\models\Menu;
use yeesoft\widgets\LanguageSelector;
use yeesoft\widgets\Nav as Navigation;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use \yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yeesoft\comment\widgets\RecentComments;

Yii::$app->assetManager->forceCopy = true;
AppAsset::register($this);
//ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-width=1,maximum-width=1,user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <?= $this->renderMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!--# topbar #-->
<div class="topbar">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xxs-12">
                <?php $phone = Yii::$app->settings->get('general.phone'); ?>
                <?php if ($phone) { ?>
                    <div class="phoneNumber"><?php echo $phone ?></div>
                <?php } ?>
                <?php $vk = Yii::$app->settings->get('general.vk'); ?>
                <?php $fb = Yii::$app->settings->get('general.fb'); ?>
                <?php $in = Yii::$app->settings->get('general.in'); ?>
                <?php $tw = Yii::$app->settings->get('general.tw'); ?>
                <div class="socials">
                    <?php if ($vk) { ?>
                    <a href="<?php echo $vk ?>" target="_blank"><img src="/images/icon-vk.png" alt="vkontakte" /></a>
                    <?php } ?>
                    <?php if ($fb) { ?>
                    <a href="<?php echo $fb ?>" target="_blank"><img src="/images/icon-fb.png" alt="facebook" /></a>
                    <?php } ?>
                    <?php if ($tw) { ?>
                    <a href="<?php echo $tw ?>" target="_blank"><img src="/images/icon-tw.png" alt="twitter" /></a>
                    <?php } ?>
                    <?php if ($in) { ?>
                    <a href="<?php echo $in ?>" target="_blank"><img src="/images/icon-insta.png" alt="instagram" /></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-6 col-xxs-12 topbarRight">
                <div class="userMenu">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <a href="<?php echo Url::to(['/auth/default/login'])?>"><?php echo Yii::t('yee/auth', 'Login')?></a>
                        <a href="<?php echo Url::to(['/auth/default/signup'])?>"><?php echo Yii::t('yee/auth', 'Signup')?></a>
                    <?php } else { ?>
                        <a href="<?php echo Url::to(['/auth/default/profile'])?>"><?php echo Yii::$app->user->identity->username?></a>
                        <?php echo Html::a(Yii::t('yee/auth', 'Logout'), '/auth/logout', ['data' => ['method' => 'post']]); ?>
                    <?php } ?>
                </div>
                <?php if (Yii::$app->yee->isMultilingual) { ?>
                    <?php
                    $language = Yii::$app->language;
                    $languages = Yii::$app->yee->displayLanguages;
                    list($route, $params) = Yii::$app->getUrlManager()->parseRequest(Yii::$app->getRequest());
                    $params = ArrayHelper::merge(Yii::$app->getRequest()->get(), $params);
                    $url = isset($params['route']) ? $params['route'] : $route;
                    $DisplayLangShortcode = Yii::$app->yee->getDisplayLanguageShortcode($language);
                    ?>

                    <div class="langMenu">
                        <span class="currentLang" data-lang="<?php echo $DisplayLangShortcode?>"><?php echo $languages[$DisplayLangShortcode]?></span>
                        <div class="langs">
                            <?php foreach ($languages as $key => $lang) : ?>
                                <?php $link = Yii::$app->urlManager->createUrl(ArrayHelper::merge($params, [$url, 'language' => $key])); ?>
                                <span data-lang="<?php echo $key?>"><a href="<?php echo $link ?>"><?php echo $lang ?></a></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!--# end topbar #-->

<!--# top #-->
<div class="top">
    <div class="container">
        <div class="row">
            <div class="col-sm-7 col-xs-12 logoWrapper">
                <a href="<?php echo Yii::$app->homeUrl?>" class="logo">
                    <img src="/images/logo.png" />
                </a>
                <div class="slogan">
                    <?php echo Yii::$app->settings->get('general.title', 'Title Site', Yii::$app->language) ?>
                </div>
            </div>
            <div class="col-sm-5 col-xs-12">
                <span id="hamburger"></span>
                <div id="mainMenu">
                    <?php $menuItems = Menu::getMenuItems('main-menu'); ?>
                    <?php foreach ($menuItems as $key => $value) { ?>
                        <?php if ($value['visible']) { ?>
                        <a href="<?php echo Url::to([$value['url'][0]])?>"><?php echo $value['label'] ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end top #-->

<?= Alert::widget() ?>
<?= $content ?>

<!--# footer #-->
<!--# fixed buttons #-->
<div class="fixedButtons">
    <a href="#block1">Как помочь</a>
    <a href="#block2">Как получить помощь</a>
    <a href="#block3">О фонде</a>
</div>
<!--# end fixed buttons #-->

<!--# fixed buttons content #-->
<div class="fixedButtonsContent">
    <!--# block1 #-->
    <div id="block1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <img src="http://www.kidslovemartialartsgilbert.com/images/index/karate-student.png" align="left" />
                    <p>Ut urna magna, volutpat vitae egestas at, lacinia ut mi. In ac ex ex. Nunc ac aliquet ligula. Quisque dapibus porttitor sem, eu sagittis tellus mattis quis. Ut fringilla lacinia enim, in bibendum mi aliquet vitae. Nullam dignissim efficitur facilisis. Maecenas aliquam orci non turpis ullamcorper, id feugiat sapien vestibulum. Nam sollicitudin auctor lectus, ac commodo nunc rutrum quis.</p>
                    <p>Nam sit amet accumsan lacus, sodales egestas odio. Donec placerat, sapien et iaculis tempor, nisl mauris mollis purus, quis posuere ipsum nunc in massa. Aenean ultrices leo enim. Vivamus nec nisi pellentesque, ullamcorper turpis sed, sodales nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lacinia diam id feugiat consequat. Vestibulum placerat sed sem sit amet accumsan. Donec eu aliquet erat, in condimentum ipsum. Donec quis ultrices augue. Ut eget eros in velit dignissim consequat. Duis magna quam, rhoncus aliquet lorem semper, iaculis interdum turpis. Cras accumsan purus id risus dignissim efficitur. Mauris gravida mattis tellus et tristique. </p>
                </div>
            </div>
        </div>
        <span class="closeFixed"></span>
    </div>
    <!--# end block1 #-->

    <!--# block2 #-->
    <div id="block2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p>Ut urna magna, volutpat vitae egestas at, lacinia ut mi. In ac ex ex. Nunc ac aliquet ligula. Quisque dapibus porttitor sem, eu sagittis tellus mattis quis. Ut fringilla lacinia enim, in bibendum mi aliquet vitae. Nullam dignissim efficitur facilisis. Maecenas aliquam orci non turpis ullamcorper, id feugiat sapien vestibulum. Nam sollicitudin auctor lectus, ac commodo nunc rutrum quis.</p>
                    <p>Nam sit amet accumsan lacus, sodales egestas odio. Donec placerat, sapien et iaculis tempor, nisl mauris mollis purus, quis posuere ipsum nunc in massa. Aenean ultrices leo enim. Vivamus nec nisi pellentesque, ullamcorper turpis sed, sodales nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lacinia diam id feugiat consequat. Vestibulum placerat sed sem sit amet accumsan. Donec eu aliquet erat, in condimentum ipsum. Donec quis ultrices augue. Ut eget eros in velit dignissim consequat. Duis magna quam, rhoncus aliquet lorem semper, iaculis interdum turpis. Cras accumsan purus id risus dignissim efficitur. Mauris gravida mattis tellus et tristique. </p>
                </div>
            </div>
        </div>
        <span class="closeFixed"></span>
    </div>
    <!--# end block2 #-->

    <!--# block3 #-->
    <div id="block3">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p> Ut urna magna, volutpat vitae egestas at, lacinia ut mi. In ac ex ex. Nunc ac aliquet ligula. Quisque dapibus porttitor sem, eu sagittis tellus mattis quis. Ut fringilla lacinia enim, in bibendum mi aliquet vitae. Nullam dignissim efficitur facilisis. Maecenas aliquam orci non turpis ullamcorper, id feugiat sapien vestibulum. Nam sollicitudin auctor lectus, ac commodo nunc rutrum quis.</p>
                    <p>Nam sit amet accumsan lacus, sodales egestas odio. Donec placerat, sapien et iaculis tempor, nisl mauris mollis purus, quis posuere ipsum nunc in massa. Aenean ultrices leo enim. Vivamus nec nisi pellentesque, ullamcorper turpis sed, sodales nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lacinia diam id feugiat consequat. Vestibulum placerat sed sem sit amet accumsan. Donec eu aliquet erat, in condimentum ipsum. Donec quis ultrices augue. Ut eget eros in velit dignissim consequat. Duis magna quam, rhoncus aliquet lorem semper, iaculis interdum turpis. Cras accumsan purus id risus dignissim efficitur. Mauris gravida mattis tellus et tristique. </p>
                </div>
            </div>
        </div>
        <span class="closeFixed"></span>
    </div>
    <!--# end block3 #-->

</div>
<!--# end fixed buttons content #-->

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xxs-12">
                <div class="footerMenu">
                    <?php foreach ($menuItems as $key => $value) { ?>
                        <?php if ($value['visible']) { ?>
                            <a href="<?php echo Url::to([$value['url'][0]])?>"><?php echo $value['label'] ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?//= yeesoft\Yee::powered() ?>
                <div class="copyright">&copy; <?= Html::encode(Yii::$app->settings->get('general.title', 'Yee Site', Yii::$app->language)) ?> <?= date('Y') ?></div>
            </div>
            <div class="col-xs-6 col-xxs-12 footerRight">
                <?php if ($phone) { ?>
                <div class="phoneNumber"><?php echo $phone ?></div>
                <?php } ?>

                <div class="socials">
                    <?php if ($vk) { ?>
                        <a href="<?php echo $vk ?>" target="_blank"><img src="/images/icon-vk.png" alt="vkontakte" /></a>
                    <?php } ?>
                    <?php if ($fb) { ?>
                        <a href="<?php echo $fb ?>" target="_blank"><img src="/images/icon-fb.png" alt="facebook" /></a>
                    <?php } ?>
                    <?php if ($tw) { ?>
                        <a href="<?php echo $tw ?>" target="_blank"><img src="/images/icon-tw.png" alt="twitter" /></a>
                    <?php } ?>
                    <?php if ($in) { ?>
                        <a href="<?php echo $in ?>" target="_blank"><img src="/images/icon-insta.png" alt="instagram" /></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--# end footer #-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
