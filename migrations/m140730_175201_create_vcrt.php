<?php

class m140730_175201_create_vcrt extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
                CREATE TABLE `vcrt_vvoy_currency_rate`(  
                  `vcrt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                  `vcrt_vvoy_id` INT UNSIGNED NOT NULL,
                  `vcrt_base_fcrn_id` TINYINT UNSIGNED NOT NULL,
                  `vcrt_fcrn_id` TINYINT UNSIGNED NOT NULL,
                  `vcrt_date` DATE NOT NULL,
                  `vcrt_rate` DECIMAL(12,6) UNSIGNED NOT NULL,
                  `vcrt_rate_org` DECIMAL(12,6) UNSIGNED NOT NULL,

                  PRIMARY KEY (`vcrt_id`)
                ) ENGINE=INNODB CHARSET=utf8;

                ALTER TABLE `vcrt_vvoy_currency_rate` ADD FOREIGN KEY (`vcrt_base_fcrn_id`) REFERENCES `fcrn_currency`(`fcrn_id`); 
                ALTER TABLE `vcrt_vvoy_currency_rate` ADD FOREIGN KEY (`vcrt_fcrn_id`) REFERENCES `fcrn_currency`(`fcrn_id`); 
                ALTER TABLE `vcrt_vvoy_currency_rate` ADD FOREIGN KEY (`vcrt_vvoy_id`) REFERENCES `vvoy_voyage`(`vvoy_id`); 


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
