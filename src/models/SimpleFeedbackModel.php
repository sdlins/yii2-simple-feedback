<?php

namespace slinstj\widgets\SimpleFeedback\models;

use yii\db\ActiveRecord;
use yii\base\Exception;
use slinstj\widgets\SimpleFeedback\SimpleFeedbackWidget;
use yii\behaviors\TimestampBehavior;

class SimpleFeedbackModel extends ActiveRecord
{
    public $dbConfigName = 'db';
    public $dbTable = 'simple_feedback';

    public $ratingField = 'rating';
    public $commentField = 'comment';
    public $targetField = 'target';
    public $ratedAtField = 'rated_at';
    public $ratedByField = 'rated_by';

    public $ratingLabel = 'Rating';
    public $commentLabel = 'Comment';

    public $targetValue;
    public $rules = [];

    public function init()
    {
        \Yii::$app->params['sfDbConfigName'] = $this->dbConfigName;
        \Yii::$app->params['sfDbTable'] = $this->dbTable;

        $data['model'] = $this;
        $data['callback'] = $this->targetValue;

        $this->on(static::EVENT_BEFORE_INSERT, function($event) {
            $model = $event->data['model'];
            $callback = $event->data['callback'];
            If ($model->targetValue === null) {
                $model->{$model->targetField} = \Yii::$app->request->getAbsoluteUrl();
            } elseif (is_callable($model->targetValue)) {
                $model->{$model->targetField} = call_user_func($model->targetValue, $model);
            }
        }, $data);
    }

    public static function getDb()
    {
        return \Yii::$app->get(\Yii::$app->params['sfDbConfigName']);
    }

    public static function tableName()
    {
        return \Yii::$app->params['sfDbTable'];
    }

    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => $this->ratedAtField,
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return !empty($this->rules) ? $this->rules : [
            [[$this->ratingField], 'in', 'range' => [1, 2, 3, 4, 5]],
            [[$this->commentField, $this->targetField], 'string', 'max' => 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            $this->ratingField => \Yii::t('app', $this->ratingLabel),
            $this->commentField => \Yii::t('app', $this->commentLabel),
        ];
    }
}