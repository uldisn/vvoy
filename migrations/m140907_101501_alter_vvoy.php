<?php

class m140907_101501_alter_vvoy extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            ALTER TABLE `vvoy_voyage`   
              ADD COLUMN `vvoy_plan_start_date` DATETIME NULL AFTER `vvoy_fcrn_plan_date`,
              ADD COLUMN `vvoy_plan_end_date` DATETIME NULL AFTER `vvoy_plan_start_date`;

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
