<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\switchinput\SwitchInput;
use frontend\assets\EventAsset;

EventAsset::register($this);
$this->title ='Fill In Details/Lets Vote';
?>
<div class="site-event">
     <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
    <h1><?= Html::encode($this->title) ?></h1>
   
  </div>
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
            <?php if($event['poll'] == 1): ?>

                <?php $form = ActiveForm::begin(); ?>

                    <table class='table table-hover white-background'>

                        <?php foreach ($event['eventSelection'] as $k => $selection): ?>
                            <tr>
                                <td>
                                    <!-- radio button loop -->
                                    <input type="radio" name="selection" value=<?= $selection['id']?> <?php /*find chosen detail*/ if(!empty($inv_person['event_detail_id'])){if($inv_person['event_detail_id']==$selection['id']){echo 'checked="checked"';}}?>>
                                </td>
                                <td><?= ($k+1).'. '.'<b>'.$selection['event_name'].'</b> at <b>'.$selection['event_location'].'</b> when <b>'.date('d M Y, g:i a',$selection['event_time']).'</b>'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(count($event['eventSelection'])<5): ?>
                            <tr>
                                <td><input type="radio" name="selection" value='other'></td>
                                <td>
                                    Other: <br>
                                    <input type="text" name="event" placeholder="What to do">
                                    <input type="text" name="place"  placeholder="Location">

                                    <?= $form->field($event_details, 'poll_event_time')->widget(DateTimePicker::classname(), [
                                        'options' => ['placeholder' => 'Select time'],
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd hh:ii:ss',
                                            'autoclose'=>true,
                                            'startDate' => date('Y-m-d H:ii:ss'), 
                                        ]
                                    ])->label('') ?>
                                </td>
                            </tr>
                        <?php endif;?>
                    </table>

                     <div class="form-group">
                        <?= Html::submitButton('Update', ['class' => 'btn btn-success col-lg-6', 'name' => 'signup-button']) ?>
                        <?= Html::a('Back',['/event/event-list'] ,['class' => 'btn btn-primary col-lg-6']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($event_details, 'event_name')->textInput()->label('Event Name') ?>
                    <?= $form->field($event_details, 'event_location')->textInput()->label('Event Location') ?>
                    <?= $form->field($event_details, 'event_time')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Select end time'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii:ss',
                            'autoclose'=>true,
                            'startDate' => date('Y-m-d H:ii:ss'), 
                        ]
                    ])->label('Event Time') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Create', ['class' => 'raised-btn main-btn form-control', 'name' => 'signup-button']) ?> <br>
                        <?= Html::a('Back',['/event/event-list'] ,['class' => 'form-control btn-primary']) ?> <br><br>
                    </div>
                <?php ActiveForm::end(); ?>
            <?php endif;?>
        </div>
    </div>
</div>
