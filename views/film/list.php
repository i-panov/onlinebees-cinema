<?php
/** @var \yii\web\View $this */
/** @var \app\models\Film[] $models */

use \yii\widgets\ListView;
use \yii\data\ArrayDataProvider;
use \yii\helpers\Html;

$this->title = "Фильмы";
$this->params['breadcrumbs'] = [$this->title];

if (Yii::$app->user->can('manageFilms'))
    echo Html::a('<i class="fa fa-plus"></i> Добавить', ['film/save'], ['class' => 'btn btn-success']);

echo ListView::widget([
    'dataProvider' => new ArrayDataProvider(['allModels' => $models]),
    'itemView' => '_list_item',
    'layout' => '{items}',
    'emptyText' => 'Фильмов нет',
]);
