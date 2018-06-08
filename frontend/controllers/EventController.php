<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\CreateEventForm;

class EventController extends Controller
{
    
    public function actionEventform()
    {
        if (Yii::$app->user->isGuest) {      
            Yii::$app->session->setflash('warning','Please log in first');
            return $this->redirect(['/site/login']);
        }
       

        $model = new CreateEventForm();
           
        if($model->load(Yii::$app->request->post())){
            $model->endtime=strtotime($model->endtime);
            $model->poll_close_time=strtotime($model->poll_close_time);
            var_dump($model);exit;
            if ($events = $model->eventform()) {
                
                Yii::$app->getSession()->setFlash('success','Verification email sent! Kindly check email and validate your account.');
            
                return $this->redirect(['/site/validation']);
            }
        }  
    
        return $this->render('eventform', ['model' => $model]);
    }
}