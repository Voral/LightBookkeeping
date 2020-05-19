<?php


namespace App\DB\Queries;

use App\DB\Tables\Table;

abstract class Query
{
	/** @var Table */
	protected $table;
	protected $aliasRegistry = [];

	public function __construct(Table $table)
	{
		$this->table = $table;
		$this->addAlias($table);
	}

	public function addAlias(Table $table): void
	{
		$arRegistry = array_values($this->aliasRegistry);
		$i = 0;
		$alias = $table->getAlias();
		while (array_key_exists($alias, $arRegistry)) {
			$alias = sprintf('%s%d', $table->getAlias(), $i++);
		}
		$this->aliasRegistry[spl_object_id($table)] = $alias;
	}

	public function get(): string
	{
		return '';
	}
}