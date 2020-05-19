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
			'id' => new IntegerField($this, 'id'),
			'left_margin' => new IntegerField($this, 'left_margin'),
			'right_margin' => new IntegerField($this, 'right_margin'),
			'parent_id' => new IntegerField($this, 'parent_id'),
			'name' => new StringField($this, 'name'),
			'short_name' => new StringField($this, 'short_name'),
			'group_id' => new IntegerField($this, 'group_id'),
			'type_id' => new IntegerField($this, 'type_id'),
			'default_partner' => new IntegerField($this, 'default_partner'),
		];
	}
}