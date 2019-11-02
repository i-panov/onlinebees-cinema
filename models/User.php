<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;
    const SIGNUP_CONFIRMATION_TOKEN_EXPIRE = 3600 * 24;

    const EMAIL_MUST_EXIST_RULE = [
        'email', 'exist',
        'targetClass' => User::class,
        'filter' => ['status' => User::STATUS_ACTIVE],
        'message' => 'Пользователь с такой электронной почтой не зарегистрирован'
    ];

    public static function tableName() {
        return '{{%users}}';
    }

    public function behaviors() {
        return [
            'timestamp' => TimestampBehavior::class,
        ];
    }

    public function rules() {
        return [
            ['email', 'required'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['email', 'email'],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isAttributeChanged('email'))
            $this->email = strtolower($this->email);

        return parent::beforeSave($insert);
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByToken($token, $expire, $message = null) {
        if (!static::isTokenValid($token, $expire))
            throw new BadRequestHttpException($message);

        return static::findOne(['token' => $token], $message);
    }

    public static function hash($value) {
        return Yii::$app->security->generatePasswordHash($value);
    }

    public static function randomString() {
        return Yii::$app->security->generateRandomString();
    }

    public static function isTokenValid($token, int $expire): bool {
        if (!$token)
            return false;

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        return $timestamp + $expire >= time();
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword(string $password) {
        $this->password_hash = static::hash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = static::randomString();
    }

    public function generateToken() {
        $this->token = static::randomString() . '_' . time();
    }

    public function removeToken() {
        $this->token = null;
    }

    public function assignRole($role) {
        $role = Yii::$app->authManager->getRole($role);
        Yii::$app->authManager->revokeAll($this->id);
        Yii::$app->authManager->assign($role, $this->id);
    }

    public function login($rememberMe = false) {
        return Yii::$app->user->login($this, $rememberMe ? 3600 * 24 * 30 : 0);
    }
}
