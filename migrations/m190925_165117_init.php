<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m190925_165117_init
 */
class m190925_165117_init extends Migration
{
    public function safeUp() {
        Yii::$app->runAction('rbac/init');

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_DELETED),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('films', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'photo_path' => $this->string(),
            'duration' => $this->integer()->notNull(),
            'minAge' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('film_sessions', [
            'id' => $this->primaryKey(),
            'film_id' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(),
            'price' => $this->float()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'film_sessions-films',
            'film_sessions',
            'film_id',
            'films',
            'id',
            'CASCADE'
        );
    }

    public function safeDown() {
        echo "m190925_165117_init cannot be reverted.\n";

        return false;
    }
}
