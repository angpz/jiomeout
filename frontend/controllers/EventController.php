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
    public function actionEventform()
    {
        if (Yii::$app->user->isGuest) {      
            Yii::$app->session->setflash('warning','Please log in first');
            return $this->redirect(['/site/login']);
        }

        $model = new CreateEventForm();
        $eventdetail = new EventDetails();
        $userlist = Arrayhelper::map(UserRelations::find()->where('primary_uid = :pu',[':pu'=>Yii::$app->user->identity->id])->joinWith('foreignUser')->all(),'foreign_uid','foreignUser.username');

        if($model->load(Yii::$app->request->post())){
            $eventdetail->load(Yii::$app->request->post());
            $event = $model->eventform();

            if($event != false){

                $eventdetail['event_id'] = $event['id'];
                $eventdetail['event_time'] = strtotime($eventdetail['event_time']);
                $eventdetail['poll'] = $event['poll'];

                if ($eventdetail->validate()) {
                    $eventdetail->save();
                    Yii::$app->getSession()->setFlash('success','Created success');
                    return $this->redirect(['/site/index']);
                }
            };
        }

        return $this->render('eventform', ['model' => $model,'eventdetail'=>$eventdetail,'userlist'=>$userlist]);
    }

    public function actionEventList()
    {
        $events = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->joinWith('event','user')->all();
        $created_events = Events::find()->where('organizer_id = :oid',[':oid'=>Yii::$app->user->identity->id])->joinWith('eventSelection')->all();

        return $this->render('event-list',['events'=>$events,'created_events'=>$created_events]);
    }

    public function actionAcceptEvent($eid)
    {
        $event_inv = EventInvPerson::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id])->andWhere(['=','event_id',$eid])->one();
        $event_inv['status'] = 3;
        $event_inv->save();

        Yii::$app->session->setFlash('success','Your are accepted this event!');
        return $this->redirect(['event-list']);
    }
}