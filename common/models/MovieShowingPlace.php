<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_showing_place".
 *
 * @property int $movie_id
 * @property int $cinema_id
 * @property string $redirect_link give link to movie showing time
 */
class MovieShowingPlace extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie_showing_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['movie_id', 'cinema_id'], 'required'],
            [['movie_id', 'cinema_id'], 'integer'],
            [['redirect_link'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'movie_id' => 'Movie ID',
            'cinema_id' => 'Cinema ID',
            'redirect_link' => 'Redirect Link',
        ];
    }
}
