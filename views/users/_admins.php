<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\components\UsersGridView;

if (Yii::$app->user->identity->role == 'Admin') {
    echo UsersGridView::widget(['role' => 'All']);
} else {
    echo UsersGridView::widget(['role' => Yii::$app->user->identity->role]);
}