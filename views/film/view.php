<?php
/** @var \yii\web\View $this */
/** @var \app\models\Film $model */

use \yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'] = [['label' => 'Фильмы', 'url' => ['film/list']], $this->title];
?>

<div class="media">
    <div class="media-left">
        <?= Html::img($model->photo_path, ['class' => 'media-object', 'style' => 'width: 300px']) ?>
    </div>

    <div class="media-body">
        <h3 class="media-heading"><?= $model->name . " ($model->minAge+, $model->duration мин)" ?></h3>
        <p><?= $model->description ?></p>
    </div>

    <? if (Yii::$app->user->can('manageFilms')): ?>
    <div class="media-bottom pull-right" style="margin-top: 20px">
        <?= Html::a('<i class="fa fa-edit"></i> Редактировать', ['film/save', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> Удалить', ['film/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены что хотите удалить этот фильм?']) ?>
    </div>
    <? endif; ?>
</div>
