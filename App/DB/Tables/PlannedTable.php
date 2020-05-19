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
			'id' => new IntegerField('id'),
			'account_src_id' => new IntegerField('account_src_id'),
			'account_dst_id' => new IntegerField('account_dst_id'),
			'relation_id' => new IntegerField('relation_id'),
			'relation_type' => new IntegerField('relation_type'),
			'relation_param' => new FloatField('relation_param'),
			'description' => new StringField('description'),
			'total' => new MoneyField('total')
		];
	}
}