<?php
/** @var \app\models\Film $model */

use \yii\helpers\Html;
?>

<style>
    .film-item {
        border: 1px solid lightgrey;
    }

    .film-item > * {
        padding: 10px;
    }
</style>

<div class="media film-item">
    <div class="media-left">
        <?= Html::img($model->photo_path, ['class' => 'media-object', 'style' => 'width: 60px']) ?>
    </div>

    <div class="media-body">
        <h4 class="media-heading"><?= Html::a($model->name . " ($model->minAge+, $model->duration мин)", ['film/view', 'id' => $model->id]) ?></h4>
        <p><?= $model->description ?></p>
    </div>
</div>
