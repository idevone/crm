<?php

use app\models\Pixel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$pixels = Pixel::find()->all();
$pixelOptions = ArrayHelper::map($pixels, 'pixel_id', function ($element) {
    return $element['pixel_id'] . ' - ' . $element['owner'];
});
?>

    <div class="user-create">

        <div class="user-form">

            <?php $form = ActiveForm::begin([
                'id' => 'create-user-form',
                'options' => ['data-pjax' => false],
                'enableClientValidation' => true,
            ]); ?>

            <?= $form->field($model, 'channel_name')->textInput(['autofocus' => true, 'placeholder' => 'Название для системы'])->label('Название канала') ?>
            <?= $form->field($model, 'channel_link')->textInput(['placeholder' => 'https://t.me/+RuNsUestWWJhNjRi'])->label('Ссылка на канал') ?>
            <?= $form->field($model, 'channel_bot')->textInput(['placeholder' => '7378948848:AAGsMrHRTi7WCu6-qMPo0MWFZl3A0W1Ii7Q'])->label('Токен для бота') ?>

<!--            --><?php //= $form->field($model, 'channel_pixel')->dropDownList(
//                $pixelOptions
//            )->label('Пиксель') ?>

            <div id="pixel-fields">
                <div class="pixel-field">
                    <?= $form->field($model, 'channel_pixel[]')->dropDownList(
                        $pixelOptions,
                        ['prompt' => 'Выберите пиксель']
                    )->label('Пиксель') ?>
                    <button type="button" class="btn btn-success add-pixel">+</button>
                    <button type="button" class="btn btn-danger remove-pixel">-</button>
                </div>
            </div>

            <div class="form-group mt-5">
                <?= Html::submitButton('Добавить платеж', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

<?php
$js = <<<JS
// Добавить пиксель
$(document).on('click', '.add-pixel', function() {
    var pixelField = $(this).closest('.pixel-field').clone();
    pixelField.find('select').val(''); // очистить значение нового поля
    pixelField.find('.add-pixel').remove(); // удалить кнопку + из нового поля
    pixelField.find('.remove-pixel').remove(); // удалить кнопку - из нового поля
    pixelField.append('<button type="button" class="btn btn-danger remove-pixel">-</button>'); // добавить кнопку - в новое поле
    $('#pixel-fields').append(pixelField);
});

// Удалить пиксель
$(document).on('click', '.remove-pixel', function() {
    if ($('.pixel-field').length > 1) {
        $(this).closest('.pixel-field').remove();
    } else {
        alert('Должен быть хотя бы один пиксель.');
    }
});
JS;

$this->registerJs($js);
?>