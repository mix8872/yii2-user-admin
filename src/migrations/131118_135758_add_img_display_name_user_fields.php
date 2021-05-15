<?php
namespace mix8872\useradmin\migrations;

use yii\db\Migration;

/**
 * Class 131118_135758_add_img_display_name_user_fields
 */
class 131118_135758_add_img_display_name_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{user}}', 'display_name', $this->string(255));
        $this->addColumn('{{user}}', 'img', $this->string(255) . ' DEFAULT ""');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{user}}', 'display_name');
        $this->dropColumn('{{user}}', 'img');
    }
}
