<?php

use yii\db\Migration;

/**
 * Class m190426_104441_init_t
 */
class m190426_104441_init_t extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(16)->notNull(),
            'password' => $this->string(16)->notNull(),
            'token' => $this->string(32)->Null()->unique(),
        ]);

        $this->createTable('performers', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(128)->notNull(),
            'profession' => $this->string(128)->notNull(),
            'photo' => $this->string(128)->notNull(),
            'user' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-1-performer',
            'performers',
            'user',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('professions', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
        ]);

        $this->createTable('organizations', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
        ]);

        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'user' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-1-orders',
            'orders',
            'user',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            //'user' => $this->integer(),
            'performer' => $this->integer()->notNull(),
            'profession' => $this->integer()->notNull(),
            'organization' => $this->integer()->notNull(),
            'order_id' => $this->integer(),
            'date_or_status' => $this->string(11)->notNull(),
            'days' => $this->integer()->notNull(),
        ]);

        /*$this->addForeignKey(
            'fk-1-order_detail',
            'order_detail',
            'user',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );*/

        $this->addForeignKey(
            'fk-2-order_detail',
            'order_detail',
            'performer',
            'performers',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-3-order_detail',
            'order_detail',
            'profession',
            'professions',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-4-order_detail',
            'order_detail',
            'organization',
            'organizations',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-5-order_detail',
            'order_detail',
            'order_id',
            'orders',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->insert('professions',
            ['name' => 'менеджер проектов']);
        $this->insert('professions',
            ['name' => 'архитектор проектов']);
        $this->insert('professions',
            ['name' => 'программист']);
        $this->insert('professions',
            ['name' => 'тестировщик']);
        $this->insert('professions',
            ['name' => 'верстальщик']);
        $this->insert('professions',
            ['name' => 'дизайнер']);
        $this->insert('professions',
            ['name' => 'копирайтер']);

        $this->insert('organizations',
            ['name' => 'OOO "Рога и копыта"']);
        $this->insert('organizations',
            ['name' => 'OАO "Шито крыто"']);
        $this->insert('organizations',
            ['name' => 'ПАO "Исполнито"']);
        $this->insert('organizations',
            ['name' => 'ЗАO "Программ налито"']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('organizations', ['id' => 4]);
        $this->delete('organizations', ['id' => 3]);
        $this->delete('organizations', ['id' => 2]);
        $this->delete('organizations', ['id' => 1]);

        $this->delete('professions', ['id' => 7]);
        $this->delete('professions', ['id' => 6]);
        $this->delete('professions', ['id' => 5]);
        $this->delete('professions', ['id' => 4]);
        $this->delete('professions', ['id' => 3]);
        $this->delete('professions', ['id' => 2]);
        $this->delete('professions', ['id' => 1]);

        $this->dropForeignKey(
            'fk-5-performer',
            'order_detail'
        );

        $this->dropForeignKey(
            'fk-4-performer',
            'order_detail'
        );

        $this->dropForeignKey(
            'fk-3-performer',
            'order_detail'
        );

        $this->dropForeignKey(
            'fk-2-performer',
            'order_detail'
        );

        /*$this->dropForeignKey(
            'fk-1-performer',
            'order_detail'
        );*/

        $this->dropTable('order_detail');
        $this->dropForeignKey(
            'fk-1-orders',
            'orders'
        );

        $this->dropTable('orders');
        $this->dropTable('organizations');
        $this->dropTable('professions');
        $this->dropForeignKey(
            'fk-1-performer',
            'performer'
        );

        $this->dropTable('performer');

        $this->dropTable('user');

        //echo "m190426_104441_init_t cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190426_104441_init_t cannot be reverted.\n";

        return false;
    }
    */
}
