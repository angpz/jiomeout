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
        $event_details = new EventDetails();
        $event_details['event_id'] = $eid;

        return $this->render('event-fill-details', ['event'=>$event,'event_details' => $event_details]);
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