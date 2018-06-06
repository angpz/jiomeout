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
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

                <table class='table table-hover table-result'>
                    <?php foreach ($request as $k => $value) :?>
                        <tr>
                            <td>
                                <font class="font-result"><?= $value['requester']['username']; ?></font>
                            </td>
                            <td><?= Html::a('Accept',['/user/acccept-friend','id'=>$value['requester_uid']],['class'=>'btn btn-success']) ?></td>
                            <td><?= Html::a('Ignore',['/user/ignore-friend','id'=>$value['requester_uid']],['class'=>'btn btn-success']) ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>

        </div>
    </div>
</div>
