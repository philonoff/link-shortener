<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\forms\UpdateEmailForm */

$this->title = "Изменить email";
$this->params['breadcrumbs'][] = [
    'label' => 'Кабинет',
    'url' => Url::to(['cabinet/index']),
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-signup col-lg-5">
    <h1><?=Html::encode($this->title)?></h1>
    <?php
    $form = ActiveForm::begin([
        'id' => 'update-email-form',
        'enableAjaxValidation' => true,
    ]);
    ?>
    <i class="bi bi-clipboard"></i>
    <?= $form->field($model, 'new_email')->label('Новый email')?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>
