<?php

namespace app\controllers;

use app\models\ChannelForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ChannelsController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['login', 'error'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['/login']);
                },
            ],
        ];
    }

    public function actionCreate(): string
    {
        $model = new ChannelForm();

        if ($model->load(Yii::$app->request->post())) {
            $channel = new ChannelForm();
            $channel->channel_name = $model->channel_name;
            $channel->description = $model->description;
            $channel->link = $model->link;
            $channel->status = $model->status;
            $channel->created_at = $model->created_at;
            $channel->updated_at = $model->updated_at;
            $channel->save();

            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }
}