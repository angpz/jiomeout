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
$this->title ='Create an Event';
?>
<div class="site-event">
     <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
    <h1><?= Html::encode($this->title) ?></h1>
   
    <p>Please fill out the following fields to signup</p>
  </div>
    <div class="container">
   <div class="col-lg-6 col-lg-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'form-event']); ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('Title') ?>

                <?= $form->field($eventdetail, 'event_name')->textInput()->label('Event Name') ?>
                <?= $form->field($eventdetail, 'event_location')->textInput()->label('Event Location') ?>
                <?= $form->field($eventdetail, 'event_time')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Select end time'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd hh:ii:ss',
                        'autoclose'=>true,
                        'startDate' => date('Y-m-d H:ii:ss'), 
                    ]
                ])->label('Event Start Time') ?>

                <?php echo $form->field($eventdetail, 'event_end_time')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Select end time'],
                    //'readonly'=>true,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd hh:ii:ss',
                        'autoclose'=>true,
                        'startDate' => date('Y-m-d H:ii:ss'), 

                    ]
                ]); ?>

                <?= $form->field($model, 'inv_friend')->checkboxList($userlist); ?>

                <div class="col-lg-3">
                    <div class="form-group">
                        <?= $form->field($model,'poll')->widget(SwitchInput::classname(),['options'=>['id'=>'switch-change'],'type' => SwitchInput::CHECKBOX,
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div clas="form-group">
                         <?= $form->field($model, 'poll_close_time')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Select end time','class'=>'poll-time'],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                                'autoclose'=>true,
                                'startDate' => date('Y-m-d H:ii:ss'), 
                            ]
                        ]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'raised-btn main-btn form-control', 'name' => 'signup-button']) ?> <br>
                    <?= Html::a('Back',['/event/event-list'] ,['class' => 'form-control btn-primary']) ?> <br><br>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
