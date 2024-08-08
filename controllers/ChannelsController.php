<?php

namespace app\controllers;

use app\models\ChannelForm;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use GuzzleHttp\Client;

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

    public function actionCreate()
    {
        $model = new ChannelForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->channel_name = Yii::$app->request->post('ChannelForm')['channel_name'];
            $model->channel_id = Yii::$app->request->post('ChannelForm')['channel_id'];
            $model->channel_bot = Yii::$app->request->post('ChannelForm')['channel_bot'];
            $model->responsible = Yii::$app->user->id;
            $model->invite_link = Yii::$app->request->post('ChannelForm')['invite_link'];
            $model->fb_pixel = implode(',', Yii::$app->request->post('ChannelForm')['selectedPixels']);
            $model->telegram_account = Yii::$app->request->post('ChannelForm')['telegram_account'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::debug('Channel saved: ' . json_encode($model->attributes), __METHOD__);

                $client = new Client();

                $apiUrl = 'http://localhost:8000/bots';
                $botConfig = [
                    'channel_name' => $model->channel_name,
                    'channel_id' => $model->channel_id,
                    'invite_link' => $model->invite_link,
                    'pixel_id' => $model->fb_pixel,
                    'token' => $model->channel_bot
                ];

                $response = $client->post($apiUrl, [
                    'json' => $botConfig
                ]);

                return $this->redirect(['index']);
            } else {
                Yii::error('Save failed: ' . json_encode($model->errors), __METHOD__);
                throw new \yii\web\ServerErrorHttpException('Ошибка при сохранении данных: ' . json_encode($model->errors));
            }
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

    protected function runBot($botId)
    {
        $bot = new TelegramBot($botId);
        try {
            $bot->start();
        } catch (\Exception $e) {
            Yii::error('Error starting bot: ' . $e->getMessage(), __METHOD__);
            throw new \yii\web\ServerErrorHttpException('Ошибка при запуске бота: ' . $e->getMessage());
        }
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }
}