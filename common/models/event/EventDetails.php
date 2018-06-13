<?php

namespace common\models\event;

use Yii;

/**
 * This is the model class for table "event_details".
 *
 * @property int $id
 * @property int $event_id
 * @property string $event_name
 * @property string $event_location
 * @property int $event_time
 * @property int $poll 0 = false, 1 = true
 */
class EventDetails extends \yii\db\ActiveRecord
{
    public $poll_event_time;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'event_name', 'event_location', 'event_time'], 'required'],
            [['event_id', 'poll'], 'integer'],
            [['event_name', 'event_location'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'event_name' => 'Event Name',
            'event_location' => 'Event Location',
            'event_time' => 'Event Time',
            'event_end_time' => 'Buzy Time',
            'poll' => 'Poll',
        ];
    }
}
