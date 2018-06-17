<?php

namespace slinstj\widgets\SimpleFeedback;

use yii\base\Widget;
use slinstj\widgets\SimpleFeedback\models\SimpleFeedbackModel;
use yii\i18n\PhpMessageSource;

class SimpleFeedbackWidget extends Widget
{
    const SF_PLACEHOLDER = 'simplefeedback';

    public $formAction = ['site/rating'];
    public $isRatingAvailable = true;
    public $isCommentAvailable = true;
    public $modelConfigs;

    public function init()
    {
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        if (preg_match('/\{' . static::SF_PLACEHOLDER . '\}/', $content) !== 1) {
            $content .= '{' . static::SF_PLACEHOLDER . '}';
        }

        $model = new SimpleFeedbackModel($this->modelConfigs);
        $form = $this->render('feedback', ['model' => $model]);
        return strtr($content, ['{' . static::SF_PLACEHOLDER . '}' => $form]);
    }
}