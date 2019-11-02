<?php
namespace app\forms;

use app\models\User;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            User::EMAIL_MUST_EXIST_RULE,
            ['rememberMe', 'boolean'],
            ['rememberMe', 'default', 'value' => false],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     * @throws \yii\web\NotFoundHttpException
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors() and !$this->getUser()->validatePassword($this->password))
            $this->addError($attribute, 'Неверный пароль');
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     * @throws \yii\web\NotFoundHttpException
     */
    public function login()
    {
        if ($this->hasErrors())
            return false;

        $user = $this->getUser();

        if (!$user->validatePassword($this->password))
            return false;

        return $user->login($this->rememberMe);
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getUser()
    {
        if ($this->_user === null)
            $this->_user = User::findOne(['email' => $this->email, 'status' => User::STATUS_ACTIVE]);

        return $this->_user;
    }
}
