<?php

class m140907_101401_create_vdim extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{
		$this->execute("
            CREATE TABLE `vdim_dimension` (
              `vdim_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `vdim_vvoy_id` int(10) unsigned NOT NULL COMMENT 'Reiss',
              `vdim_fdm2_id` int(10) unsigned NOT NULL COMMENT 'dimension 2 level',
              `vdim_base_amt` decimal(10,2) NOT NULL,
              PRIMARY KEY (`vdim_id`),
              KEY `vdim_vvoy_id` (`vdim_vvoy_id`),
              KEY `vdim_fdm2_id` (`vdim_fdm2_id`),
              CONSTRAINT `vdim_dimension_ibfk_1` FOREIGN KEY (`vdim_vvoy_id`) REFERENCES `vvoy_voyage` (`vvoy_id`),
              CONSTRAINT `vdim_dimension_ibfk_2` FOREIGN KEY (`vdim_fdm2_id`) REFERENCES `fdm2_dimension2` (`fdm2_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8
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
