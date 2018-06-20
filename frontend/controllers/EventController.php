<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use frontend\models\CreateEventForm;
use common\models\event\{Events,EventDetails,EventInvPerson};
use common\models\user\{User,UserRelations};

class EventController extends Controller
{
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

        $event_details = new EventDetails();
        $event_details['event_id'] = $eid;

        if (Yii::$app->request->post()) {
            //check empty chosen selection
            if (!empty(Yii::$app->request->post('selection'))) {
                //if same as current poll, redirect to home
                if (Yii::$app->request->post('selection') == $inv_person['event_detail_id']) {
                    return $this->redirect(['/event/event-fill-details','eid'=>$eid]);
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

            return $this->redirect(['/event/event-fill-details','eid'=>$eid]);
        }

        return $this->render('event-fill-details', ['event'=>$event,'event_details' => $event_details,'inv_person'=>$inv_person]);
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
        $inv_person->save();
    }

    public function actionEventList($active ='')
    {
        $events = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->joinWith('event','user');

        if (!empty($active)) {
            $events = $events->andWhere(['=','event_inv_person.status',$active]);
        }

        $events = $events->andWhere(['=','events.status',2])->all();
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
        if ($event_int['status'] != 1) {
            Yii::$app->session->setFlash('warning','Your replied to this event already!');
            return $this->redirect(['event-list']);
        }
        $event_inv['status'] = $status;
        $event_inv->save();

        Yii::$app->session->setFlash('success','Your are accepted this event!');
        return $this->redirect(['event-list']);
    }

    public function actionCalendar()
    {
      

        return $this->render('calendar');
    }

   
}