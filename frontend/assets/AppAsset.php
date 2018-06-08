<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
     public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap-theme.min.css',
        'css/fontAwesome.css',
        'css/hero-slider.css',
        'css/owl-carousel.css',
        'css/templatemo-style.css', //index main css
        'css/lightbox.css',
    ];
    public $js = [
        'js/main.js',
        'js/plugins.js',
        'js/vendor/modernizr-2.8.3-respond-1.4.2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
