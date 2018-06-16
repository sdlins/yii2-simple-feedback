<?php

namespace slinstj\widgets;

use yii\base\Widget;
use slinstj\widgets\models\SimpleFeedback as SimpleFeedbackModel;

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
        $this->feedbackModel = new SimpleFeedbackModel;
        $this->feedbackModel->setWidgetInstance($this);
    }

    public function run()
    {
        $this->renders('feedback', ['model' => $this->feedbackModel]);
    }
}