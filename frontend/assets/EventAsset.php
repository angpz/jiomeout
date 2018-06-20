<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class EventAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/user.css',
        'css/animate.min.css',
        'css/event-index.css',
        'css/themify-icons.css',
    ];
    public $js = [
        'js/event.js',

        //index//
        'js/bootstrap-checkbox-radio.js',
        'js/bootstrap-notify.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
