<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\EventAsset;
use yii\helpers\Url;
EventAsset::register($this);
$this->title ='Events List';

?>
    <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
        <h1><?= Html::encode($this->title) ?></h1><?= Html::a('Create Event',['/event/eventform'],['class'=>'btn btn-success']);?>
    </div>
    <div class="row white-background">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="friend-nav">
                <?php $form = ActiveForm::begin(); ?>
                    <ul>
                        <li><a href=<?=Url::to(['/event/event-list'])?> <?php if(empty($active)){echo "class='active'";} ?>>All</a></li>
                        <li><a href=<?=Url::to(['/event/event-list','active'=>2])?> <?php if($active == 2){echo "class='active'";} ?>>Going</a></li>
                        <li><a href=<?=Url::to(['/event/event-list','active'=>3])?> <?php if($active == 3){echo "class='active'";} ?>>Maybe</a></li>
                        <li><a href=<?=Url::to(['/event/event-list','active'=>4])?> <?php if($active == 4){echo "class='active'";} ?>>Decline</a></li>
                        <li><a href='#'>Finished</a></li>
                    </ul>
                <?php ActiveForm::end(); ?>
            </div>
            <table class='table table-bordered'>

            <?php if(!empty($created_events)) : ?>
                <?php foreach ($created_events as $key => $created_event) : ?>
                    <tr>
                        <td rowspan="2">
                            Title: <b><?= $created_event['title']; ?></b><br>
                            Detail: <?= $created_event['eventSelection'][0]['event_name']?><br>
                            Location: <?= $created_event['eventSelection'][0]['event_location'] ?>
                        </td>
                        <td>Date: <?= date('Y-m-d H:i:s', $created_event['eventSelection'][0]['event_time']) ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?= Html::a('Edit','#',['class'=>'btn btn-warning']) ?>
                            <?= Html::a('Cancel','#',['class'=>'btn btn-danger','data-confirm'=>"Are you sure?"]) ?>
                                            
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>

            <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $k => $event) : ?>
                        <tr>
                            <td rowspan="2">
                                Title: <b><?= $event['event']['title']; ?></b><br>
                                Detail: <?= $event['event']['eventSelection'][0]['event_name']; ?><br>
                                Location: <?= $event['event']['eventSelection'][0]['event_location']; ?><br>
                            </td>
                            <td>Date: <?= date('dM Y, H:i', $event['event']['eventSelection'][0]['event_time']); ?></td>
                            <tr>
                                <?php if($event['status'] == 1) :?>
                                    <td>
                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>
                                        <?= Html::a('Maybe',['/event/confirm-event','eid'=>$event['event_id'],'status'=>3],['class'=>'btn btn-warning','data-confirm'=>"Maybe Going?"]) ?>
                                        <?= Html::a('Decline',['/event/confirm-event','eid'=>$event['event_id'],'status'=>4],['class'=>'btn btn-danger','data-confirm'=>"Declining to going?"]) ?>
                                    </td>
                                <?php elseif($event['status'] == 2): ?>
                                    <td class='success-box'>Going</td>
                                <?php elseif($event['status'] == 3): ?>
                                    <td class='warning-box'>Maybe</td>
                                <?php elseif($event['status'] == 4): ?>
                                    <td class='danger-box'>Declined</td>
                                <?php endif;?>
                            </tr>
                            
                        </tr>
                    <?php endforeach;?>
            <?php endif;?>

            </table>
        </div>
    </div>

