<?php
/**
 * @link https://github.com/slinstj/yii2-simple-feedback
 * @license https://github.com/slinstj/yii2-simple-feedback/LICENSE
 */

namespace slinstj\widgets\SimpleFeedback\actions;

use yii\base\Action;
use slinstj\widgets\SimpleFeedback\models\SimpleFeedbackModel;

/**
 * @author Sidney Lins <slinstj@gmail.com>
 */
class RatingAction extends Action
{
    public $modelConfigs = [];

    public function run()
    {
        $model = new SimpleFeedbackModel($this->modelConfigs);
        $model->{$model->ratedByField} = \Yii::$app->user->id;

        $returnUrl = $_POST['sfReferrer'] ?? \Yii::$app->request->referrer ?? \Yii::$app->homeUrl;
        $returnUrl .= (strpos($returnUrl, '?') === false ? '?' : '&');

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $returnUrl .= 'sfResponse=' . urlencode(\Yii::t('app', 'Thanks for your rating!'));
            $returnUrl .= '&sfResponseType=success';
        } else {
            $returnUrl .= 'sfResponse=' . urlencode(\Yii::t('app', 'Sorry! Your rating could not be saved at this moment.'));
            $returnUrl .= '&sfResponseType=danger';
        }
        return $this->controller->redirect($returnUrl);
    }
}