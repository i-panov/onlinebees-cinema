<?php
/** @var \yii\web\View $this */
/** @var \app\models\Film $model */

use \yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'name');
echo $form->field($model, 'description')->textarea(['rows' => 10]);
echo $form->field($model, 'duration')->input('number', ['min' => 1, 'max' => 60 * 24]);
echo $form->field($model, 'minAge')->input('number', ['min' => 0, 'max' => 200]);
echo '<input type="submit" class="btn btn-primary" value="Сохранить">';

ActiveForm::end();
