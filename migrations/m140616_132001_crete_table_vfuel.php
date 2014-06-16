<?php

class m140616_132001_crete_table_vfuel extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `aaps_apsargi` ADD `aaps_tabeles_nr` CHAR( 10 ) NULL AFTER `aaps_uzvards`;
        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
		$this->execute("
            ALTER TABLE `aaps_apsargi` DROP `aaps_tabeles_nr`;
        ");
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
