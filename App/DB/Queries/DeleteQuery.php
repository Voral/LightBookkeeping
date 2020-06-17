<?php


namespace App\DB\Queries;


use App\DB\Fields\TableField;
use App\DB\Tables\Table;

class DeleteQuery extends WhereQuery
{
	public function __construct(Table $table, Where $where)
	{
		parent::__construct($table);
		$this->setWhere($where);
	}

	public function get(): string
	{
		TableField::setShowTableAlias(false);
		$sql = [sprintf('%s from %s','delete', $this->table->getName())];
		$this->generateWhere($sql);
		TableField::setShowTableAlias(true);
		return implode(' ',$sql);
	}
}