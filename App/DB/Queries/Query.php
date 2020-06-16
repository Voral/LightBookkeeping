<?php


namespace App\DB\Queries;

use App\DB\Tables\Table;

abstract class Query
{
	/** @var Table */
	protected $table;

	public function __construct(Table $table)
	{
		$this->table = $table;
	}

	public function get(): string
	{
		return '';
	}
}