<?php

namespace app\widgets;

use yii\bootstrap\InputWidget;
use yii\helpers\Html;

class Duration extends InputWidget {
    private $_prefix;

    public function init() {
        parent::init();
        $this->_prefix = uniqid('u');
        $this->options = ['value' => 0, 'id' => $this->_prefix . '_duration'];
    }

    public function run() {
        $this->registerCss();
        $this->registerJs();

        echo Html::beginTag('fieldset', ['class' => 'form-group row scheduler-border']);
        echo Html::tag('legend', 'Продолжительность', ['class' => 'scheduler-border']);
        echo $this->renderInputHtml('hidden');
        $this->renderExtraInput('hours', 'Часы');
        $this->renderExtraInput('minutes', 'Минуты', 59);
        $this->renderExtraInput('seconds', 'Секунды', 59);
        echo Html::endTag('fieldset');
    }

    private function registerCss() {
        $this->view->registerCss(<<<CSS
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width:auto;
    padding:0 10px;
    border-bottom:none;
}
CSS
        );
    }

    private function registerJs() {
        $this->view->registerJs(<<<JS
(() => {
    const prefix = "$this->_prefix";
	const durationInput = document.getElementById(prefix + '_duration');
	const hoursInput = document.getElementById(prefix + '_durationHours');
	const minutesInput = document.getElementById(prefix + '_durationMinutes');
	const secondsInput = document.getElementById(prefix + '_durationSeconds');
	
	function updateDuration() {
		const hoursMs = +hoursInput.value * 60 * 60 * 1000;
		const minutesMs = +minutesInput.value * 60 * 1000;
		const secondsMs = +secondsInput.value * 1000;
		durationInput.value = hoursMs + minutesMs + secondsMs;
	}
	
	hoursInput.addEventListener('change', updateDuration);
	minutesInput.addEventListener('change', updateDuration);
	secondsInput.addEventListener('change', updateDuration);
})();
JS
        );
    }

    private function renderExtraInput($name, $label, $max = null, $colSize = 4) {
        $options = [
            'id' => $this->_prefix . '_duration' . ucfirst($name),
            'min' => 0,
            'value' => 0,
            'class' => 'form-control',
            'style' => 'width: 100px',
        ];

        if ($max > 0)
            $options['max'] = $max;

        echo Html::beginTag('div', ['class' => "col-md-$colSize"]);
        echo Html::label($label . Html::input('number', null, 0, $options));
        echo Html::endTag('div');
    }
}
