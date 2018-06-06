<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cinema_list".
 *
 * @property int $id
 * @property string $cinema_name
 * @property string $location
 * @property string $hyperlink
 */
class CinemaList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cinema_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cinema_name', 'location', 'hyperlink'], 'required'],
            [['cinema_name', 'location', 'hyperlink'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cinema_name' => 'Cinema Name',
            'location' => 'Location',
            'hyperlink' => 'Hyperlink',
        ];
    }
}
