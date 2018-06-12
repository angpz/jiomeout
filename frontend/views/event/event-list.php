<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\EventAsset;

EventAsset::register($this);
$this->title ='Events List';

?>
<div class="container">
    <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
        <h1><?= Html::encode($this->title) ?></h1><?= Html::a('Create Event',['/event/eventform'],['class'=>'btn btn-success']);?>
    </div>
    <div class="row white-background">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="friend-nav">
                <ul>
                    <li><?= Html::a('All',['/event/event-list'],['class'=>'active']); ?></li>
                    <li><?= Html::a('Going','#'); ?></li>
                    <li><?= Html::a('Maybe','#'); ?></li>
                    <li><?= Html::a('Decline','#'); ?></li>
                    <li><?= Html::a('Finished','#'); ?></li>
                </ul>
            </div>
            <table class='table table-hover'>

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
                                <?php if($event['status'] == 2) :?>
                                    <td>
                                        <?= Html::a('Going',['/event/accept-event','eid'=>$event['event_id']],['class'=>'btn btn-success']) ?>
                                        <?= Html::a('Maybe','#',['class'=>'btn btn-warning','data-confirm'=>"Are you sure?"]) ?>
                                        <?= Html::a('Decline','#',['class'=>'btn btn-danger','data-confirm'=>"Are you sure?"]) ?>
                                    </td>
                                <?php elseif($event['status'] == 3): ?>
                                    <td class='success-box'>Accepted</td>
                                <?php elseif($event['status'] == 4): ?>
                                    <td>Declined</td>
                                <?php endif;?>
                            </tr>
                            
                        </tr>
                    <?php endforeach;?>
            <?php endif;?>

            </table>
        </div>
    </div>
</div>
