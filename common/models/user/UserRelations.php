<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_relations".
 *
 * @property int $primary_uid
 * @property int $foreign_uid
 */
class UserRelations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['primary_uid', 'foreign_uid'], 'required'],
            [['primary_uid', 'foreign_uid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'primary_uid' => 'Primary Uid',
            'foreign_uid' => 'Foreign Uid',
        ];
    }

    public function getPrimaryUser()
    {
        return $this->hasOne(User::className(),['id' =>'primary_uid']);
    }

    public function getForeignUser()
    {
        return $this->hasOne(User::className(),['id' =>'foreign_uid']);
    }
}
