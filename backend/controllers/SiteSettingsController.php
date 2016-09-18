<?php
namespace backend\controllers;

class SiteSettingsController extends \yeesoft\settings\controllers\SettingsBaseController
{
    public $modelClass = '\backend\models\SiteSettings';
    public $viewPath   = '@backend/views/site-settings/index';
}
?>