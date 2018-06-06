<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\UserAsset;

UserAsset::register($this);
$this->title = '"Jio" Your Friends!';

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <div class="find-friend-box">
                <?php $form = ActiveForm::begin(); ?>

                    <div class="col-lg-5">
                        <input name='username' type="text" class="form-control"?>
                    </div>

                        <?= Html::submitButton('Find', ['class' => 'btn btn-primary']) ?>

                <?php ActiveForm::end(); ?>
            </div>
            

            <?php if(!empty($result)) : ?>
                <h4>Result</h4>
                <table class='table table-hover table-result'>
                    <?php foreach ($result as $k => $value) :?>
                        <tr>
                            <td>
                                <font class="font-result"><?= $value['username']; ?></font>
                            </td>
                            <td><?= Html::a('Request',['/user/add-friend','id'=>$value['id']],['class'=>'btn btn-success']) ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            <?php endif;?>

        </div>
    </div>
</div>
