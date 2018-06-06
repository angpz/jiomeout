<?php

namespace frontend\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\user\{User,UserFriendRequests,UserRelations};

class UserController extends Controller
{
	public function behaviors()
    {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                    [
                        'actions' => ['find-friends','add-friend','friends'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                 ]
             ]
        ];
    }

    public function actionFriends()
    {
    	$friends = UserRelations::find()->where('primary_uid = :pu',[':pu'=>Yii::$app->user->identity->id])->joinWith('primaryUser','foreignUser')->all();
    	$request = UserFriendRequests::find()->where('request_uid = :ru',[':ru'=>Yii::$app->user->identity->id])->joinWith('requester','receiver')->all();
    	
    	return $this->render('friends',['friends'=>$friends,'request'=>$request]);
    }

    public function actionFindFriends()
    {
    	$user = new User();

    	if (Yii::$app->request->post()) {
    		if (!empty(Yii::$app->request->post('username'))) {
    			$result = User::find()->andWhere(['or',['like','username',Yii::$app->request->post('username')],['like','email',Yii::$app->request->post('username')]])->andwhere(['!=','id',Yii::$app->user->identity->id])->all();

	    		return $this->render('find-friends',['user'=>$user,'result'=>$result]);
    		}
    		
    	}
    	return $this->render('find-friends',['user'=>$user]);
    }

    public function actionAddFriend($id)
    {
    	$user = User::findOne($id);

    	if (!empty($user)) {
    		$request = new UserFriendRequests();
    		$request['primary_uid'] = Yii::$app->user->identity->id;
    		$request['request_uid'] = $user['id'];
    		if ($request->validate()) {
    			$request->save();
    			Yii::$app->session->setFlash('success','Sent friend request!');
    		}
    		else{
    			Yii::$app->session->setFlash('warning','Failed!');
    		}
    		return $this->redirect(['/user/find-friends']);
    	}
    }
}
