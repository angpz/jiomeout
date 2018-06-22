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
                        <li><a href=<?=Url::to(['/event/passed-events'])?> <?php if($active == 5){echo "class='active'";} ?>>Finished</a></li>
                    </ul>
                <?php ActiveForm::end(); ?>
            </div>
            <table class='table table-hover event-table'>

            <?php if(!empty($created_events)) : ?>
                <?php foreach ($created_events as $key => $created_event) : ?>
                    
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
                                <!-- detect event finished or not -->
                                <?php if($created_event['status']==3 ) : ?>
                                    Finished
                                    <br>
                                    <hr class="td-hr">
                                <?php else:?>
                                    <!-- detect got selection -->
                                    <?php if(!empty($created_event['eventSelection'])): ?>
                                        <!-- selection time passed but organizer not called for finish-->
                                        <?php if(time() >= $created_event['eventSelection'][0]['event_time'] ) : ?>
                                            Expired
                                            <br>
                                            <hr class="td-hr">
                                            <?= Html::a('Finished',Url::to(['/event/event-finished','eid'=>$created_event['id'],'status'=>3]),['class'=>'btn btn-success','data-confirm'=>"Finished?"]) ?>
                                            <?= Html::a('Cancel',Url::to(['/event/event-finished','eid'=>$created_event['id'],'status'=>5]),['class'=>'btn btn-danger','data-confirm'=>"Are you sure to cancel this event?"]) ?>
                                        <?php else :?>
                                            Date: <?= date('d M Y, g:i a', $created_event['eventSelection'][0]['event_time']) ?>
                                            <br>
                                            <hr class="td-hr">
                                            <?= Html::a('Edit Details',Url::to(['/event/event-fill-details','eid'=>$created_event['id']]),['class'=>'btn btn-warning','data-toggle'=>'modal','data-target'=>'#modal-one']) ?>
                                            <?= Html::a('Cancel',Url::to(['/event/event-finished','eid'=>$created_event['id'],'status'=>5]),['class'=>'btn btn-danger','data-confirm'=>"Are you sure to cancel this event?"]) ?>
                                        <?php endif;?>

                                    <!-- if organizer havent decide first selection -->
                                    <?php else: ?>
                                        Pending
                                        <br>
                                        <hr class="td-hr">
                                        <?= Html::a('Edit Details',Url::to(['/event/event-fill-details','eid'=>$created_event['id']]),['class'=>'btn btn-warning','data-toggle'=>'modal','data-target'=>'#modal-one']) ?>
                                            <?= Html::a('Cancel',Url::to(['/event/event-finished','eid'=>$created_event['id'],'status'=>5]),['class'=>'btn btn-danger','data-confirm'=>"Are you sure to cancel this event?"]) ?>
                                    <?php endif; ?>
                                <?php endif;?>
                            </td>
                        </tr>
                    
                <?php endforeach;?>
            <?php endif;?>

            <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $k => $event) : ?>
                        
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
                                <?php if(!empty($event['event']['eventSelection'])): ?>
                                    Detail: <?= $event['event']['eventSelection'][0]['event_name']; ?><br>
                                    Location: <?= $event['event']['eventSelection'][0]['event_location']; ?><br>
                                <?php endif;?>
                            </td>
                            <td class=<?= $box;?>>
                                <!-- detect event finished or not -->
                                <?php if($event['event']['status']==3 ) : ?>
                                    Finished
                                <?php elseif(time() >= $event['event']['eventSelection'][0]['event_time'] ) : ?>
                                    Expired
                                <?php else: ?>
                                    Date: <?= date('d M Y, g:i a', $event['event']['eventSelection'][0]['event_time']); ?>
                                <?php endif;?>
                                <br>
                                <hr class="td-hr">
                                <!-- !! attention !! -->
                                <!-- here $event means table event_inv_person, not event -->
                                <!-- $event['status'] = user status -->
                                <?php if($event['status'] == 1) :?>

                                    <!-- if polling available and not expired -->
                                    <?php if($event['event']['poll']==1 && $event['event']['poll_close_time'] >= time()): ?> 
                                        <?= Html::a('Going',Url::to(['/event/event-fill-details','eid'=>$event['event_id']]),['class'=>'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-one']) ?>

                                    <!-- if polling available but expired -->
                                    <?php elseif($event['event']['poll']==1 && $event['event']['poll_close_time'] <= time()): ?>
                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>

                                    <!-- not polling event -->
                                    <?php elseif($event['event']['poll']==0): ?>
                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>
                                    <?php endif; ?>

                                    <?= Html::a('Maybe',['/event/confirm-event','eid'=>$event['event_id'],'status'=>3],['class'=>'btn btn-warning','data-confirm'=>"Maybe Going?"]) ?>
                                    <?= Html::a('Decline',['/event/confirm-event','eid'=>$event['event_id'],'status'=>4],['class'=>'btn btn-danger','data-confirm'=>"Declining to going?"]) ?>

                                    <?php elseif($event['status'] == 2): ?>
                                        <!-- user intend to going and polling time still available -->
                                        Going <?php if($event['event']['poll']==1 && $event['event']['poll_close_time'] >= time()): ?> <?= Html::a('Poll',Url::to(['/event/event-fill-details','eid'=>$event['event_id']]),['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-one']) ?>
                                    <?php endif; ?>

                                <?php elseif($event['status'] == 3): ?>
                                    Maybe
                                <?php elseif($event['status'] == 4): ?>
                                    Declined
                                <?php endif;?>
                                
                            </td>
                        </tr>
                    <?php endforeach;?>
            <?php endif;?>

            </table>
        </div>
    </div>

