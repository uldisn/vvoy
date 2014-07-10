<?php

class m140709_181001_alter_table_vvpo extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
        ALTER TABLE `vvpo_voyage_point`   
            ADD COLUMN `vvpo_plan_amt` DECIMAL(10,2) UNSIGNED NULL AFTER `vvpo_plan_fcrn_id`,
            ADD COLUMN `vvpo_plan_base_amt` DECIMAL(10,2) UNSIGNED NULL AFTER `vvpo_plan_amt`,
            ADD COLUMN `vvpo_base_amt` DECIMAL(10,2) NULL AFTER `vvpo_plan_base_amt`;

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
