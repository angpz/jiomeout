<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\EventAsset;

date_default_timezone_set("Asia/Kuala_Lumpur");
EventAsset::register($this);
/* @var $this yii\web\View */
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
                    <div class="col-md-12">
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
                                                <?php if(!empty($created_event['eventSelection'])): ?>
                                                    Date: <?= date('d M Y, g:i a', $created_event['eventSelection'][0]['event_time']) ?>
                                                <?php else: echo 'Pending'; endif; ?>
                                                <br>
                                                <hr class="td-hr">
                                                <?= Html::a('Edit','#',['class'=>'btn btn-warning']) ?>
                                                <?= Html::a('Cancel','#',['class'=>'btn btn-danger','data-confirm'=>"Are you sure?"]) ?>
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
                                                Detail: <?= $event['event']['eventSelection'][0]['event_name']; ?><br>
                                                Location: <?= $event['event']['eventSelection'][0]['event_location']; ?><br>
                                            </td>
                                            <td class=<?= $box;?>>Date: <?= date('d M Y, g:i a', $event['event']['eventSelection'][0]['event_time']); ?>
                                            <br>
                                            <hr class="td-hr">
                                                <?php if($event['status'] == 1) :?>
                                                    
                                                        <?= Html::a('Going',['/event/confirm-event','eid'=>$event['event_id'],'status'=>2],['class'=>'btn btn-success']) ?>
                                                        <?= Html::a('Maybe',['/event/confirm-event','eid'=>$event['event_id'],'status'=>3],['class'=>'btn btn-warning','data-confirm'=>"Maybe Going?"]) ?>
                                                        <?= Html::a('Decline',['/event/confirm-event','eid'=>$event['event_id'],'status'=>4],['class'=>'btn btn-danger','data-confirm'=>"Declining to going?"]) ?>

                                                <?php elseif($event['status'] == 2): ?>
                                                    Going
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