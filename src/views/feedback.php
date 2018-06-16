<?php

use yii\widgets\ActiveForm;
use slinstj\widgets\SimpleFeedback;

?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, $this->context->dbGradeField)->dropDownList([
        1 => \Yii::t('sfi18n', 'The worst!'),
        2 => \Yii::t('sfi18n', 'Bad'),
        3 => \Yii::t('sfi18n', 'Regular'),
        4 => \Yii::t('sfi18n', 'Good'),
        5 => \Yii::t('sfi18n', 'Excellent!'),
    ]) ?>
    <?= $form->field($model, $this->context->dbCommentField)->textarea() ?>
    <?= $form->field($model, $this->context->dbTargetField)->hiddenInput()->label(false) ?>
<?php ActiveForm::end() ?>
