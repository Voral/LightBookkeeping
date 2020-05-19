<?php


namespace App\DB\Tables;


use App\DB\Fields\IntegerField;
use App\DB\Fields\StringField;

class AccountTable extends Table
{
	public function __construct()
	{
		$this->name = 'account';
		$this->alias = 'a';
		$this->fields = [
			'id' => new IntegerField('id'),
			'left_margin' => new IntegerField('left_margin'),
			'right_margin' => new IntegerField('right_margin'),
			'parent_id' => new IntegerField('parent_id'),
			'name' => new StringField('name'),
			'short_name' => new StringField('short_name'),
			'group_id' => new IntegerField('group_id'),
			'type_id' => new IntegerField('type_id'),
			'default_partner' => new IntegerField('default_partner'),
		];
	}
}