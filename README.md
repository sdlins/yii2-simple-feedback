# Yii2 Simple Feedback

Rating and comment feedback system that works out of the box for Yii2.

![Yii2 Simple Feedback Basic Demo](simple-feedback-basic-demo-xs.png)

## Installation
```php
composer require slinstj/yii2-simple-feedback
```

## The most simple way to use

*This way will use default configs*.

1 - Put the Simple Feedback Widget in your view:
```php
// in myview.php
use \slinstj\widgets\SimpleFeedback\SimpleFeedbackWidget;
?>
// put it wherever you preffer in your view:
<?= SimpleFeedbackWidget::widget() ?>
```

2 - Config the action to save the feedback data:
```php
// in SiteController
...
public function actions()
    {
        return [
            'rating' => [
                'class' => 'slinstj\widgets\SimpleFeedback\actions\RatingAction',
            ],
```

3 - Run migration to create the table where ratings will be saved:
```bash
# in your root directory, run:
php yii migrate --migrationPath=@vendor/slinstj/yii2-simple-feedback/src/migrations
```
And it is done!
