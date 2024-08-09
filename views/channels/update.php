<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChannelForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="your-model-form">

    <?php $form = ActiveForm::begin([
        'id' => 'update-form',
        'enableAjaxValidation' => true,
        'action' => ['your-controller/update', 'id' => $model->id],
    ]); ?>

    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel_bot')->textInput(['maxlength' => true]) ?>
    <!-- Добавьте дополнительные поля формы -->

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
