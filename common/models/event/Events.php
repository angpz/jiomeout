<?php

namespace common\models\event;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property int $type
 * @property int $organizer_id
 * @property string $title
 * @property int $status refer status_type
 * @property int $created_time unix time
 * @property int $end_time unix time
 * @property int $poll 0 = false, 1 = true
 * @property int $poll_close_time
 *
 * @property EventType $type0
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'organizer_id', 'title', 'status', 'created_time', 'end_time', 'poll_close_time'], 'required'],
            [['type', 'organizer_id', 'status', 'created_time', 'end_time', 'poll', 'poll_close_time'], 'integer'],
            [['title'], 'string'],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'organizer_id' => 'Organizer ID',
            'title' => 'Title',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'end_time' => 'End Time',
            'poll' => 'Poll',
            'poll_close_time' => 'Poll Close Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(EventType::className(), ['id' => 'type']);
    }
}
