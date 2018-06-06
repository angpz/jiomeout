<?php

namespace common\models\user;

use Yii;

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
            [['primary_uid', 'request_uid'], 'required'],
            [['primary_uid', 'request_uid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'primary_uid' => 'Primary Uid',
            'request_uid' => 'Request Uid',
        ];
    }
}
