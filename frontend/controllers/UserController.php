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
                        'actions' => ['friends','find-friends','pending-friends','add-friend','ignore-friend','accept-friend','delete-friend'],
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

    public function actionPendingFriends()
    {
    	$request = UserFriendRequests::find()->where('request_uid = :ru',[':ru'=>Yii::$app->user->identity->id])->joinWith('requester','receiver')->all();

    	return $this->render('pending-friends',['request'=>$request]);
    }

    public function actionAddFriend($id)
    {
    	$user = User::findOne($id);

    	if (!empty($user)) {
    		$request = new UserFriendRequests();
    		$request['requester_uid'] = Yii::$app->user->identity->id;
    		$request['request_uid'] = $user['id'];
    		if ($request->validate()) {
    			$request->save();
    			Yii::$app->session->setFlash('success','Sent friend request!');
    		}
    		else{
    			Yii::$app->session->setFlash('warning','Failed!');
    		}
    		return $this->redirect(Yii::$app->request->referrer);
    	}
    }

    //in ignore friend action, $id = requester id
    public function actionIgnoreFriend($id)
    {
    	//find requester_uid = $id, request_uid = self_id
    	$request = UserFriendRequests::find()->andWhere(['=','requester_uid',$id])->andWhere(['=','request_uid',Yii::$app->user->identity->id])->one();

    	if (!empty($request)) {
    		$request->delete();
    		Yii::$app->session->setFlash('warning','Deleted!');
    	}
    	return $this->redirect(['/user/friends']);
    }

    public function actionAcceptFriend($id)
    {
    	$request = UserFriendRequests::find()->andWhere(['=','requester_uid',$id])->andWhere(['=','request_uid',Yii::$app->user->identity->id])->one();

    	$relation = new UserRelations();
    	$relation['primary_uid'] = Yii::$app->user->identity->id;
    	$relation['foreign_uid'] = $id;

    	$relation2 = new UserRelations();
    	$relation2['foreign_uid'] = Yii::$app->user->identity->id;
    	$relation2['primary_uid'] = $id;

    	if ($relation->validate() && $relation2->validate()) {
    		$relation->save();
    		$relation2->save();
    		$request->delete();
    		Yii::$app->session->setFlash('success','Success!');
    	}
    	return $this->redirect(['/user/friends']);
    }

    public function actionDeleteFriend($id)
    {
    	$relation = UserRelations::find()->andWhere(['=','primary_uid',Yii::$app->user->identity->id])->andWhere(['=','foreign_uid',$id])->one();
    	$relation2 = UserRelations::find()->andWhere(['=','primary_uid',$id])->andWhere(['=','foreign_uid',Yii::$app->user->identity->id])->one();

    	if (!empty($relation) || !empty($relation2)) {
    		$relation->delete();
    		$relation2->delete();
    		Yii::$app->session->setFlash('warning','Deleted!');
    	}
    	return $this->redirect(['/user/friends']);
    }

    //the passed $id is others' uid
    public static function checkFriendValid($id)
    {
    	$data = array();
    	$request = UserFriendRequests::find()->andWhere(['=','requester_uid',Yii::$app->user->identity->id])->andWhere(['=','request_uid',$id])->one();
    	$relation = UserRelations::find()->andWhere(['=','primary_uid',Yii::$app->user->identity->id])->andWhere(['=','foreign_uid',$id])->one();

    	if (!empty($request)) {
    		$data['valid'] = true;
    		$data['message'] ='Friend Request Sent';
    	}
    	elseif (!empty($relation)) {
    		$data['valid'] = true;
    		$data['message'] ='We are Friend!';
    	}
    	else{
    		$data['valid'] = false;
    		$data['message'] ='';
    	}

    	return $data;
    }
}
