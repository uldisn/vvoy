<?php

class m140907_121801_create_vpdm extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `vpdm_planing_dimension` (
              `vpdm_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `vpdm_vvoy_id` INT(10) UNSIGNED NOT NULL COMMENT 'Reiss',
              `vpdm_fdm2_id` INT(10) UNSIGNED NOT NULL COMMENT 'dimension 2 level',
              `vpdm_base_amt` DECIMAL(10,2) NOT NULL,
              PRIMARY KEY (`vpdm_id`),
              KEY `vpdm_vvoy_id` (`vpdm_vvoy_id`),
              KEY `vpdm_fdm2_id` (`vpdm_fdm2_id`),
              CONSTRAINT `vpdm_dimension_ibfk_1` FOREIGN KEY (`vpdm_vvoy_id`) REFERENCES `vvoy_voyage` (`vvoy_id`),
              CONSTRAINT `vpdm_planing_ibfk_2` FOREIGN KEY (`vpdm_fdm2_id`) REFERENCES `fdm2_dimension2` (`fdm2_id`)
            ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8


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
