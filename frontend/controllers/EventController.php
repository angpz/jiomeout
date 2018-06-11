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
            $event=$model->eventform();

            if($event==true){
                Yii::$app->getSession()->setFlash('success','Created success');
                return $this->redirect(['/site/index']);
            };

            

        }  
        return $this->render('eventform', [
                'model' => $model,
            ]);
    }
}