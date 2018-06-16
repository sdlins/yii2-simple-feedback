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
    protected static $widgetInstance;

    public function __construct(SimpleFeedbackWidget $widgetInstance, $config = [])
    {
        static::$widgetInstance = $widgetInstance;
        parent::__construct($config);
    }

    public function init()
    {
        if (! static::$widgetInstance) {
            throw new Exception(\Yii::t('sfi18n', 'Error: the widget instance must be passed via constructor to SimpleFeedback Model.'));
        }
    }

    public static function getDb()
    {
        return \Yii::$app->get(static::$widgetInstance->dbConfigName);
    }

    public static function tableName()
    {
        return static::$widgetInstance->dbTable;
    }

    public function rules()
    {
        $widget = static::$widgetInstance;
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
}