<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomPost */
/* @var $secModel backend\models\Volunteer */

$this->title = Yii::t('yee', 'Create {item}', ['item' => Yii::t('yee/post', 'Post')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model','secModel','thModel')) ?>
</div>
