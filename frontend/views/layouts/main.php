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
        'brandLabel' =>' <em>#Jio</em>meout',
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

<footer class="mainfooter">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
<
<?php if(!Yii::$app->user->isGuest): ?>
    <nav class="bottom-right-container"  > 
    
     <a href=<?= Url::to(['/event/eventform','type'=>1]);?> class="bottom-right-button" tooltip="Event">
        <div class="fba-icon icon-calendar-position"><i class="fa fa-calendar"></i></div>
    </a>
    
    <a href=<?= Url::to(['/event/eventform','type'=>2]);?> class="bottom-right-button" tooltip="Movie">
        <div class="fba-icon icon-film-position"><i class="fa fa-film"></i></div>
    </a>
    
    <a  class="bottom-right-button" tooltip="Add">
        <div class="fba-icon icon-plus-position"><i class="fa fa-plus"></i></div>
    </a>


  </nav>
<?php endif;?>
</footer>

<?php $this->endBody() ?>   

<script>

$(document).ready(function() {
   
    $('.navbar-toggle').on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass("open");
    });

    var prevScrollpos = window.pageYOffset;
    var mainNav = $('.navbar-toggle');
    var secNav = $('.navbar-collapse');
    window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
      if (mainNav.hasClass("open")&&(prevScrollpos != currentScrollPos)) {
            secNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");

      }
      prevScrollpos = currentScrollPos;
    }
});
</script>

</body>
</html>
<?php $this->endPage() ?>


