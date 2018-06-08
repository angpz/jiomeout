<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;

UserAsset::register($this);

?>
<div class="container white-background top-spacing">
    <div class="row">
        <div class="col-lg-5">
            <div class="friend-nav">
                <ul>
                    <li><?= Html::a('Friend List',['/user/friends']); ?></li>
                    <li><?= Html::a('Pending',['/user/pending-friends'],['class'=>'active']); ?></li>
                    <li><?= Html::a('Suggestion',['/user/find-friends']); ?></li>
                </ul>
            </div>
            <?php if (!empty($request)) : ?>
                <table class='table table-hover table-result'>

                    <?php foreach ($request as $k => $value) :?>
                        <tr>
                            <td>
                                <font class="font-result"><?= $value['requester']['username']; ?></font>
                            </td>
                            <td>
                                <?= Html::a('Accept',['/user/accept-friend','id'=>$value['requester_uid']],['class'=>'btn btn-success']) ?>
                                <?= Html::a('Ignore',['/user/ignore-friend','id'=>$value['requester_uid']],['class'=>'btn btn-warning','data-confirm'=>"Are you sure?"]) ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            <?php endif;?>
            

        </div>
    </div>
</div>
