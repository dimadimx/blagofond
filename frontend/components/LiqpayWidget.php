<?php

namespace frontend\components;

use Yii;
use voskobovich\liqpay\widgets\PaymentWidget;


/**
 * Class LiqpayWidget
 * @package frontend\components
 */
class LiqpayWidget extends PaymentWidget
{
//    public $viewPath   = '@voskobovich/liqpay/widgets/views/paymentForm';
    /**
     * @return string|void
     */
    public function run()
    {
        /** @var \voskobovich\liqpay\LiqPay $liqPay */
        $liqPay = Yii::$app->get('liqpay');
        $model = $liqPay->buildForm($this->data);

        if (!$model->language) {
            $model->language = $this->data['language'];
        }
        if (!$model->server_url) {
            $model->server_url = $this->data['server_url'];
        }
        if (!$model->result_url) {
            $model->result_url = $this->data['result_url'];
        }

        $model->validate();

        return $this->render('/components/paymentForm', [
            'model' => $model,
            'autoSubmit' => $this->autoSubmit,
            'autoSubmitTimeout' => $this->autoSubmitTimeout
        ]);
    }
}