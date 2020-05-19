<?php


namespace App\DB\Tables;


use App\DB\Fields\IntegerField;
use App\DB\Fields\StringField;

class GroupTable extends Table
{
	public function __construct()
	{
		$this->name = 'account_group';
		$this->alias = 'gr';
		$this->fields = [
			'id' => new IntegerField('id'),
			'name' => new StringField('name')
		];
	}
}