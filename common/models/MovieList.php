<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "movie_list".
 *
 * @property int $id
 * @property string $movie_name
 * @property int $release_date
 * @property int $close_date
 */
class MovieList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['movie_name', 'release_date', 'close_date'], 'required'],
            [['movie_name'], 'string'],
            [['release_date', 'close_date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_name' => 'Movie Name',
            'release_date' => 'Release Date',
            'close_date' => 'Close Date',
        ];
    }
}
