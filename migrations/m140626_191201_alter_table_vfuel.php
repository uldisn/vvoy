<?php

class m140626_191201_alter_table_vfuel extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
          ALTER TABLE `vfue_fuel`   
              DROP COLUMN `vfue_ccnt_id`, 
              DROP COLUMN `vfue_company`, 
              DROP COLUMN `vfue_comapny_reg_number`, 
              DROP COLUMN `vfue_series`, 
              DROP COLUMN `vfue_fvat_id`, 
              DROP COLUMN `vfue_vat`, 
              DROP COLUMN `vfue_total`, 
              DROP COLUMN `vfue_vase_vat`, 
              DROP COLUMN `vfue_base_total`, 
              CHANGE `vfue_amt` `vfue_amt` DECIMAL(10,2) UNSIGNED NULL  AFTER `vfue_qnt`, 
              DROP INDEX `vfue_ccnt_id`,
              DROP FOREIGN KEY `vfue_fuel_ibfk_2`;


        ");
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
		$this->execute("
            TRUNCATE TABLE `vfue_fuel`;
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
