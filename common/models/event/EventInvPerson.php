<?php

namespace common\models\event;

use Yii;

/**
 * This is the model class for table "event_inv_person".
 *
 * @property int $event_id
 * @property int $uid user_id
 * @property int $status
 * @property int $event_detail_id chosen poll
 */
class EventInvPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_inv_person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'uid', 'status'], 'required'],
            [['event_id', 'uid', 'status', 'event_detail_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'uid' => 'Uid',
            'status' => 'Status',
            'event_detail_id' => 'Event Detail ID',
        ];
    }
}
