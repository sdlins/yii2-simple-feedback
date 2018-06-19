<?php

use yii\widgets\ActiveForm;
use slinstj\widgets\SimpleFeedback\SimpleFeedback;
use yii\helpers\Url;
use yii\helpers\Html;

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
        color: #aaa;
        text-shadow: 1px 2px 3px #222;
    }
    .sf-star-checked{
        color: #ff0;
    }
    .sf-star-unchecked{
        color: #aaa;
    }
CSS;
$this->registerCss($css);
?>
<script>
    function sfUpdateRating(elem) {
        var rating = elem.dataset.rating;
        var inputRating = document.getElementById('rating');
        var stars = Array.prototype.slice.call(document.getElementsByClassName('sf-star'));

        inputRating.value = rating;
        stars.forEach(function(star) {
            star.classList.remove('sf-star-checked')
            if (star.dataset.rating <= rating) {
                star.classList.add('sf-star-checked')
            }
        });
    }
</script>
<?php if (empty($_GET['sfResponse'])): ?>
    <?php $form = ActiveForm::begin(['action' => Url::to($this->context->formAction)]) ?>
        <?php if ($this->context->isRatingAvailable): ?>
            <input type="hidden" name="sfReferrer" value="<?= Url::to('') ?>">
            <?= $form->field($model, $model->ratingField, [
                'options' => [
                    'class' => '',
                ],
                'errorOptions' => [
                    'tag' => null,
                ],
            ])->hiddenInput([
                'id' => 'rating',
                'name' => 'SimpleFeedbackModel[rating]',
                'value' => 0,
            ]) ?>
            <ul class="sf">
                <li class="sf-star st-star-unchecked" onclick="sfUpdateRating(this)" data-rating="1">
                    <i class="glyphicon glyphicon-star"></i>
                </li>
                <li class="sf-star st-star-unchecked" onclick="sfUpdateRating(this)" data-rating="2">
                    <i class="glyphicon glyphicon-star"></i>
                </li>
                <li class="sf-star st-star-unchecked" onclick="sfUpdateRating(this)" data-rating="3">
                    <i class="glyphicon glyphicon-star"></i>
                </li>
                <li class="sf-star st-star-unchecked" onclick="sfUpdateRating(this)" data-rating="4">
                    <i class="glyphicon glyphicon-star"></i>
                </li>
                <li class="sf-star st-star-unchecked" onclick="sfUpdateRating(this)" data-rating="5">
                    <i class="glyphicon glyphicon-star"></i>
                </li>
            </ul>
        <?php endif ?>
        <?= $this->context->isCommentAvailable ? $form->field($model, $model->commentField)->textarea() : '' ?>
        <?= $form->field($model, $model->targetField)->hiddenInput()->label(false) ?>
        <?= Html::submitButton(\Yii::t('sfi18n', 'Submit')) ?>
    <?php ActiveForm::end() ?>
<?php else: ?>
    <div class="alert alert-<?= $_GET['sfResponseType'] ?? 'default' ?>">
        <?= $_GET['sfResponse'] ?>
    </div>
<?php endif ?>
