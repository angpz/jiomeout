<?php

namespace common\models\user;

use Yii;
use common\models\user\User;
/**
 * This is the model class for table "user_friend_requests".
 *
 * @property int $primary_uid
 * @property int $request_uid
 */
class UserFriendRequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_friend_requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requester_uid', 'request_uid'], 'required'],
            [['requester_uid', 'request_uid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'requester_uid' => 'Requester Uid',
            'request_uid' => 'Request Uid',
        ];
    }

    public function getRequester()
    {
        return $this->hasOne(User::className(),['id' =>'requester_uid']);
    }

    public function getReceiver()
    {
        return $this->hasOne(User::className(),['id' =>'request_uid']);
    }
}
