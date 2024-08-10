<?php

use yii\db\Migration;

/**
 * Class m240810_151955_remove_unique_constraint_from_fb_pixel
 */
class m240810_151955_remove_unique_constraint_from_fb_pixel extends Migration
{
    public function safeUp()
    {
        $this->dropIndex('telegram_channel_fb_pixel_key', '{{%telegram_channel}}');
    }

    public function safeDown()
    {
        $this->createIndex('telegram_channel_fb_pixel_key', '{{%telegram_channel}}', 'fb_pixel', true);
    }
}
