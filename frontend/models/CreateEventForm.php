<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\event\Events;
use common\models\event\EventDetails;
use common\models\event\EventInvPerson;
use common\models\User;
/**
 * Signup form
 */
class CreateEventForm extends Model
{
    public $title;
    public $endtime;
    public $poll;
    public $poll_close_time;
    public $inv_friend;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','inv_friend'], 'required'],
            ['title', 'string', 'min' => 2, 'max' => 255],
            
            ['endtime', 'required'],

            ['poll','safe'],

            ['poll_close_time','safe']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function eventform()
    {
        $events =new Events();
        $events->type= 1;
        $events->title=$this->title;
        $events->poll=(int)$this->poll;
        $events->organizer_id = Yii::$app->user->identity->id;
        $events->status = 0;
        $events->created_time = strtotime(date('H:i:s'));     
     
        $events->poll_close_time=strtotime($this->poll_close_time);
        if($events->validate()){
           $events->save();
           foreach ($this->inv_friend as $k => $uid) {
               $inv_person = new EventInvPerson();
               $inv_person['event_id'] = $events['id'];
               $inv_person['uid'] = $uid;
               $inv_person['status'] = 1;
               $inv_person->save();
           }
           $data = $events;
        }else{
            $data = false;
        }
        return $data;
    }
}
