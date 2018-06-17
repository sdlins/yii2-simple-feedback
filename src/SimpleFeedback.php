<?php

namespace slinstj\widgets;

use yii\base\Widget;
use slinstj\widgets\models\SimpleFeedbackModel;
use yii\i18n\PhpMessageSource;

class SimpleFeedback extends Widget
{
    const SF_PLACEHOLDER = 'simplefeedback';

    public $dbConfigName = 'db';
    public $dbTable = 'simple_feedback';
    public $dbGradeField = 'grade';
    public $dbCommentField = 'comment';
    public $dbTargetField = 'target';

    protected $feedbackModel;
    public $feedbackModelRules = [];
    public $formAction = ['site/rating'];
    public $isGradeAvailable = true;
    public $isCommentAvailable = true;

    public function init()
    {
        if (!isset(\Yii::$app->i18n->translations['sfi18n'])) {
            \Yii::$app->i18n->translations['sfi18n'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . DIRECTORY_SEPARATOR . 'i18n',
                'sourceLanguage' => 'en-US',
            ];
        }
        $this->feedbackModel = new SimpleFeedbackModel($this);
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        if (preg_match('/\{' . static::SF_PLACEHOLDER . '\}/', $content) !== 1) {
            $content .= '{' . static::SF_PLACEHOLDER . '}';
        }
        $form = $this->render('feedback', ['model' => $this->feedbackModel]);
        return strtr($content, ['{' . static::SF_PLACEHOLDER . '}' => $form]);
    }
}