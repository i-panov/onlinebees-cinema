<?php
/** @var \yii\web\View $this */
/** @var \app\models\Film $model */

$this->title = $model->isNewRecord ? 'Добавление фильма' : 'Редактирование фильма';
$this->params['breadcrumbs'] = [['label' => 'Фильмы', 'url' => ['film/list']], $this->title];
?>

<div class="row">
    <div class="col-md-8">
        <?= $this->render('_data_form', ['model' => $model]) ?>
    </div>
    <div class="col-md-4">
        <?= $this->render('_photo_form', ['model' => $model]) ?>
    </div>
</div>
