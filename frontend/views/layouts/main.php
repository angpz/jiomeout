<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;


use yii\helpers\Url;
use frontend\controllers\CommonController;
AppAsset::register($this);

date_default_timezone_set("Asia/Kuala_Lumpur");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--
Tinker Template
http://www.templatemo.com/tm-506-tinker
-->
        <title>Jio Me Out</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
<body>
<?php $this->beginBody() ?>
<div class="header">
    <div class= "container">

    <?php
    NavBar::begin([
        'brandLabel' =>' <em>Jio</em>meout',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top navbar-custom',
            'role' => 'navigation',
        ],
    ]);

    $menuItems = CommonController::menuItems();

    echo Nav::widget([

        'items' => $menuItems,

        'options' => ['class' => 'nav navbar-nav navbar-right', 'id' => 'main-nav'],

    ]);

    NavBar::end();
    ?>
    </div>
</div>
    <div class='wrap'>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>   



</body>
</html>
<?php $this->endPage() ?>


