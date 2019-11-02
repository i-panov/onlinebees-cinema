<?php
/** @var \yii\web\View $this */
/** @var \app\models\Film $model */

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

if ($model->photo_path) {
    echo Html::img($model->photo_path, ['style' => 'border: 1px solid lightgrey; width: 400px; height: 400px']);
    echo Html::a('Удалить', ['film/delete-photo', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'style' => 'margin-top: 25px', 'data-confirm' => 'Вы уверены что хотите удалить фото?']);
} else {
    echo '<b class="text-warning">Фото отсутствует</b>';
    $form = ActiveForm::begin(['action' => ['film/upload-photo', 'id' => $model->id], 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]);
    echo Html::fileInput('photo', null, ['class' => 'form-control', 'style' => 'margin-top: 15px', 'required' => true, 'accept' => 'image/*']);
    echo Html::submitInput('Загрузить', ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-top: 15px']);
    ActiveForm::end();
}
