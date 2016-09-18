<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contentBlock contentInner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p>This is the About page. You may modify the following file to customize its content:</p>

                <code><?= __FILE__ ?></code>
            </div>
        </div>
    </div>
</div>
