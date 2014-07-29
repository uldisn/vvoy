<?php

class m140729_152401_alter_table_vvoy extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vvoy_voyage`   
                CHANGE `vvoy_status` `vvoy_status` ENUM('project','accepted','in way','finished','closed','canceled') CHARSET utf8 COLLATE utf8_general_ci NULL;

        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
	
	}

	/**
	 * Creates initial version of the table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
