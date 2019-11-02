<?php

namespace app\controllers;

use app\models\Film;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class FilmController extends \yii\web\Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['save', 'delete', 'upload-photo', 'delete-photo'],
                        'allow' => true,
                        'roles' => ['manageFilms']
                    ],
                    [
                        'actions' => ['list', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                ],
            ],
        ];
    }

    public function actionSave($id = null) {
        $model = $id ? $this->findOneOrFail($id) : new Film(['duration' => 1, 'minAge' => 0]);

        if ($model->load(\Yii::$app->request->post()) && $model->validate(['name', 'description', 'duration', 'minAge']) && $model->save(false))
            \Yii::$app->session->setFlash('success', 'Сохранено');

        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id) {
        $model = $this->findOneOrFail($id);
        $model->deletePhoto();
        $model->delete();
        \Yii::$app->session->setFlash('success', 'Удалено');
        return $this->redirect(['film/list']);
    }

    public function actionUploadPhoto($id) {
        $model = $this->findOneOrFail($id);
        $file = UploadedFile::getInstanceByName('photo');

        if (!$file)
            throw new BadRequestHttpException('Файл отсутствует');

        $baseDir = 'files/photos';
        FileHelper::createDirectory($baseDir);
        $model->photo_path = sprintf('%s/%s.%s', $baseDir, uniqid(), $file->extension);
        $file->saveAs($model->photo_path);
        $model->photo_path = '/' . $model->photo_path;
        $model->save(false);
        return $this->redirect(['film/save', 'id' => $model->id]);
    }

    public function actionDeletePhoto($id) {
        $model = $this->findOneOrFail($id);
        $model->deletePhoto();
        $model->save(false);
        return $this->redirect(['film/save', 'id' => $model->id]);
    }

    public function actionList() {
        return $this->render('list', ['models' => Film::find()->all()]);
    }

    public function actionView($id) {
        return $this->render('view', ['model' => $this->findOneOrFail($id)]);
    }

    private function findOneOrFail($id) {
        $model = Film::findOne($id);

        if (!$model)
            throw new NotFoundHttpException("Фильм № $id не найден");

        return $model;
    }
}
