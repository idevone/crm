<?php

namespace app\models;

use yii\db\ActiveRecord;

class ChannelForm extends ActiveRecord
{
    public $channel_name;
    public $description;
    public $channel_link;
    public $channel_pixel;
    public $status;
    public $created_at;
    public $updated_at;

    public static function tableName()
    {
        return '{{%telegram_channel}}';
    }
    public function rules()
    {
        return [
            [['channel_name', 'description', 'link', 'status'], 'required'],
            [['channel_name', 'description', 'link'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'channel_name' => 'Название канала',
            'description' => 'Описание',
            'link' => 'Ссылка',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

}