<?php
namespace mix8872\useradmin\migrations;

use yii\db\Migration;

/**
 * Class m180524_053921_add_readonly_field_to_config_table
 */
class m180524_053921_add_readonly_field_to_config_table extends Migration
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
