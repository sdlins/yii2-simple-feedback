<?php

namespace slinstj\widgets;

use yii\base\Widget;
use slinstj\widgets\models\SimpleFeedback as SimpleFeedbackModel;
use yii\i18n\PhpMessageSource;

class SimpleFeedback extends Widget
{
    public $dbConfigName = 'db';
    public $dbTable = 'simple_feedback';
    public $dbGradeField = 'grade';
    public $dbCommentField = 'comment';
    public $dbTargetField = 'target';

    protected $feedbackModel;
    public $feedbackModelRules = [];

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
        $this->feedbackModel = new SimpleFeedbackModel;
        $this->feedbackModel->setWidgetInstance($this);
    }

    public function run()
    {
        $this->renders('feedback', ['model' => $this->feedbackModel]);
    }
}