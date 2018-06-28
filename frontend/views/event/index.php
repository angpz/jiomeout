<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\EventAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

EventAsset::register($this);
$this->title ='Events List';
/* @var $this yii\web\View */

Modal::begin([
      'header' => 'Details',
      'id'     => 'modal-one',
      'size'   => 'modal-md',
      'footer' => '<a href="#" data-dismiss="modal">Close</a>',
]);
Modal::end();

?>

    <div class="container">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 ">
                        <div class="card">
                            <div class="content card-hover card-create">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="material-icons" style="font-size:50px;color:rgb(243, 187, 69);">note_add</i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            Create
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        Create New events or movies
                                    </div>
                                </div>
                            </div>
                           
                            <!-- Will show when hover on Create -->
                            <div class="card-hide">
                                <div class="event-create">
                                    <a  href=<?= Url::to(['/event/eventform','type'=>1]);?>>
                                        <div class='col-xs-6 icon-create v1'>
                                            <i class="fa fa-3x fa-calendar"></i>
                                            <p>Events</p>
                                        </div>
                                    </a>
                                    <a  href=<?= Url::to(['/event/eventform','type'=>2]);?>>
                                        <div class='col-xs-6 icon-create v2'>
                                            <i class="fa fa-3x fa-film"></i>
                                            <p>Movie</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href=<?= Url::to(['/event/event-list']);?>>
                        <div class="col-lg-3 col-sm-6"> 
                            <div class="card">
                                <div class="content card-hover">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-success text-center">
                                                <i class="ti-flag-alt"></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p></p>
                                                Events
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            Near :  
                                                <?php 
                                                    //wrong formula
                                                    if($statuscheckevent==1){
                                                        echo $checkevent[0]['title'];
                                                    }
                                                ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href=<?= Url::to(['/user/friends']);?>>
                    <div class="col-lg-3 col-sm-6 ">
                        <div class="card">
                            <div class="content card-hover">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-user"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            Friends
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                       <!--  <i class="ti-timer"></i> In the last hour -->
                                       Friends: <?php echo $friends ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <div class="col-lg-3 col-sm-6 ">
                        <div class="card">
                            <div class="content card-hover">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-twitter-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Followers</p>
                                            +45
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> Updated now
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="col-lg-6 col-lg-offset-3" style="text-align:center">
                            <h1><?= Html::encode($this->title) ?></h1>
                        </div>
                        <?php $form = ActiveForm::begin(); ?>

                            <ul class="col-xs-12 event-nav ">
                                <a href=<?=Url::to(['/event/index'])?> <?php if(empty($active)){echo "class='active'";} ?>><li class="col-xs-2">All</li></a>
                                <a href=<?=Url::to(['/event/index','active'=>2])?> <?php if($active == 2){echo "class='active'";} ?>><li  class="col-xs-2">Going</li></a>
                                <a href=<?=Url::to(['/event/index','active'=>3])?> <?php if($active == 3){echo "class='active'";} ?>><li  class="col-xs-2">Maybe</li></a>
                                <a href=<?=Url::to(['/event/index','active'=>4])?> <?php if($active == 4){echo "class='active'";} ?>><li  class="col-xs-2">Decline</li></a>
                                <a href=<?=Url::to(['/event/index'])?> <?php if($active == 5){echo "class='active'";} ?>><li  class="col-xs-2">Finished</li></a>

                            
                            </ul>
                        <?php ActiveForm::end(); ?>
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
                                                        <?= Html::a('Edit Details',Url::to(['/event/event-fill-details','eid'=>$created_event['id']]),['class'=>'btn btn-warning']) ?>
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
            </div>
        </div>
</div>