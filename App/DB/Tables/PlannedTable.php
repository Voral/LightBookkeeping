<?php


namespace App\DB\Tables;


use App\DB\Fields\FloatField;
use App\DB\Fields\IntegerField;
use App\DB\Fields\MoneyField;
use App\DB\Fields\StringField;

class PlannedTable extends Table
{
	public function __construct()
	{
		$this->name = 'planned';
		$this->alias = 'p';
		$this->fields = [
			'id' => new IntegerField($this, 'id'),
			'account_src_id' => new IntegerField($this, 'account_src_id'),
			'account_dst_id' => new IntegerField($this, 'account_dst_id'),
			'relation_id' => new IntegerField($this, 'relation_id'),
			'relation_type' => new IntegerField($this, 'relation_type'),
			'relation_param' => new FloatField($this, 'relation_param'),
			'description' => new StringField($this, 'description'),
			'total' => new MoneyField($this, 'total')
		];
	}
}