<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;

UserAsset::register($this);
$this->title = 'Friends List';

?>
<div class="container white-background">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php if (!empty($request)) : ?>
                <table class='table table-hover table-result'>
                    <?php foreach ($request as $k => $value) :?>
                        <tr>
                            <td>
                                <font class="font-result"><?= $value['requester']['username']; ?></font>
                            </td>
                            <td><?= Html::a('Accept',['/user/accept-friend','id'=>$value['requester_uid']],['class'=>'btn btn-success']) ?></td>
                            <td><?= Html::a('Ignore',['/user/ignore-friend','id'=>$value['requester_uid']],['class'=>'btn btn-warning','data-confirm'=>"Are you sure?"]) ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <hr>
            <?php endif;?>

            <?php if(!empty($friends)) : ?>
                <table class='table table-hover table-result'>
                    <?php foreach ($friends as $ke => $friend) : ?>
                        <tr>
                            <td>
                                <font class="font-result"><?= $friend['foreignUser']['username']; ?></font>
                                <?= Html::a('Delete',['/user/delete-friend'],['data-confirm'=>'Are you sure?','class'=>'btn btn-warning']); ?>
                            </td>

                        </tr>
                        
                    <?php endforeach;?>
                </table>
            <?php endif;?>

        </div>
    </div>
</div>
