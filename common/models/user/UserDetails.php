<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property int $uid
 * @property string $first_name
 * @property string $last_name
 * @property string $profile_pic
 * @property string $contact_no
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['profile_pic', 'contact_no'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'profile_pic' => 'Profile Pic',
            'contact_no' => 'Contact No',
        ];
    }
}
