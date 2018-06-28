<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use frontend\models\CreateEventForm;
use common\models\event\{Events,EventDetails,EventInvPerson};
use common\models\user\{User,UserRelations,UserFriendRequests};

class EventController extends Controller
{   
     public function actionIndex($active ='')
    {   


        if (Yii::$app->user->isGuest) {      
            Yii::$app->session->setflash('warning','Please log in first');
            return $this->redirect(['/site/login']);
        }
        $ongoingevent = EventInvPerson::find()->where('uid = :id AND status = 2',[':id'=>Yii::$app->user->identity->id])->all();
        $checkevent = array();
        
        if(!$ongoingevent == 0){
            foreach ($ongoingevent as $num => $checkid) {
                $statuscheckevent = 1; 
                $checkevent[] =Events::find()->where('id = :id ',[':id'=>$checkid['event_id']])->one();
            }        
       
        }else{
                $statuscheckevent = 0;    
            $checkevent[0] = 'No events';
        }

        $friendrequests = UserFriendRequests::find()->where('requester_uid = :id',[':id'=>Yii::$app->user->identity->id])->count();
        $friends = UserRelations::find()->where('primary_uid = :id',[':id'=>Yii::$app->user->identity->id])->count();


        //copy form event list and make some change
        $events = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->joinWith('event','user');

        if (!empty($active)) {
            $events = $events->andWhere(['=','event_inv_person.status',$active]);
        }

        $events = $events->andWhere(['=','events.status',2])->andWhere(['!=','events.organizer_id',Yii::$app->user->identity->id])->all();
        $created_events = Events::find()->where('organizer_id = :oid',[':oid'=>Yii::$app->user->identity->id])->joinWith('eventSelection')->all();


        return $this->render('index',['checkevent'=>$checkevent,'friendrequests'=>$friendrequests,'friends'=>$friends,'events'=>$events,'statuscheckevent'=>$statuscheckevent,'created_events'=>$created_events,'active'=>$active]);
    }
    public function actionEventform($type)
    {
        if (Yii::$app->user->isGuest) {      
            Yii::$app->session->setflash('warning','Please log in first');
            return $this->redirect(['/site/login']);
        }

        $model = new CreateEventForm();
        $userlist = Arrayhelper::map(UserRelations::find()->where('primary_uid = :pu',[':pu'=>Yii::$app->user->identity->id])->joinWith('foreignUser')->all(),'foreign_uid','foreignUser.username');

        if($model->load(Yii::$app->request->post())){
            $event = $model->eventform($type);

            if($event != false){
                Yii::$app->getSession()->setFlash('success','Created success');
                return $this->redirect(['/event/event-fill-details','eid'=>$event['id']]);
            };
        }

        return $this->render('eventform', ['model' => $model,'userlist'=>$userlist,'type'=>$type]);
    }

    public function actionEventFillDetails($eid)
    {   
        $event = Events::find()->where('events.id=:id',[':id'=>$eid])->joinWith('eventSelection')->one();
        $inv_person = EventInvPerson::find()->where('event_id = :eid and uid = :uid',[':eid'=>$eid,':uid'=>Yii::$app->user->identity->id])->one();
        if (empty($inv_person)) {
            Yii::$app->session->setFlash('warning','You are not invited to this event!');
            return $this->redirect(['/event/index']);
        }
        //poll == 0 means only organizer can add detail, so invt person cant access
        if ($event['poll'] == 0 && $event['organizer_id']!=Yii::$app->user->identity->id) {
            Yii::$app->session->setFlash('warning','Event still pending!');
            return $this->redirect(['/event/index']);
        }

        $event_details = new EventDetails();
        $event_details['event_id'] = $eid;

        if (Yii::$app->request->post()) {
            
            //it is a no poll event, redirect to its function
            if ($event['poll'] == 0) {
                $event_details = self::editNoPollDetail(Yii::$app->request->post(),$event);
                if ($event_details['valid'] ==true) {
                    Yii::$app->session->setFlash('success',$event_details['message']);
                    return $this->redirect(['/event/event-list']);
                }
                else{
                    Yii::$app->session->setFlash('warning',$event_details['message']);
                }
            }
            else{
                //check empty chosen selection
                if (!empty(Yii::$app->request->post('selection'))) {
                    //if same as current poll, redirect to home
                    if (Yii::$app->request->post('selection') == $inv_person['event_detail_id']) {
                        return $this->redirect(['/event/event-list']);
                    }
                    //if selection was other, function add new detail
                    if (Yii::$app->request->post('selection') == 'other') {
                        $add_new = self::addNewEventDetail(Yii::$app->request->post(),$eid,$event);
                        if ($add_new['valid']==true) {
                            Yii::$app->session->setFlash('success',$add_new['message']);
                        }
                    }
                    else{
                        $valid = self::chosenPoll($eid,Yii::$app->request->post('selection'));
                        Yii::$app->session->setFlash('success','Changed!');
                    }

                    //change event status
                    if ($event['status'] == 1 && $event['organizer_id']==Yii::$app->user->identity->id) {
                        $event['status'] = 2;
                        $event->save();
                    }
                }
                else{
                    Yii::$app->session->setFlash('warning','Please select at least one selection.');
                }
            }
            return $this->redirect(['/event/event-list']);
        }

        //if event list look, must be show in modal
        $word_start = strrpos(Yii::$app->request->referrer, '?r=') + 3; // +3 to not showing ?r= word, it get the begin number of url 
        $permissionName = substr(Yii::$app->request->referrer, $word_start); //it get the later on url, here means controller/action
        //if from event/eventlist, then return Ajax
        if ($permissionName == 'event/event' || $permissionName == 'event%2Fevent-list' || $permissionName == 'event%2Findex' ) {
            return $this->renderAjax('event-fill-details', ['event'=>$event,'event_details' => $event_details,'inv_person'=>$inv_person]);
        }
        return $this->render('event-fill-details', ['event'=>$event,'event_details' => $event_details,'inv_person'=>$inv_person]);
    }

