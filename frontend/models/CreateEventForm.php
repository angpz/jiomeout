<?php
namespace frontend\models;

use yii\base\Model;
use common\models\event\Events;
use common\models\event\EventDetails;

/**
 * Signup form
 */
class CreateEventForm extends Model
{
    public $title;
    public $endtime;
    public $poll;
    public $poll_close_time;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['type', 'string', 'min' => 2, 'max' => 255],
            
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

        $events->title=$this->title;
            
        $events->poll=$this->poll;
        $events->poll_close_time=$this->poll_close_time;
        
        return $events;
    }
}
