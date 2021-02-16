<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $url app\models\Url */
/* @var $model app\models\forms\MinifierUrlForm */

$this->title = 'Главная';
?>

<?php if(isset($model) && !$model->hasErrors() && !empty($url->token)) :?>
    <div class="alert alert-success" role="alert">
        <p>Короткая ссылка:  <?= Html::a(Yii::$app->request->serverName . "/" . $url->token, ['site/redirect', 'token' => $url->token], ["target" => "_blank"])?></a></p>
    </div>
<?php endif;?>

<div class="site-index">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin([
            'id' => 'minifier-url-form',
        ]) ?>
        <?= $form->field($model, 'long_url')->input('text', ['placeholder' => 'http://yoursite.com/'])->label('Ссылка для сокращения')?>
        <?= $form->field($model, 'expiry_at')->widget(DateTimePicker::class, [
            'pluginOptions' => [
                'autoclose' => true,
//                'startDate' => date("Y-m-d H:i"),
            ]
        ])->label('Срок действия сокращенной ссылки');?>
        <div class="form-group">
            <?= Html::submitButton('Сократить',['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