    public static function editNoPollDetail($post,$event)
    {
        $data = array();
        $data['valid'] = '';
        $data['message'] = '';
       
        $checkid = EventDetails::find()->where('event_id = :id',[':id' => $event['id']])->one();
        
        if($checkid == null){
            $event_details = new EventDetails();
        }else{
            $event_details = $checkid;
        }
        

        $event_details['event_id'] = $event['id'];

        $event_details->load($post);

        $event_details['poll'] = $event['poll'];

        $event_details['event_time'] = strtotime($event_details['event_time']);

        //status != 2 means it was runnning, only organizer can edit event detail
        if ($event['status'] == 1 || $event['status'] == 2 && $event['organizer_id']==Yii::$app->user->identity->id) {
            if ($event_details->validate()) {
                $event_details->save();
                $event['status'] = 2;
                $event->save();
                $data['valid'] = true;
                $data['message'] = 'Event Created!';
            }
        }
        else{
            $data['valid'] = false;
            $data['message'] = 'something went wrong!';
        }
        return $data;
    }

    public static function addNewEventDetail($post,$eid,$event)
    {
        //add a new event detail when poll chosen 'other'
        //create $data to pass back validation
        $data = array();
        $data['valid'] = false;
        $data['message'] = 'smth went wrong';

        $event_details = new EventDetails();
        $event_details['event_id'] = $eid;
        $event_details['event_name'] = $post['event'];
        $event_details['event_location'] = $post['place'];
        $event_details['event_time'] = strtotime($post['EventDetails']['poll_event_time']);
        $event_details['poll'] = $event['poll'];

        if ($event_details->validate()) {

            $event_details->save();
            $inv_person = self::chosenPoll($event['id'],$event_details['id']);
            $data['valid'] = true;
            $data['message'] = 'Added Event!';
        }
        return $data;
    }

    public static function chosenPoll($eid,$detail_id)
    {
        //choose poll and save to event detail
        $inv_person = EventInvPerson::find()->where('event_id = :eid and uid = :uid',[':eid'=>$eid,':uid'=>Yii::$app->user->identity->id])->one();
        $inv_person['event_detail_id'] = $detail_id;
        //if user choose a poll, it must be going 
        $inv_person['status'] = 2;
        $inv_person->save();
    }

    public function actionEventList($active ='')
    {
        $events = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->joinWith('event','user');

        if (!empty($active)) {
            $events = $events->andWhere(['=','event_inv_person.status',$active]);
        }

        $events = $events->andWhere(['=','events.status',2])->andWhere(['!=','events.organizer_id',Yii::$app->user->identity->id])->all();
        $created_events = Events::find()->where('organizer_id = :oid',[':oid'=>Yii::$app->user->identity->id])->joinWith('eventSelection')->all();

        return $this->render('event-list',['events'=>$events,'created_events'=>$created_events,'active'=>$active]);
    }

    public function actionPassedEvents()
    {
        
        
        $active = 5;
        return $this->render('event-list',['events'=>$events,'created_events'=>$created_events,'active'=>$active]);
    }

    public function actionConfirmEvent($eid,$status)
    {
        $event_inv = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->andWhere(['=','event_id',$eid])->one();
        if ($event_inv['status'] != 1) {
            Yii::$app->session->setFlash('warning','Your replied to this event already!');
            return $this->redirect(['event-list']);
        }
        $event_inv['status'] = $status;
        $event_inv->save();

        Yii::$app->session->setFlash('success','Your gave reply to this event!');
        return $this->redirect(['event-list']);
    }

    public function actionCalendar()
    {
      

        return $this->render('calendar');
    }

   
}