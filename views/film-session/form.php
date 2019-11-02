<?php
/** @var \yii\web\View $this */
/** @var \app\models\FilmSession $model */

use yii\widgets\ActiveForm;
use \app\models\Film;
use \yii\helpers\Html;
use \kartik\datetime\DateTimePicker;

$this->title = $model->isNewRecord ? 'Добавление сеанса' : 'Редактирование сеанса';
$this->params['breadcrumbs'] = [$this->title];

$form = ActiveForm::begin();

echo $form->field($model, 'film_id')->dropDownList(
    Film::find()->select('name')->indexBy('id')->column(),
    ['prompt' => '']
);

echo $form->field($model, 'time')->widget(DateTimePicker::class, [
    'options' => ['value' => Yii::$app->formatter->asDatetime($model->time)],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy, hh:ii',
        'startDate' => Yii::$app->formatter->asDatetime(time()),
    ],
]);

echo $form->field($model, 'price')->input('number');

if (!$model->isNewRecord)
    echo Html::a('<i class="fa fa-trash"></i> Удалить', ['film-session/delete', 'id' => $model->id], [
        'class' => 'btn btn-danger pull-right',
        'style' => 'margin-left: 10px',
        'data-confirm' => 'Вы уверены что хотите удалить этот сеанс?'
    ]);

echo '<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Сохранить</button>';

ActiveForm::end();
