<?php

use yii\widgets\ActiveForm;
use slinstj\widgets\SimpleFeedback;

$css = <<< CSS
    ul.sf {
        padding: 0;
        margin-top: 0;
    }
    ul.sf li{
        display: inline;
        cursor: pointer;
    }
    .sf-star{
        color: #aaa
    }
CSS;

$this->registerCss($css);
?>
<script>
    function sfUpdateGrade(elem) {
        var grade = elem.dataset.grade;
        var inputGrade = document.getElementById('grade');
        var stars = Array.prototype.slice.call(document.getElementsByClassName('sf-star'));

        inputGrade.value = grade;
        stars.forEach(function(star) {
            star.style.color = '#aaa'
            if (star.dataset.grade <= grade) {
                star.style.color = '#333'
            }
        });
    }
</script>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, $this->context->dbGradeField, [
        'options' => [
            'class' => '',
        ],
        'errorOptions' => [
            'tag' => null,
        ],
    ])->hiddenInput([
        'id' => 'grade',
        'name' => 'SimpleFeedbackModel[grade]',
        'value' => 0,
    ]) ?>
    <ul class="sf">
        <li class="sf-star" onclick="sfUpdateGrade(this)" data-grade="1">
            <i class="glyphicon glyphicon-star"></i>
        </li>
        <li class="sf-star" onclick="sfUpdateGrade(this)" data-grade="2">
            <i class="glyphicon glyphicon-star"></i>
        </li>
        <li class="sf-star" onclick="sfUpdateGrade(this)" data-grade="3">
            <i class="glyphicon glyphicon-star"></i>
        </li>
        <li class="sf-star" onclick="sfUpdateGrade(this)" data-grade="4">
            <i class="glyphicon glyphicon-star"></i>
        </li>
        <li class="sf-star" onclick="sfUpdateGrade(this)" data-grade="5">
            <i class="glyphicon glyphicon-star"></i>
        </li>
    </ul>
    <?= $form->field($model, $this->context->dbCommentField)->textarea() ?>
    <?= $form->field($model, $this->context->dbTargetField)->hiddenInput()->label(false) ?>
<?php ActiveForm::end() ?>
