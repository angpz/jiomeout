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
        'fonts/font-awesome/css/font-awesome.css',
        'css/site.css',
        'css/bootstrap.css',
        'css/style.css',
        'css/prettyPhoto.css',
    ];
    public $js = [
        'js/bootstrap.js',
        'js/SmoothScroll.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery.isotope.js',
        'js/jquery.parallax.js', 
        'js/jqBootstrapValidation.js',
        'js/contact_me.js',
        'js/main.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
