<?php

namespace slinstj\widgets\SimpleFeedback\models;

use yii\db\ActiveRecord;
use yii\base\Exception;
use slinstj\widgets\SimpleFeedback\SimpleFeedbackWidget;

class SimpleFeedbackModel extends ActiveRecord
{
    public $dbConfigName = 'db';
    public $dbTable = 'simple_feedback';
    public $gradeField = 'grade';
    public $gradeLabel = 'Grade';
    public $commentField = 'comment';
    public $commentLabel = 'Comment';
    public $targetField = 'target';
    public $rules = [];

    public function init()
    {
        \Yii::$app->params['sfDbConfigName'] = $this->dbConfigName;
        \Yii::$app->params['sfDbTable'] = $this->dbTable;
    }

    public static function getDb()
    {
        return \Yii::$app->get(\Yii::$app->params['sfDbConfigName']);
    }

    public static function tableName()
    {
        return \Yii::$app->params['sfDbTable'];
    }

    public function rules()
    {
        return !empty($this->rules) ? $this->rules : [
            [[$this->gradeField], 'in', 'range' => [1, 2, 3, 4, 5]],
            [[$this->commentField, $this->targetField], 'string', 'max' => 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            $this->gradeField => \Yii::t('app', $this->gradeLabel),
            $this->commentField => \Yii::t('app', $this->commentLabel),
        ];
    }
}