<?php

//use \voskobovich\liqpay\widgets\PaymentWidget;
use frontend\components\LiqpayWidget;
use yii\helpers\Url;

echo LiqpayWidget::widget([
    'data' => [
        'amount' => $amount,
        'currency' => $currency,
        'order_id' => $order_id,
        'type' => $type,
        'language' => $language,
        'description' => $description,
        'product_url' => Url::toRoute("/site/{$product_url}", true),
        'server_url' => Url::toRoute("/site/{$server_url}", true),
        'result_url' => Url::toRoute("/site/{$result_url}", true),
    ],
]);
?>