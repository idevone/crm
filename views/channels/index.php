<?php

use yii\bootstrap5\Modal;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Telegram каналы';
?>
<div class="users-index mt-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="mt-5">
        <?= Html::button('Добавить новый канал', ['value' => Url::to(['channels/create']), 'class' => 'btn btn-primary', 'id' => 'modalButton']) ?>
    </p>


    <?php
    Modal::begin([
        'title' => '<h4>Добавление новой записи</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'>";
    $this->render('create', ['model' => new \app\models\ChannelForm()]);
    echo "</div>";
    ?>

    <?php
    Modal::end();
    ?>
    <?php

    $script = <<< JS
        $(function() {
            $('#modalButton').click(function() {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            });
        });
        JS;
    $this->registerJs($script);
    ?>
</div>