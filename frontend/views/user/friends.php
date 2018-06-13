<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;

UserAsset::register($this);

?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="friend-nav">
                <ul>
                    <li><?= Html::a('Friend List',['/user/friends'],['class'=>'active']); ?></li>
                    <li><?= Html::a('Pending',['/user/pending-friends']); ?></li>
                    <li><?= Html::a('Suggestion',['/user/find-friends']); ?></li>
                </ul>
            </div>

            <table class='table table-hover table-result'>

            <?php if (!empty($request)) : ?>
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
            <?php endif;?>

            <?php if(!empty($friends)) : ?>
                    <?php foreach ($friends as $ke => $friend) : ?>
                        <tr>
                            <td><font class="font-result"><?= $friend['foreignUser']['username']; ?></font></td>
                            <td><?= Html::a('Delete',['/user/delete-friend','id'=>$friend['foreign_uid']],['data-confirm'=>'Are you sure?','class'=>'btn btn-warning']); ?></td>

                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </table>
        </div>
    </div>

