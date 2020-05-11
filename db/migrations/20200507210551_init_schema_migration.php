<?php

use Phinx\Migration\AbstractMigration;

class InitSchemaMigration extends AbstractMigration
{
	public function up()
	{
		$sql = file_get_contents('db/data/initSchema.sql', true);
		$this->query($sql);
	}

	public function down()
	{
		$this->execute('SET foreign_key_checks = 0;');
		$sql = file_get_contents('db/data/dropSchema.sql', true);
		$this->execute($sql);
		$this->execute('SET foreign_key_checks = 1;');
	}
}
