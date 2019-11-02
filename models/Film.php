<?php

namespace app\models;

/**
 * Фильм
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $photo_path
 * @property int $duration
 * @property int $minAge
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property FilmSession[] $sessions
 */
class Film extends \yii\db\ActiveRecord {
    public static function tableName() {
        return '{{%films}}';
    }

    public function rules() {
        return [
            [['name', 'duration', 'photo_path'], 'required'],
            [['name', 'description'], 'trim'],
            ['name', 'string', 'min' => 1, 'max' => 50],
            ['description', 'string', 'max' => 1000],
            ['duration', 'integer', 'min' => 1, 'max' => 60 * 24],
            ['minAge', 'integer', 'min' => 0, 'max' => 200],
            ['minAge', 'default', 'value' => 0],
            ['name', 'unique'],
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => \yii\behaviors\TimestampBehavior::class,
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'photo_path' => 'Фото',
            'duration' => 'Продолжительность (мин)',
            'minAge' => 'Возрастное ограничение',
            'created_at' => 'Добавлен',
            'updated_at' => 'Обновлен',
        ];
    }

    public function getSessions() {
        return $this->hasMany(FilmSession::class, ['film_id' => 'id']);
    }

    public function deletePhoto() {
        unlink(ltrim($this->photo_path, '/'));
        $this->photo_path = null;
    }
}
