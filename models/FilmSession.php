<?php

namespace app\models;

/**
 * Сеанс фильма
 *
 * @property int $id
 * @property int $film_id
 * @property int $time
 * @property float $price
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Film $film
 */
class FilmSession extends \yii\db\ActiveRecord {
    public static function tableName() {
        return '{{%film_sessions}}';
    }

    public function rules() {
        return [
            [['film_id', 'time', 'price'], 'required'],
            ['time', 'datetime', 'timestampAttribute' => 'time'],
            ['price', 'integer', 'min' => 0]
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::class,
        ];
    }

    public function attributeLabels() {
        return [
            'film_id' => 'Фильм',
            'time' => 'Время начала',
            'price' => 'Стоимость',
            'created_at' => 'Добавлен',
            'updated_at' => 'Обновлен',
        ];
    }

    public function getFilm() {
        return $this->hasOne(Film::class, ['id' => 'film_id']);
    }
}
