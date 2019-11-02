<?php

/** @var \yii\web\View $this */
/** @var FilmSession[] $models */

use app\models\FilmSession;
use yii\helpers\Html;
use \yii\widgets\ListView;
use \yii\data\ArrayDataProvider;

$this->title = Yii::$app->name;

if (Yii::$app->user->can('manageFilms') || true)
    echo Html::a('Фильмы', ['film/list'], ['class' => 'btn btn-default']);

$canManageFilmSessions = Yii::$app->user->can('manageFilmSessions');

echo '<h1 class="page-header">Список сеансов</h1>';

if ($canManageFilmSessions)
    echo Html::a('<i class="fa fa-plus"></i> Добавить', ['film-session/save'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 20px']);

echo ListView::widget([
    'dataProvider' => new ArrayDataProvider(['allModels' => $models]),
    'layout' => '{items}',
    'emptyText' => 'Сеансов нет',
    'itemView' => function(FilmSession $item) use($canManageFilmSessions) {
        $view = Html::a($item->film->name, ['film/view', 'id' => $item->film_id]) . ' ' . Yii::$app->formatter->asDatetime($item->time) . " за $item->price рублей";

        if ($canManageFilmSessions) {
            $updateButton = Html::a('<i class="fa fa-edit" title="Редактировать"></i>', ['film-session/save', 'id' => $item->id]);
            $view .= "<div class='pull-right'><span style='margin-right: 10px'>$updateButton</span></div>";
        }

        return "<div style='margin-bottom: 10px; padding: 5px; border: 1px solid black'>$view</div>";
    },
]);
