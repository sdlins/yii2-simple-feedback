<?php

namespace slinstj\widgets\models;

use yii\db\ActiveRecord;
use yii\base\Exception;
use slinstj\widgets\SimpleFeedback as SimpleFeedbackWidget;

class SimpleFeedback extends ActiveRecord
{
    /**
     * @var SimpleFeedbackWidget
     */
    protected $widgetInstance;

    public function init()
    {
        if (!$this->widgetInstance) {
            throw new Exception(\Yii::t('sfi18n', 'Error'));
        }
    }
    public function rules()
    {
        $widget = $this->widgetInstance;
        $rules = $widget->feedbackModelRules;

        return !empty($rules) ? $rules : [
            [[$widget->dbGradeField], 'in', 'range' => [1, 2, 3, 4, 5]],
            [[$widget->dbCommentField], 'string', 'max' => 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'grade' => \Yii::t('sfi18n', 'Grade'),
            'comment' => \Yii::t('sfi18n', 'Comment'),
        ];
    }

    public function setWidgetInstance(SimpleFeedbackWidget $widget)
    {
        $this->widgetInstance = $widget;
    }
}