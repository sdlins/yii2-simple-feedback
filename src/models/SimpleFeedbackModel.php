<?php
/**
 * @link https://github.com/slinstj/yii2-simple-feedback
 * @license https://github.com/slinstj/yii2-simple-feedback/LICENSE
 */

namespace slinstj\widgets\SimpleFeedback\models;

use yii\db\ActiveRecord;
use yii\base\Exception;
use slinstj\widgets\SimpleFeedback\SimpleFeedbackWidget;
use yii\behaviors\TimestampBehavior;

/**
 * @author Sidney Lins <slinstj@gmail.com>
 */
class SimpleFeedbackModel extends ActiveRecord
{
    /**
     * @var string The name of the db config that should be used by this model.
     */
    public $dbConfigName = 'db';
    /**
     * @var string The name of the table that should be used by this model.
     */
    public $dbTable = 'simple_feedback';

    /**
     * @var string The name of the table field where user rating should be saved.
     */
    public $ratingField = 'rating';
    /**
     * @var string The name of the table field where user comment should be saved.
     */
    public $commentField = 'comment';
    /**
     * @var string The name of the table field where target information should be
     * saved. Defaults to absolute url where the rating was done.
     */
    public $targetField = 'target';
    /**
     * @var string The name of the table field where the date of the rating should
     * be saved. It will be automatically filled with the current date.
     */
    public $ratedAtField = 'rated_at';
    /**
     * @var string The name of the table field where the user id should be saved.
     * It will be automatically filled with the current user id (`\Yii::$app->user->id`)
     */
    public $ratedByField = 'rated_by';

    /**
     * @var string The label that should be used for the rating attribute.
     */
    public $ratingLabel = 'Rating';
    /**
     * @var string The label that should be used for the comment attribute.
     */
    public $commentLabel = 'Comment';

    /**
     * You will use target value mainly to identify what is being rated in your system.
     * For example, you can set this value to something like 'Land page' or
     * 'My System Beta' so that later you can use those names to filter their ratings
     * in your table.
     * You also can use a callback function to generate the value you want. That function
     * will receive this model as parameter.
     *
     * @var string|callable A value or a callable function.
     */
    public $targetValue;
    /**
     * @var array The model rules that should be used with this model. Defaults to:
     * [
     *      [[$this->ratingField], 'in', 'range' => [1, 2, 3, 4, 5]],
     *      [[$this->commentField, $this->targetField], 'string', 'max' => 1024],
     * ]
     */
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