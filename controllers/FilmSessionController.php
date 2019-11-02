<?php

namespace app\controllers;

use app\models\FilmSession;
use yii\web\NotFoundHttpException;

class FilmSessionController extends \yii\web\Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['save', 'delete'],
                        'allow' => true,
                        'roles' => ['manageFilmSessions']
                    ],
                ],
            ],
        ];
    }

    public function actionSave($id = null) {
        $model = $id ? $this->findOneOrFail($id) : new FilmSession(['time' => time()]);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->save(false);
            \Yii::$app->session->setFlash('success', 'Сохранено');
            return $this->redirect(['site/index']);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id) {
        $model = $this->findOneOrFail($id);
        $model->delete();
        \Yii::$app->session->setFlash('success', 'Удалено');
        return $this->redirect(['site/index']);
    }

    private function findOneOrFail($id) {
        $model = FilmSession::findOne($id);

        if (!$model)
            throw new NotFoundHttpException("Сеанс № $id не найден");

        return $model;
    }
}
