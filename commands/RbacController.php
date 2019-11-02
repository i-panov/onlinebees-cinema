<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class RbacController extends Controller {
    public function actionInit() {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // роли

        $adminRole = $auth->createRole('admin');
        $adminRole->description = 'Администратор';
        $auth->add($adminRole);

        $cashierRole = $auth->createRole('cashier');
        $cashierRole->description = 'Кассир';
        $auth->add($cashierRole);

        // разрешения

        $manageFilmsPermission = $auth->createPermission('manageFilms');
        $manageFilmsPermission->description = 'Может управлять фильмами';
        $auth->add($manageFilmsPermission);

        $manageFilmSessionsPermission = $auth->createPermission('manageFilmSessions');
        $manageFilmSessionsPermission->description = 'Может управлять сеансами фильмамов';
        $auth->add($manageFilmSessionsPermission);

        // сопоставление ролей и разрешений

        $auth->addChild($cashierRole, $manageFilmSessionsPermission);
        $auth->addChild($adminRole, $manageFilmsPermission);
        $auth->addChild($adminRole, $cashierRole);

        // пользователи по умолчанию

        $adminUser = new User(['email' => 'admin@example.com', 'password' => 'admin']);
        $adminUser->save(false);
        $adminUser->assignRole('admin');

        $cashierUser = new User(['email' => 'cashier@example.com', 'password' => 'cashier']);
        $cashierUser->save(false);
        $cashierUser->assignRole('cashier');
    }

    public function actionUser($email, $password, $role) {
        $user = User::findOne(['email' => $email]) ?? new User(['email' => $email, 'status' => User::STATUS_ACTIVE]);
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save(false);
        $user->assignRole($role);
    }
}
