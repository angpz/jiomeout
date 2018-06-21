<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use frontend\assets\EventAsset;
use yii\helpers\Url;
EventAsset::register($this);
$this->title ='Events List';


Modal::begin([
      'header' => 'Details',
      'id'     => 'modal-one',
      'size'   => 'modal-md',
      'footer' => '<a href="#" data-dismiss="modal">Close</a>',
]);
Modal::end();
date_default_timezone_set("Asia/Kuala_Lumpur");
?>
    <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
        <h1><?= Html::encode($this->title) ?></h1>
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
            <table class='table table-hover event-table'>

            <?php if(!empty($created_events)) : ?>
                <?php foreach ($created_events as $key => $created_event) : ?>
                    <?php if(!empty($created_event['eventSelection'][0]['event_time']) && $created_event['eventSelection'][0]['event_time'] >= time()): ?>
                        <tr class="default-box">
                            <td><div style="float: right;font-size: 2em;"><i class="fa fa-user"></i></div>
                                Title: <b><?= $created_event['title']; ?></b><br>

                                <?php if(!empty($created_event['eventSelection'])): ?>
                                    Detail: <?= $created_event['eventSelection'][0]['event_name']?>
                                    <br>
                                    Location: <?= $created_event['eventSelection'][0]['event_location'] ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(!empty($created_event['eventSelection'])): ?>
                                    Date: <?= date('d M Y, g:i a', $created_event['eventSelection'][0]['event_time']) ?>
                                <?php else: echo 'Pending'; endif; ?>
                                <br>
                                <hr class="td-hr">
                                <?= Html::a('Edit Details',Url::to(['/event/event-fill-details','eid'=>$created_event['id']]),['class'=>'btn btn-warning','data-toggle'=>'modal','data-target'=>'#modal-one']) ?>
                                <?= Html::a('Cancel','#',['class'=>'btn btn-danger','data-confirm'=>"Are you sure?"]) ?>
                            </td>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>

            <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $k => $event) : ?>
                        <?php if(!empty($event['event']['eventSelection'][0]['event_time']) && $event['event']['eventSelection'][0]['event_time'] >= time()): ?>
                        <?php switch ($event['status']) {
                            case 2:
                                $box = 'success-box';
                                break;
                            case 3:
                                $box = 'warning-box';
                                break;
                            case 4:
                                $box = 'danger-box';
                                break;
                            
                            default:
                                $box = 'default-box';
                                break;
                        }
                        ?>
                        <tr>
                            <td class=<?= $box;?>>
                                Title: <b><?= $event['event']['title']; ?></b><br>
                                Detail: <?= $event['event']['eventSelection'][0]['event_name']; ?><br>
                                Location: <?= $event['event']['eventSelection'][0]['event_location']; ?><br>
                            </td>
                            <td class=<?= $box;?>>Date: <?= date('d M Y, g:i a', $event['event']['eventSelection'][0]['event_time']); ?>
                            <br>
                            <hr class="td-hr">
                                <?php if($event['status'] == 1) :?>

                                    <?php if($event['event']['poll']==1 && $event['event']['poll_close_time'] >= time()): ?> 
                                        <?= Html::a('Going',Url::to(['/event/event-fill-details','eid'=>$event['event_id']]),['class'=>'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-one']) ?> 
                                    <?php elseif($event['event']['poll']==1 && $event['event']['poll_close_time'] <= time()): ?>
                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>
                                    <?php elseif($event['event']['poll']==0): ?>
                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>
                                    <?php endif; ?>

                                    <?= Html::a('Maybe',['/event/confirm-event','eid'=>$event['event_id'],'status'=>3],['class'=>'btn btn-warning','data-confirm'=>"Maybe Going?"]) ?>
                                    <?= Html::a('Decline',['/event/confirm-event','eid'=>$event['event_id'],'status'=>4],['class'=>'btn btn-danger','data-confirm'=>"Declining to going?"]) ?>

                                <?php elseif($event['status'] == 2): ?>
                                    Going <?php if($event['event']['poll']==1 && $event['event']['poll_close_time'] >= time()): ?> <?= Html::a('Poll',Url::to(['/event/event-fill-details','eid'=>$event['event_id']]),['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-one']) ?> <?php endif; ?>
                                <?php elseif($event['status'] == 3): ?>
                                    Maybe
                                <?php elseif($event['status'] == 4): ?>
                                    Declined
                                <?php endif;?>

                                    </td>
                            </tr>
                            <?php endif;?>
                    <?php endforeach;?>
            <?php endif;?>

            </table>
        </div>
    </div>

