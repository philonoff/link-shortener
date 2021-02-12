<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model app\models\forms\RequestPasswordResetForm */

$this->title = "Запрос на восстановление пароля";
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="col-lg-10"><?=Html::encode($this->title)?></h1>
<div class="site-signup col-lg-5">
    <?php
    $form = ActiveForm::begin([
        'id' => 'reset-password-form',
    ]);
    ?>
    <?= $form->field($model, 'email')->label('Email')->hint("Ссылка для восстановления пароля будет отправлена на указаный email.")?>
    <div class="form-group">
        <?= Html::submitButton('Отправить',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>
