<?php
/**
 * @link https://github.com/slinstj/yii2-simple-feedback
 * @license https://github.com/slinstj/yii2-simple-feedback/LICENSE
 */

namespace slinstj\widgets\SimpleFeedback;

use yii\base\Widget;
use slinstj\widgets\SimpleFeedback\models\SimpleFeedbackModel;
use yii\i18n\PhpMessageSource;

/**
 * @author Sidney Lins <slinstj@gmail.com>
 */
class SimpleFeedbackWidget extends Widget
{
    const SF_PLACEHOLDER = 'simplefeedback';

    /**
     * @var array A valid route where the form data will be posted to. Defaults to
     * ['site/rating'].
     */
    public $formAction = ['site/rating'];
    /**
     * @var bool Defines whether the rating field should be available in the widget.
     */
    public $isRatingAvailable = true;
    /**
     * @var bool Defines whether the comment field should be available in the widget.
     */
    public $isCommentAvailable = true;
    /**
     * @var array Configs that will be used to initialize the model. Please, refer
     * to SimpleFeedbackModel docblocks to see configs available.
     */
    public $modelConfigs;

    public function init()
    {
        parent::init();
        static::registerTranslations();
        ob_start();
    }

    public static function registerTranslations()
    {
        \Yii::$app->i18n->translations['sfi18n*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/i18n',
            'sourceLanguage' => 'en-US',
        ];
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